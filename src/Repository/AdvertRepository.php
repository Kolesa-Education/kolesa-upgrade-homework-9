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
            ->getQuery()
            ->getArrayResult();



//        return $this->em->createQueryBuilder()
//            ->select('a')
//            ->from(Advert::class, 'a')
//            ->getQuery()
//            ->getArrayResult();
    }

    public function find(int $id): array
    {
        return $this->em->createQueryBuilder()
            ->select('a')
            ->from(Advert::class, 'a')
            ->where('a.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getArrayResult();
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
