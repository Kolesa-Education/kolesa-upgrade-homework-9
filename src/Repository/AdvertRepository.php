<?php

namespace App\Repository;

use App\Model\Advert;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

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



//        return $this->em->createQueryBuilder()
//            ->select('a')
//            ->from(Advert::class, 'a')
//            ->getQuery()
//            ->getArrayResult();
    }

    public function find(int $id): Advert
    {
        $query = $this->em->createQueryBuilder()
            ->select('a')
            ->from(Advert::class, 'a')
            ->where('a.id = :id')
            ->setParameter('id',$id)
            ->getQuery()->getResult();

        return new Advert($query);
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
