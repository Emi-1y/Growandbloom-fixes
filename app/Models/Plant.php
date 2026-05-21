<?php

// Author: Emily Cardona Castañeda

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * PLANT ATTRIBUTES
 * $this->attributes['id'] - int - contains the plant primary key (id)
 * $this->attributes['name'] - string - contains the plant name
 * $this->attributes['size'] - string - contains the plant size or presentation
 * $this->attributes['price'] - int - contains the plant price
 * $this->attributes['image'] - string|null - contains the plant image filename
 * $this->attributes['description'] - string - contains the plant description
 * $this->attributes['color'] - string - contains the plant color or variety
 * $this->attributes['active'] - bool - indicates whether the plant is active
 * $this->attributes['stock'] - int - contains the plant stock quantity
 * $this->attributes['category_id'] - int - contains the associated category id
 * $this->attributes['created_at'] - timestamp - contains plant creation date
 * $this->attributes['updated_at'] - timestamp - contains plant update date
 * $this->category - Category - contains the associated category
 * $this->items - Item[] - contains the associated order items
 */
class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'price',
        'image',
        'description',
        'color',
        'active',
        'stock',
        'category_id',
    ];

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getSize(): string
    {
        return $this->attributes['size'];
    }

    public function setSize(string $size): void
    {
        $this->attributes['size'] = $size;
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function getImage(): ?string
    {
        return $this->attributes['image'];
    }

    public function setImage(?string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'];
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getColor(): string
    {
        return $this->attributes['color'];
    }

    public function setColor(string $color): void
    {
        $this->attributes['color'] = $color;
    }

    public function getActive(): bool
    {
        return (bool) $this->attributes['active'];
    }

    public function setActive(bool $active): void
    {
        $this->attributes['active'] = $active;
    }

    public function getStock(): int
    {
        return $this->attributes['stock'];
    }

    public function setStock(int $stock): void
    {
        $this->attributes['stock'] = $stock;
    }

    public function getCategoryId(): int
    {
        return $this->attributes['category_id'];
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->attributes['category_id'] = $categoryId;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->getPrice(), 0, ',', '.').' '.__('plant.currency');
    }
}
