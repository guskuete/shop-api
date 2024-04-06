<?php

namespace App\Dtos;

use OpenApi\Attributes as OAT;


#[OAT\Schema(schema: "ProductImageDto", description: "Product Image Data Transfer Object")]
class ProductImageDto
{
    #[OAT\Property(type: "integer")]
    public int $id;

    #[OAT\Property(type: "integer")]
    public int $product_id;

    #[OAT\Property(type: "string")]
    public string $name;

    #[OAT\Property(type: "string")]
    public string $thumb;

    #[OAT\Property(type: "string")]
    public string $small;

    #[OAT\Property(type: "string")]
    public string $medium;

    #[OAT\Property(type: "string", format: "date-time")]
    public string $created_at;

    #[OAT\Property(type: "string", format: "date-time")]
    public string $updated_at;
}
