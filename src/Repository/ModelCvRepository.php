<?php

namespace App\Repository;

use App\Entity\ModelCv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModelCv|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModelCv|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModelCv[]    findAll()
 * @method ModelCv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelCvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModelCv::class);
    }

    // /**
    //  * @return ModelCv[] Returns an array of ModelCv objects
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
    public function findOneBySomeField($value): ?ModelCv
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
