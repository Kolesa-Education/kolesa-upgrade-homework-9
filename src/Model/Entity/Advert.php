<?php

namespace App\Model\Entity;

use App\Model\Repository\CategoryRepository;

class Advert extends AbstractModel
{
    private ?int $id;
    private ?string $title;
    private ?string $description;
    private ?int    $price;
    private ?int $categoryId;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->categoryId = $data['category_id'] ?? null;
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

    public function getCategory(): Category
    {
        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();

        foreach ($categories as $category) {
            if ($category->getId() == $this->categoryId) {
                return $category;
            }
        }

        return null;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'category' => $this->getCategory()->getTitle(),
        ];
    }
}
