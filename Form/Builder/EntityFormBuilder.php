<?php
namespace TuxBoy\Form\Builder;

use Doctrine\DBAL\Types\Type;
use TuxBoy\Annotation\Option;
use TuxBoy\Entity;
use TuxBoy\Form\Button;
use TuxBoy\Form\Element;
use TuxBoy\Form\Input;
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
     * EntityFormBuilder constructor.
     *
     * @param FormBuilder $formBuilder
     * @param SessionInterface $session
     */
	public function __construct(FormBuilder $formBuilder, SessionInterface $session)
	{
		$this->formBuilder = $formBuilder;
        $this->session = $session;
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
			$propertyAnnotation = new ReflectionAnnotation($entity, $property);
			$divElement = new Element('div');
			$divElement->addClass('form-group');
			$this->formBuilder->add($divElement);
			$errors = $this->getErrors();
			if (
				$propertyAnnotation->hasAnnotation('var')
				&& $propertyAnnotation->getAnnotation('var')->getValue() === Type::STRING
			) {
				$value = null;
                if (property_exists(get_class($entity), $property) && $entity->get($property)) {
					$value = $entity->get($property);
				}
				$classAttribute = 'form-control';
                if (isset($errors[$property])) {
                    $classAttribute .= ' is-invalid';
                }
                $input = new Input($property, $value);
				$input->setAttribute('class', $classAttribute);
				if ($propertyAnnotation->getPropertyAnnotation(Option::class)) {
					$optionAnnoation = $propertyAnnotation->getPropertyAnnotation(Option::class);
					$type = $optionAnnoation->type ? $optionAnnoation->type : Type::TEXT;
					if ($optionAnnoation->mandatory) {
						$input->setAttribute('required');
					}
					if ($optionAnnoation->placeholder) {
					    $input->setAttribute('placeholder', $optionAnnoation->placeholder);
                    }
				}
				else {
					$type = Type::TEXT;
				}
				$input->setAttribute('type', $type);
				$this->formBuilder->add($input);
			}

			if (
				$propertyAnnotation->hasAnnotation('var')
				&& $propertyAnnotation->getAnnotation('var')->getValue() === Type::TEXT
			) {
				$value = null;
				if (property_exists(get_class($entity), $property) && $entity->get($property)) {
					$value = $entity->get($property);
				}
				$textarea = new Textarea($property, $value);
				$textarea->setAttribute('class', 'form-control');
				$this->formBuilder->add($textarea);
			}
            $this->formBuilder->add('</div>');
		}
		$button = new Button('Envoyer');
		$button->setAttribute('type', 'submit');
        $button->addClass('btn btn-primary');
		$this->formBuilder->add($button);
		return $this->formBuilder->build();
	}

    /**
     * @return array
     */
	private function getErrors(): array
    {
        return $this->session->get('errors') ?? [];
    }

}
