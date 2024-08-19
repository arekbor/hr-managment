<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function allWithPositionsQueryBuilder(): QueryBuilder 
    {
        $qb = $this->createQueryBuilder('e');
        return $qb
            ->select('e', 'p')
            ->leftJoin('e.positions', 'p')
        ;
    }
}
