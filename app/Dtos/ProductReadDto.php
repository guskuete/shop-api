<?php

namespace App\Dtos;

use OpenApi\Attributes as OAT;


#[OAT\Schema(schema: "ProductReadDto", description: "Product Read Data Transfer Object")]
class ProductReadDto
{
    #[OAT\Property(type: "integer")]
    public int $id;

    #[OAT\Property(type: "integer")]
    public int $category_id;

    #[OAT\Property(type: "string")]
    public string $uuid;

    #[OAT\Property(type: "string")]
    public string $name;

    #[OAT\Property(type: "string")]
    public string $slug;

    #[OAT\Property(type: "integer")]
    public int $price;

    #[OAT\Property(type: "string")]
    public string $description;

    #[OAT\Property(type: "boolean")]
    public bool $is_new;

    #[OAT\Property(type: "boolean")]
    public bool $is_online;

    #[OAT\Property(type: "string")]
    public string $large_description;

    #[OAT\Property(type: "string", format: "date-time")]
    public string $created_at;

    #[OAT\Property(type: "string", format: "date-time")]
    public string $updated_at;

    #[OAT\Property(type: "string")]
    public string $small_image;

    #[OAT\Property(type: "string")]
    public string $thumb_image;

    #[OAT\Property(type: "string")]
    public string $medium_image;

    #[OAT\Property(type: "string")]
    public string $image;

    #[OAT\Property(type: "array", items: new OAT\Items(ref: "#/components/schemas/ProductImageDto"))]
    public array $images;
}
