<?php


namespace App\Model\Entity;


abstract class AbstractModel
{
    protected ?int $id;

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
    }

    public abstract function toArray(): array;

    public function getId(): ?int
    {
        return $this->id;
    }
}