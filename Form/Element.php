<?php

namespace TuxBoy\Form;

class Element
{
    /**
     * @var null|string
     */
    private $name;

    /**
     * @var bool
     */
    private $endTag;

    /**
     * @var Attribute[]
     */
    private $attributes = [];

    /**
     * @var string|string[]
     */
    private $content;

    /**
     * Element constructor.
     *
     * @param null|string $name   Le nom de l'element
     * @param bool        $endTag Si true, sera alors une balise html fermante
     */
    public function __construct(?string $name = null, bool $endTag = false)
    {
        $this->name = $name;
        $this->endTag = $endTag;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->attributes) {
            $class = $this->getAttribute('class');
            if ($class && strpos($class->getValue(), ' ')) {
                $classes = explode(' ', $class->getValue());
                sort($classes);
                $class->setValue(implode(' ', $classes));
            }
            ksort($this->attributes);
        }
        $content = $this->getContent();
        return '<' . $this->name . ' ' . implode(' ', $this->attributes) . '>'
            . (($this->endTag || isset($content)) ? $content . '</' . $this->name . '>' : '');
    }

    /**
     * @param string|null $name
     * @param string|null $value
     *
     * @return Attribute
     */
    public function setAttribute(?string $name = null, ?string $value = null): Attribute
    {
        return $this->setAttributeNode(new Attribute($name, $value));
    }

    /**
     * @param Attribute $attribute
     * @return Attribute
     */
    public function setAttributeNode(Attribute $attribute): Attribute
    {
        return $this->attributes[$attribute->getName()] = $attribute;
    }

    /**
     * Ajoute un attribut classe s'il n'existe pas, sinon il ajoute juste la classe à la suite.
     *
     * @param string $className
     * @return string
     */
    public function addClass(string $className) : string
    {
        $class = $this->getAttribute('class');
        if (!isset($class)) {
            return $this->setAttribute('class', $className);
        } elseif (strpos(' ' . $class->getValue() . ' ', $className) === false) {
            $class->value .= ' ' . $className;
        }
        return $class;
    }

    /**
     * @param string $name
     * @return Attribute
     */
    public function getAttribute(string $name): ?Attribute
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * @return Attribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return string|string[]
     */
    public function getContent()
    {
        if (is_array($this->content)) {
            $content = '';
            if ($this->content) {
            } else {
                $content = '';
            }

            return $content;
        }

        return $this->content;
    }

    /**
     * @param $content string
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
