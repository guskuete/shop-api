<?php

namespace App\Dtos\Auth;


use OpenApi\Attributes as OAT;

#[OAT\Schema(
    required: ['name', 'email', 'password']
)]
class RegisterDto
{
    #[OAT\Property(type: 'string')]
    public string $name;

    #[OAT\Property(type: 'string')]
    public string $email;

    #[OAT\Property(type: 'string')]
    public string $password;
}
