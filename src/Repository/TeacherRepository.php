<?php

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    public function findByVerified($manager, $users){

        $query = $manager->createQuery(
            "SELECT t FROM App\Entity\Teacher t 
            JOIN t.user u "
            );
        
        return $query->getResult();
    }

    public function findUsers($manager, $users){

        $query = $manager->createQuery(
        "SELECT t FROM App\Entity\Teacher t
        JOIN t.user u
        WHERE u.teacher = 58"
        );

        return $query->getResult();

    }

    public function findSchools($schools)
    {
        return $this->createQueryBuilder('t')
                    ->andWhere('t.schools = :schools')
                    ->setParameter('schools', $schools)
                    ->getQuery()
                    ->getResult();
    }
//    /**
//     * @return Teacher[] Returns an array of Teacher objects
//     */
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
    public function findOneBySomeField($value): ?Teacher
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
