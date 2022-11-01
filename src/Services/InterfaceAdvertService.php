<?php

namespace App\Services;

use App\Model\Advert;

interface InterfaceAdvertService
{
    public function collection(): array;

    public function find(int $id): ?Advert;

    public function create(array $advertData): Advert;
}