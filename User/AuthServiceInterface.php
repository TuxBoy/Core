<?php
namespace TuxBoy\User;

interface AuthServiceInterface
{

    /**
     * @param string $username
     * @param string $password
     * @return null|User
     */
    public function login(string $username, string $password): ?User;

    /**
     * @return null|User
     */
    public function getUser(): ?User;
}
