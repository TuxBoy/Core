<?php
namespace Test\TuxBoy\Form;

use PHPUnit\Framework\TestCase;
use TuxBoy\Entity;
use TuxBoy\Form\Builder\EntityFormBuilder;
use TuxBoy\Form\Builder\FormBuilder;
use TuxBoy\Session\ArraySession;
use TuxBoy\Session\SessionInterface;

class Fake extends Entity
{
    /**
     * @var string
     */
    public $name;
}

class Demo extends Entity
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var text
     */
    public $content;
}

class EntityFormBuilderTest extends TestCase
{

    /**
     * @var EntityFormBuilder
     */
    private $builder;

    /**
     * @var FormBuilder
     */
    private $formBuilder;

    /**
     * @var SessionInterface
     */
    private $session;

    public function setUp()
    {
        $this->session = new ArraySession;
        $this->formBuilder = new FormBuilder();
        $this->builder = new EntityFormBuilder($this->formBuilder, $this->session);
    }

    public function testGenerateSimpleForm()
    {
        $entity = new Fake;
        $this->assertContains(
            '<form action="/demo" method="POST"> <div class="form-group"> <input class="form-control" name="name" type="text"> </div> <button class="btn btn-primary" type="submit">Envoyer</button> </form>',
            $this->builder->generateForm($entity, '/demo')
        );
    }

    public function testGenerateFormWithParameters()
    {
        $entity = new Demo;
        $this->assertEquals(
            '<form action="/demo" method="POST"> <div class="form-group"> <input class="form-control" name="name" type="text"> </div> <div class="form-group"> <input class="form-control" name="slug" type="text"> </div> <div class="form-group"> <textarea class="form-control" name="content"></textarea> </div> <button class="btn btn-primary" type="submit">Envoyer</button> </form>',
            $this->builder->generateForm($entity, '/demo')
        );
    }

    public function testGenerateFormWithData()
    {
        $entity = new Demo;
        $entity->set('name', 'joe');
        $entity->set('slug', 'un-test');
        $entity->set('content', 'Du contenu');
        $this->assertEquals(
            '<form action="/demo" method="POST"> <div class="form-group"> <input class="form-control" name="name" type="text" value="joe"> </div> <div class="form-group"> <input class="form-control" name="slug" type="text" value="un-test"> </div> <div class="form-group"> <textarea class="form-control" name="content">Du contenu</textarea> </div> <button class="btn btn-primary" type="submit">Envoyer</button> </form>',
            $this->builder->generateForm($entity, '/demo')
        );
    }
}
