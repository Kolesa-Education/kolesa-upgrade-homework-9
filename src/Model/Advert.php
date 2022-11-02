<?php

namespace App\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('adverts')]
class Advert
{
    #[Id]
    #[Column, GeneratedValue]
    private ?int $id;

    #[Column(name: 'title',type: Types::STRING)]
    private ?string $title;

    #[Column(name: 'description',type: Types::STRING)]
    private ?string $description;

    #[Column(name: 'price',type: Types::INTEGER)]
    private ?int $price;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->price = $data['price'] ?? null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
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
