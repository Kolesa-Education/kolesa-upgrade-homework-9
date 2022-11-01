<?php

namespace App\Services;

use App\Model\Advert;
use App\Repository\AdvertRepository;

class AdvertService implements InterfaceAdvertService
{
    private AdvertRepository $repo;

    public function __construct(AdvertRepository $repo)
    {
        $this->repo = $repo;
    }

    public function collection(): array
    {
        return $this->repo->collection();
    }

    public function find(int $id): ?Advert
    {
        return $this->repo->find($id);
    }

    public function create(array $advertData): Advert
    {
        return $this->repo->create($advertData);
    }
}