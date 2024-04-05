<?php

namespace App\Dtos;

use Illuminate\Support\MessageBag;
use OpenApi\Attributes as OAT;

#[OAT\Schema()]
class ApiResponse
{
    #[OAT\Property(description: "Indicates whether the response is successful", example: false)]
    public bool $success;

    #[OAT\Property(description: "Data payload of the response", type: "mixed")]
    public $data;

    #[OAT\Property(description: "Message accompanying the response")]
    public ?string $message;

    #[OAT\Property(description: "Errors payload of the request", type: "mixed")]
    public $errors;

    /**
     * ApiResponse constructor.
     *
     * @param null $data
     * @param string|null $message
     * @param bool $success
     */
    public function __construct($data = null, ?string $message = null, bool $success = true, $errors = null)
    {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
        $this->errors = $errors;
    }

    public static function success($data, ?string $message = null)
    {
        return new self($data, $message, true);
    }

    public static function fail(?string $message = null, ?array $errors = null, $data = null)
    {
        return new self($data, $message, false, $errors);
    }

    public static function validationError(MessageBag $errors, ?string $message = null, $data = null)
    {
        return new self($data, $message, false, $errors);
    }
}
