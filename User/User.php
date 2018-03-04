<?php
namespace TuxBoy\User;

use TuxBoy\Annotation\Option;
use TuxBoy\Entity;
use TuxBoy\Tools\Password;

class User extends Entity
{

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
		 * @Option(placeholder="Nom d'utilisateur")
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
		 * @Option(placeholder="Le role", type="hidden", default="member")
     */
    public $role;

    /**
     * @return string
     */
    public function _getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    protected function _setPassword(string $password)
    {
        $this->password = Password::encypt($password);
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
