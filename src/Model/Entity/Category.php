<?php

namespace App\Model\Entity;

class Category extends AbstractModel
{
    private ?string $title;

    public function __construct($data = [])
    {
        parent::__construct();
        $this->title = $data['title'] ?? null;
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
        ];
    }
}