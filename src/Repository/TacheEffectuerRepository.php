<?php

namespace App\Repository;

use App\Entity\TacheEffectuer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TacheEffectuer|null find($id, $lockMode = null, $lockVersion = null)
 * @method TacheEffectuer|null findOneBy(array $criteria, array $orderBy = null)
 * @method TacheEffectuer[]    findAll()
 * @method TacheEffectuer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheEffectuerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TacheEffectuer::class);
    }

    // /**
    //  * @return TacheEffectuer[] Returns an array of TacheEffectuer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TacheEffectuer
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
