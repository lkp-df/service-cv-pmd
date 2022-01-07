<?php

namespace App\Repository;

use App\Entity\MonProtoCv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MonProtoCv|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonProtoCv|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonProtoCv[]    findAll()
 * @method MonProtoCv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonProtoCvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonProtoCv::class);
    }

    // /**
    //  * @return MonProtoCv[] Returns an array of MonProtoCv objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MonProtoCv
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
