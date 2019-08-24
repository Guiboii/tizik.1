<?php

namespace App\Repository;

use App\Entity\RoleOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RoleOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoleOption[]    findAll()
 * @method RoleOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleOptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoleOption::class);
    }

//    /**
//     * @return RoleOption[] Returns an array of RoleOption objects
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
    public function findOneBySomeField($value): ?RoleOption
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
