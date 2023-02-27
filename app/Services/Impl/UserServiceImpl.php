<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    private array $user = [
        "manuel" => "rahasia"
    ];
    public function login(string $user, string $password): bool
    {
        if(!isset($this->user[$user]))
        {
            return false;
        }

        $correctPassword = $this->user[$user];
        return $password == $correctPassword;
    }
}