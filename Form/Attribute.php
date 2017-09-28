<?php
namespace TuxBoy\Form;

/**
 * Class Attribute
 */
class Attribute
{
    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null
     */
    public $value;

    public function __construct(?string $name = null, ?string $value = null)
    {
        if (!is_null($name)) {
            $this->name = $name;
        }
        if (!is_null($value)) {
            $this->value = $value;
        }
    }

    public function __toString()
    {
        if ($this->getValue() === true) {
            return $this->getName();
        } elseif ($this->getValue() === false) {
            return '';
        } else {
            return $this->name . (null !== $this->value ? '="' . $this->value . '"' : '');
        }
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param null $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
