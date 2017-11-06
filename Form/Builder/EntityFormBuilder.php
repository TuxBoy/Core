<?php
namespace TuxBoy\Form\Builder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use TuxBoy\Annotation\Option;
use TuxBoy\Annotation\Set;
use TuxBoy\Builder\Builder;
use TuxBoy\Builder\Namespaces;
use TuxBoy\Entity;
use TuxBoy\Form\Button;
use TuxBoy\Form\Element;
use TuxBoy\Form\Input;
use TuxBoy\Form\Select;
use TuxBoy\Form\Textarea;
use TuxBoy\ReflectionAnnotation;
use TuxBoy\Session\SessionInterface;

/**
 * Class EntityFormBuilder
 */
class EntityFormBuilder
{

    /**
     * @var FormBuilder
     */
    private $formBuilder;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var Connection
     */
    private $connection;

    /**
     * EntityFormBuilder constructor.
     *
     * @param FormBuilder $formBuilder
     * @param SessionInterface $session
     * @param Connection $connection
     */
    public function __construct(FormBuilder $formBuilder, SessionInterface $session, Connection $connection)
    {
        $this->formBuilder = $formBuilder;
        $this->session = $session;
        $this->errors = $this->getErrors();
        $this->connection = $connection;
    }

    /**
     * Génère un formulaire à partir d'une entity.
     *
     * @param Entity $entity
     * @param string|null $action
     * @return string
     */
    public function generateForm(Entity $entity, ?string $action = null): string
    {
        // En gros ça va lire toutes les proriétés de l'entity afin de construire le formulaire
        if (is_null($action)) {
            $action = '#';
        }
        $this->formBuilder->openForm($action, 'POST');
        foreach (array_keys(get_object_vars($entity)) as $property) {
            $divElement = new Element('div');
            $divElement->addClass('form-group');
            $this->formBuilder->add($divElement);
            $this->addField($entity, $property);
            $this->addObjectField($entity, $property);
            $this->formBuilder->add('</div>');
        }
        $button = new Button('Envoyer');
        $button->setAttribute('type', 'submit');
        $button->addClass('btn btn-primary');
        $this->formBuilder->add($button);
        return $this->formBuilder->build();
    }

    /**
     * @param Entity $entity
     * @param string $property
     */
    private function addObjectField(Entity $entity, string $property): void
    {
        $propertyAnnotation = new ReflectionAnnotation($entity, $property);
        $annotationValue    = $propertyAnnotation->getAnnotation('var')->getValue();
        if (!in_array($annotationValue, [Type::STRING, Type::TEXT, Type::INTEGER])) {
            $object = Builder::create($annotationValue);
            if (is_a($object, Entity::class)) {
                $fieldName = mb_strtolower(Namespaces::shortClassName($object)) . '_id';
                $data      = $this->getDataToList($object);
                $select    = new Select($fieldName, $data);
                $select->addClass('form-control');
                $this->formBuilder->add($select);
            }
        }
    }

    /**
     * @param $object
     * @return array
     */
    private function getDataToList($object): array
    {
        $annotationForeign = new ReflectionAnnotation($object);
        $results = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($annotationForeign->getClassAnnotation(Set::class)->tableName)
            ->execute()->fetchAll(\PDO::FETCH_CLASS, get_class($object));
        $data = [];
        foreach ($results as $result) {
            /** @var $result Entity */
            $data[$result->get('id')] = (string) $result;
        }
        return $data;
    }

    /**
     * @return array
     */
    private function getErrors(): array
    {
        return $this->session->get('errors') ?? [];
    }

    /**
     * Ajoute la classe error au champ en erreur et la description de l'erreur dans une div.
     *
     * @param Element $element Le champ qui est en erreur
     * @param string $property
     * @return Element
     */
    private function addErrorField(Element $element, string $property): ?Element
    {
        $span = null;
        if (isset($this->errors[$property]) && !empty($this->errors[$property])) {
            $element->addClass('is-invalid');
            $span = new Element('div', true);
            $span->addClass('invalid-feedback');
            if (is_array($this->errors[$property])) {
                $span->setContent(implode(', ', $this->errors[$property]));
            } else {
                $span->setContent($this->errors[$property]);
            }
            $this->session->delete('errors');
        } else {
            $element->removeClass('is-invalid');
        }
        return $span;
    }

    /**
     * @param Entity $entity
     * @param string $property
     */
    private function addField(Entity $entity, string $property): void
    {
        $propertyAnnotation = new ReflectionAnnotation($entity, $property);
        if ($propertyAnnotation->hasAnnotation('var')
            && $propertyAnnotation->getAnnotation('var')->getValue() === Type::STRING
        ) {
            $value = null;
            if (property_exists(get_class($entity), $property) && $entity->get($property)) {
                $value = $entity->get($property);
            }
            $input = new Input($property, $value);
            $input->addClass('form-control');
            if ($propertyAnnotation->getPropertyAnnotation(Option::class)) {
                $optionAnnoation = $propertyAnnotation->getPropertyAnnotation(Option::class);
                $type = $optionAnnoation->type ? $optionAnnoation->type : Type::TEXT;
                if ($optionAnnoation->mandatory) {
                    $input->setAttribute('required');
                }
                if ($optionAnnoation->placeholder) {
                    $input->setAttribute('placeholder', $optionAnnoation->placeholder);
                }
            } else {
                $type = Type::TEXT;
            }
            $input->setAttribute('type', $type);
            $span = $this->addErrorField($input, $property);
            $this->formBuilder->add($input . $span);
        }

        if ($propertyAnnotation->hasAnnotation('var')
            && $propertyAnnotation->getAnnotation('var')->getValue() === Type::TEXT
        ) {
            $value = null;
            if (property_exists(get_class($entity), $property) && $entity->get($property)) {
                $value = $entity->get($property);
            }
            $textarea = new Textarea($property, $value);
            if ($propertyAnnotation->getPropertyAnnotation(Option::class)) {
                $optionAnnoation = $propertyAnnotation->getPropertyAnnotation(Option::class);
                if ($optionAnnoation->mandatory) {
                    $textarea->setAttribute('required');
                }
                if ($optionAnnoation->placeholder) {
                    $textarea->setAttribute('placeholder', $optionAnnoation->placeholder);
                }
            }
            $textarea->setAttribute('class', 'form-control');
            $this->formBuilder->add($textarea);
            $this->addErrorField($textarea, $property);
        }
    }
}
