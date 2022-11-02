<?php

namespace App\Repository;

use App\Model\Advert;
use Doctrine\ORM\EntityManager;

class AdvertRepository implements InterfaceAdvertRepository
{
    public function __construct(private EntityManager $em)
    {
    }

    public function collection(): array
    {
        return $this->em->createQueryBuilder()
            ->select('a')
            ->from(Advert::class, 'a')
            ->getQuery()->getResult();
    }

    public function find(int $id): ?Advert
    {
        return $this->em->getRepository(Advert::class)->find($id);
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
