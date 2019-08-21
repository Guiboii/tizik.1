<?php

namespace App\Repository;

use App\Entity\Reed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reed[]    findAll()
 * @method Reed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reed::class);
    }

//    /**
//     * @return Reed[] Returns an array of Reed objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reed
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
