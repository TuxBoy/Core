<?php

namespace TuxBoy\Twig;

use TuxBoy\Entity;
use TuxBoy\Form\Builder\EntityFormBuilder;
use TuxBoy\Form\Builder\FormBuilder;
use TuxBoy\Router\Router;

class FormExtension extends \Twig_Extension
{

    /**
     * @var EntityFormBuilder
     */
    private $entityFormBuilder;

    /**
     * @var Router
     */
    private $router;

    public function __construct(EntityFormBuilder $entityFormBuilder, Router $router)
    {
        $this->entityFormBuilder = $entityFormBuilder;
        $this->router = $router;
    }

    /**
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('formBuilder', [$this, 'getForm'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('form', [$this, 'getFormWithEntity'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param FormBuilder $formBuilder
     *
     * @return string
     */
    public function getForm(FormBuilder $formBuilder): string
    {
        return (string) $formBuilder->build();
    }

    /**
     * @param Entity      $entity
     * @param null|string $path
     * @return string
     */
    public function getFormWithEntity(Entity $entity, ?string $path = null): string
    {
        $path = $path ? $this->router->generateUri($path) : $path;
        return (string) $this->entityFormBuilder->generateForm($entity, $path);
    }
}
