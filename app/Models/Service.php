<?php

// Author: Emily Cardona Castañeda

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * SERVICE ATTRIBUTES
 * $this->attributes['id'] - int - contains the service primary key (id)
 * $this->attributes['name'] - string - contains the service name
 * $this->attributes['employee'] - string - contains the assigned employee name
 * $this->attributes['description'] - string - contains the service description
 * $this->attributes['price'] - int - contains the service price
 * $this->attributes['duration'] - string - contains the estimated duration
 * $this->attributes['active'] - bool - indicates whether the service is active
 * $this->attributes['features'] - string - JSON-encoded list of included features
 * $this->attributes['image'] - string|null - contains the service image filename
 * $this->attributes['created_at'] - timestamp - contains service creation date
 * $this->attributes['updated_at'] - timestamp - contains service update date
 * $this->items - Item[] - contains the associated order items
 */
class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'employee',
        'description',
        'price',
        'duration',
        'active',
        'features',
        'image',
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

    public function getEmployee(): ?string
    {
        return $this->attributes['employee'] ?? null;
    }

    public function setEmployee(?string $employee): void
    {
        $this->attributes['employee'] = $employee;
    }

    public function getDescription(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function setDescription(?string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function getDuration(): ?string
    {
        return $this->attributes['duration'] ?? null;
    }

    public function setDuration(?string $duration): void
    {
        $this->attributes['duration'] = $duration;
    }

    public function getActive(): bool
    {
        return (bool) ($this->attributes['active'] ?? true);
    }

    public function setActive(bool $active): void
    {
        $this->attributes['active'] = $active;
    }

    public function getFeatures(): array
    {
        $raw = $this->attributes['features'] ?? '[]';

        return json_decode($raw, true) ?? [];
    }

    public function setFeatures(array $features): void
    {
        $this->attributes['features'] = json_encode($features);
    }

    public function getImage(): ?string
    {
        return $this->attributes['image'] ?? null;
    }

    public function setImage(?string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
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
