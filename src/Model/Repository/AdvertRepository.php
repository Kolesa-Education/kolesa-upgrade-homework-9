<?php

namespace App\Model\Repository;

use App\Model\Entity\Advert;
use Doctrine\ORM\EntityManager;

class AdvertRepository
{
    private const DB_PATH = '../storage/adverts.json';
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAll()
    {
        $adverts = $this->em->getRepository(Advert::class)->findAll();
        $result = array_map(function (Advert $advert) {
            return [
                "id" => $advert->getId(),
                "title" => $advert->getTitle(),
                "description" => $advert->getDescription(),
                "price" => $advert->getPrice()
            ];
        }, $adverts);
        return $result;
    }

    public function create(array $advertData): Advert
    {
        $newAdvert = new Advert($advertData["title"], $advertData["description"], $advertData["price"]);
        $this->em->persist($newAdvert);
        $this->em->flush();
        return $newAdvert;
    }


    public function getAdvert(int $id): array
    {
        $advert = $this->em->getRepository(Advert::class)->find(array("id" => $id));
        $result = [
            "id" => $advert->getId(),
            "title" => $advert->getTitle(),
            "description" => $advert->getDescription(),
            "price" => $advert->getPrice()
        ];
        return $result;
    }

    public function update(array $advertData, int $id)
    {
        $advert = $this->em->getRepository(Advert::class)->find($id);
        $advert->setTitle($advertData["title"]);
        $advert->setDescription($advertData["description"]);
        $advert->setPrice($advertData["price"]);
        $this->em->flush();

        return $advert;
    }
}
