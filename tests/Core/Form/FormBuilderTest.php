<?php
namespace Test\TuxBoy\Form;

use TuxBoy\Form\Builder\FormBuilder;
use TuxBoy\Form\Input;

class FormBuilderTest extends \PHPUnit\Framework\TestCase
{

	public function testBuildSimpleForm()
	{

		$formBuilder = new FormBuilder('/contact', 'POST');
		$email = new Input('email');
		$email->setAttribute('type', 'email');
		$input = new Input('username');
		$input->setAttribute('placeholder', 'Username');
		$formBuilder
			->openForm('/contact', 'POST')
			->add($input)
			->add($email)
			->build();
		$this->assertEquals(
			'<form action="/contact" method="POST"> <input name="username" placeholder="Username"> <input name="email" type="email"> </form>',
			(string) $formBuilder
		);
	}

}
