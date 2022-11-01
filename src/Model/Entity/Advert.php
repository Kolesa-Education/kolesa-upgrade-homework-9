<?php

namespace App\Model\Entity;

class Advert
{
    private ?int    $id;
    private ?string $title;
    private ?string $description;
    private ?int    $price;
    private ?Category $category;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->category = new Category($data['category']??["name"=>"Unknown"]); 
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

    public function getCategory(): ?string{
        return $this->category->getName();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'category' => $this->getCategory(),
        ];
    }


    /**
     * Set the value of id
     *
     * @param ?int $id
     *
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
