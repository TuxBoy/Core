<?php

namespace TuxBoy\Tools;

use TuxBoy\Annotation\Option;

trait HasName
{
    /**
     * @var string
     *
     * @Option(placeholder="Nom")
     */
    public $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $name string
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
