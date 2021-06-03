<?php

namespace App\Repository;

use App\Entity\CheckboxItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CheckboxItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheckboxItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheckboxItem[]    findAll()
 * @method CheckboxItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckboxItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CheckboxItem::class);
    }

    // /**
    //  * @return CheckboxItem[] Returns an array of CheckboxItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CheckboxItem
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
