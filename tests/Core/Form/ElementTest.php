<?php
namespace Test\TuxBoy\Form;

use TuxBoy\Form\Checkbox;
use TuxBoy\Form\Input;
use TuxBoy\Form\Select;
use TuxBoy\Form\Textarea;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{

    public function testInputField()
    {
        $input = new Input('username');
        $this->assertEquals('<input name="username">', (string) $input);
        $input = new Input('username', 'doe');
        $this->assertEquals('<input name="username" value="doe">', (string) $input);
    }

    public function testTextareaField()
    {
        $textarea = new Textarea('content');
        $this->assertEquals('<textarea name="content"></textarea>', (string) $textarea);
    }

    public function testTextareaFieldWithContent()
    {
        $textarea = new Textarea('content', 'Du contenu ici');
        $this->assertEquals('<textarea name="content">Du contenu ici</textarea>', (string) $textarea);
    }

    public function testSelectElement()
    {
        $values = [1 => 'Films', 2 => 'test'];
        $select = new Select('categories');
        $this->assertEquals('<select name="categories"></select>', (string) $select);
        $output = '<select name="categories"><option value="1">Films</option><option value="2">test</option></select>';
        $select = new Select('categories', $values);
        $this->assertEquals($output, (string) $select);
    }

    public function testSelectWithSelected()
    {
        $values = [1 => 'Films', 2 => 'test'];
        $select = new Select('categories', $values, 'test');
        $output = '<select name="categories"><option value="1">Films</option><option selected value="2">test</option></select>';
        $this->assertEquals($output, (string) $select);
    }

    public function testGetAttributeClassNotParsed()
    {
        $input = new Input('demo', 'demo');
        $input->setAttribute('class', 'test');
        $this->assertEquals('class="test"', $input->getAttribute('class'));
    }

    public function testAddClass()
    {
        $input = new Input('demo');
        $input->addClass('test');
        $this->assertEquals('<input class="test" name="demo">', (string) $input);
        $input->addClass('test2');
        $this->assertEquals('<input class="test test2" name="demo">', (string) $input);
    }

    public function testRemoveClass()
    {
        $input = new Input('demo');
        $input->addClass('test');
        $input->addClass('test2');
        $input->removeClass('test');

        $this->assertEquals('class="test2"', $input->getAttribute('class'));

        $input = new Input('demo2');
        $input->addClass('test');
        $input->removeClass('test');

        // $this->assertNull($input->getAttribute('class'));
    }
}
