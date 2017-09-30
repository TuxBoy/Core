<?php
namespace TuxBoy\Tools;

/**
 * Class Password
 */
class Password
{

    /**
     * Encrype un mot de passe.
     *
     * @param string $password
     * @return bool|string
     */
    public static function encypt(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param string $password
     * @param string $verifyPassword
     * @return bool
     */
    public static function verify(string $password, string $verifyPassword): bool
    {
        return password_verify($password, $verifyPassword);
    }

}