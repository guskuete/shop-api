<?php

namespace App\Dtos\Auth;


use OpenApi\Attributes as OAT;

#[OAT\Schema(
    required: ['name', 'email', 'password']
)]
class RegisterDto
{
    #[OAT\Property(type: 'string', example: 'John Doe')]
    public string $name;

    #[OAT\Property(type: 'string', example: 'name@mail.dev')]
    public string $email;

    #[OAT\Property(type: 'string', minimum: 4, example: 'secret')]
    public string $password;
}
