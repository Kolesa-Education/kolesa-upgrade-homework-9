<?php

namespace App\Model\Entity;

class Category
{
    private ?int    $id;
    private ?string $name;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name ?? '';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getName(),
        ];
    }
}
