<?php

namespace App\Dtos\Auth;


use OpenApi\Attributes as OAT;

#[OAT\Schema(
    required: ['name', 'email', 'password']
)]
class LoginDto
{
    #[OAT\Property(type: 'string', example: 'name@example.com')]
    public string $email;

    #[OAT\Property(type: 'string')]
    public string $password;
}
