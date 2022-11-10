<?php

namespace App\Model\Entity;

class Advert
{
    private ?int    $id;
    private ?string $header;
    private ?string $description;
    private ?int    $price;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->header = $data['header'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->price = $data['price'] ?? null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->header ?? '';
    }

    public function getDescription(): string
    {
        return $this->description ?? '';
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
        ];
    }
}
