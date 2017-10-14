<?php
namespace TuxBoy\User;

use TuxBoy\Annotation\Option;
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
     *
     * @Option(type="password", placeholder="Mot de passe")
     */
    public $password;

    /**
     * @var string
     */
    public $role;

}