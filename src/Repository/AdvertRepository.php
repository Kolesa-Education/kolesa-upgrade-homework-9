<?php

namespace App\Repository;

use App\Model\Advert;
use Doctrine\ORM\EntityManager;

class AdvertRepository implements InterfaceAdvertRepository
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function collection(): array
    {
        return $this->em->createQueryBuilder()
            ->select('a')
            ->from(Advert::class, 'a')
            ->getQuery()
            ->getArrayResult();
    }

    public function find(int $id): ?Advert
    {
        $data = $this->getDB()[$id] ?? null;
        if ($data) {
            return new Advert($data);
        }
        return null;
    }

    /**
     * @throws \JsonException
     */
    public function create(array $advertData): Advert
    {
        $advert = new Advert($advertData);
        $this->em->persist($advert);
        $this->em->flush();
        return $advert;
    }
}
