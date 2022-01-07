<?php

namespace App\Repository;

use App\Entity\UserForCv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserForCv|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserForCv|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserForCv[]    findAll()
 * @method UserForCv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserForCvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserForCv::class);
    }

    // /**
    //  * @return UserForCv[] Returns an array of UserForCv objects
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
    public function findOneBySomeField($value): ?UserForCv
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
