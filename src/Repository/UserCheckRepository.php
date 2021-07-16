<?php

namespace App\Repository;

use App\Entity\UserCheck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserCheck|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCheck|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCheck[]    findAll()
 * @method UserCheck[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCheckRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCheck::class);
    }

    // /**
    //  * @return UserCheck[] Returns an array of UserCheck objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserCheck
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
