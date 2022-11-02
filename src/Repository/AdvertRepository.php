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

    public function update(array $data, int $id): void
    {
        $query = $this->em->createQueryBuilder()
            ->update(Advert::class,'a')
            ->set('a.title' ,':title')
            ->set('a.description' ,':description')
            ->set('a.price' ,':price')
            ->where('a.id = :id')
            ->setParameter('title',$data['title'])
            ->setParameter('description',$data['description'])
            ->setParameter('price',$data['price'])
            ->setParameter('id',$id)
            ->getQuery();
        $result = $query->execute();
    }
}
