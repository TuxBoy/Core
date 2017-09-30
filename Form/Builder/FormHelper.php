<?php
namespace TuxBoy\Form\Builder;

use TuxBoy\Form\Button;
use TuxBoy\Form\Element;
use TuxBoy\Form\Input;

class FormHelper
{

    /**
     * @param string $name
     * @param string $label
     * @param string $type
     * @return Element
     */
    protected function input(string $name, string $label, string $type = 'text'): Element
    {
        $input = new Input($name);
        $input->addClass('form-control');
        $input->setAttribute('type', $type);
        $input->setAttribute('placeholder', $label);
        $div = new Element('div', true);
        $div->addClass('form-group');
        $div->setContent($input);
        return $div;
    }

    /**
     * @param string $text
     * @return Button
     */
    protected function button(string $text): Button
    {
        $button = new Button($text);
        $button->addClass('btn');
        $button->addClass('btn-primary');
        return $button;
    }
}