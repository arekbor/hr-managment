<?php

namespace App\Repository;

use App\Entity\Position;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class PositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Position::class);
    }

    public function searchByName(string $name)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->orWhere('p.name LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$name.'%')
        ;

        return $qb->getQuery()->getResult();
    }
}
