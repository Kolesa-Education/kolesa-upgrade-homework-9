<?php

namespace App\Repository;

use App\Model\Advert;

interface InterfaceAdvertRepository
{
    public function collection(): array;

    public function find(int $id): array;

    public function create(array $advertData): Advert;
}