<?php

namespace App\Repository;

use App\Entity\Cane;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cane|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cane|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cane[]    findAll()
 * @method Cane[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cane::class);
    }

//    /**
//     * @return Cane[] Returns an array of Cane objects
//     */
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
    public function findOneBySomeField($value): ?Cane
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
