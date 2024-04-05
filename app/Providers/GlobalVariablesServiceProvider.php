<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenApi\Attributes as OAT;

class GlobalVariablesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        define('VALIDATION_ERROR_EXAMPLE', [
            'validationErrorExample' => new OAT\Examples(
                example: json_encode([
                    'success' => false,
                    'data' => null,
                    'message' => 'Validation failed',
                    'errors' => ['field_name' => ['Error message for the field']]
                ]),
                summary: 'Validation Error Response Example'
            )
        ]);
    }
}
