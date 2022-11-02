<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;

interface AdvertRepository{
   public function getAll(): array;
   public function getByID(int $id): array;
   public function createAdvert(Advert $advert);
   public function updateAdvert(int $id, Advert $advert);
}

