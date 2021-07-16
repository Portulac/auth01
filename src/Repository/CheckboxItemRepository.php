<?php

namespace App\Repository;

use App\Entity\CheckboxItem;
use App\Entity\UserCheck;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\QueryBuilder;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * @method CheckboxItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheckboxItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheckboxItem[]    findAll()
 * @method CheckboxItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckboxItemRepository extends NestedTreeRepository implements ServiceEntityRepositoryInterface
{
    private $registry;

    public function __construct(EntityManagerInterface $manager)
    {
        $entityClass = CheckboxItem::class;

        parent::__construct($manager, $manager->getClassMetadata($entityClass));

    }


    public function getAllQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.description', 'DESC');
    }

    public function getCheckboxItemUserCheck($value)
    {
        //SELECT * FROM checkbox_item LEFT JOIN user_check ON checkbox_item.`id` = user_check.`checkboxitem_id` WHERE user_check.`to_done` = 1
        $qb = $this->createQueryBuilder('c')
            ->leftJoin(UserCheck::class, 'uc' , 'WITH', "c.id=uc.checkboxitem")
            ->where('uc.isDone = 1')
            ->andWhere('uc.site=:site')
            ->setParameter('site', $value);
        return $qb->getQuery()->getResult();
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
