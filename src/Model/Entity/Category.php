<?php

namespace App\Model\Entity;

class Category
{
    private ?int $id;
    private ?string $categoryName;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->categoryName = $data['category_name'] ?? null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }



}