<?php
namespace TuxBoy\Exception;

/**
 * Class NotEntityException
 */
class NotEntityException extends \Exception
{

    public function __construct()
    {
        $message = "No defined entity";
        parent::__construct($message);
    }
}
