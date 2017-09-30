<?php
namespace TuxBoy\User;

use TuxBoy\Entity;

class User extends Entity
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $role;

}