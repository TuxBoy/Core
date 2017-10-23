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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role)
    {
        $this->role = $role;
    }
}
