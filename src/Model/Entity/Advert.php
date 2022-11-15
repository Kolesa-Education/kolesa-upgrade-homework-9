<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity, Table(name: 'adverts')]
class Advert
{
    #[Id, Column(type: Types::INTEGER), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: Types::STRING, length: 150, nullable: false,)]
    private string $title;

    #[Column(type: Types::TEXT, nullable: false,)]
    private $description;

    #[Column(type: Types::INTEGER, nullable: false,)]
    private $price;

    public function __construct(string $title, string $description, int $price)
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
