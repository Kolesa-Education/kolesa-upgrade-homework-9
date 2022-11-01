<?php

namespace App\Repository;

use App\Model\Advert;

interface InterfaceAdvertRepository
{
    public function collection(): array;
    public function find(int $id): ?Advert;
    public function create(array $advertData): Advert;
}