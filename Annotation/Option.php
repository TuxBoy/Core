<?php
namespace TuxBoy\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Type
 *
 * @Annotation
 * @Annotation\Target("PROPERTY")
 */
class Option extends Annotation
{

		/**
		 * Default value of field
		 *
		 * @var string|integer
		 */
		public $default;

    /**
     * Field type (email, password)
     *
     * @var string
     */
    public $type;

    /**
     * true field is mandatory.
     *
     * @var bool
     */
    public $mandatory = false;

    /**
     * @var string
     */
    public $placeholder;
}
