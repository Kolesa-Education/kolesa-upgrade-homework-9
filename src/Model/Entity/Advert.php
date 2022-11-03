<?php

namespace App\Model\Entity;

class Advert
{
    private int    $id;
    private string $title;
    private string $description;
    private int    $price;
    private string $category;

    public function __construct($data = [])
    {
        $id =$data['id'] ?? null;
        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;;
        $price = $data['price'] ?? null;
        $category = $data['category'] ?? null;

        if($id == null || $title==null || $description==null || $price==null || $category == null){
            throw new Exception("All fields should be filled");
        }

        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->category= $category;


    }

    public function getCategory() :string {
        return $this->category ?? '';
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
            'category' => $this->getCategory()
        ];
    }
}
