<?php

namespace App\Dtos;

use Illuminate\Support\MessageBag;
use OpenApi\Attributes as OAT;

#[OAT\Schema()]
class LoginResponse
{
    #[OAT\Property(description: "Bearer token")]
    public string $token;

    #[OAT\Property()]
    public string $message;

    #[OAT\Property()]
    public bool $success;

    public function __construct($token = null, ?string $message = null, bool $success = true)
    {
        $this->message = $message;
        $this->token = $token;
        $this->success = $success;
    }

    public static function success(string $token, ?string $message = null): self
    {
        return new self($token, $message, true);
    }
}
