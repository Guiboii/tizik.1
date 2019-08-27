<?php

namespace App\Repository;

use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function findByMentor($user)
    {
        return $this->createQueryBuilder('u')
                    ->andWhere('u.mentor = :user')
                    ->setParameter('user', $user)
                    ->orderBy('u.lastName', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    public function findSimpleUsers($manager, $user)
    {
        $query = $manager->createQuery(
            "SELECT u FROM App\Entity\User u 
            WHERE u.wish = 'simple' "
            );
        
        return $query->getResult();
    }
   
    public function findStudentsBySchools($manager, $schoolid, $user)
    {
        $query = $manager->createQuery(
            "SELECT u FROM App\Entity\User u 
            JOIN u.schools s 
            WHERE u.mentor = $user AND s.id = $schoolid"
            );
        
        return $query->getResult();
    }

    public function findOneBySchool($school)
    {
        return $this->createQueryBuilder('u')
                    ->andWhere('u.schools = :school')
                    ->setParameter('school', $school)
                    ->orderBy('u.lastName', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    public function findUsersByUnverified($manager, $users)
    {
        $query = $manager->createQuery(
            "SELECT DISTINCT u FROM App\Entity\User u  WHERE u.validation = FALSE"
            );
        
        return $query->getResult();
    }

    public function findTeachers($manager, $users)
    {
        $query = $manager->createQuery(
            "SELECT u FROM App\Entity\User u 
            JOIN u.userRoles r 
            WHERE r.description = 'Enseignant'"
            );
        
        return $query->getResult();
    }

    public function findStudents($manager, $user)
    {
        $query = $manager->createQuery(
            "SELECT u FROM App\Entity\User u 
            JOIN u.userRoles r 
            WHERE r.description = 'Etudiant'"
            );
        
        return $query->getResult();
    }

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
    public function findOneBySomeField($value): ?User
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
