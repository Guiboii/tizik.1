<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\School;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Repository\SchoolRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * Permet d'afficher la liste des utilisateurs
     * 
     * @Route("/admin/users", name="users_index")
     */
    public function index(UserRepository $repo)
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $repo->findAll()
        ]);
    }

    /**
     * Permet d'afficher un utilisateur
     *
     * @Route("/admin/users/{slug}", name="user_show")
     */
    public function moderateRole(User $user)
    {

        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }

     /**
     * Permet d'afficher la liste des enseignants
     * 
     * @Route("/admin/teachers", name="teachers_index")
     */
    public function teacherIndex(ObjectManager $manager)
    {
        $query = $manager->createQuery("SELECT t FROM App\Entity\User t JOIN t.userRoles r WHERE r.description = 'Enseignant'");

        $teachers = $query->getResult();

        return $this->render('admin/user/teacher_index.html.twig', [
            'teachers' => $teachers]);

    }

     /**
     * Permet d'afficher la liste des étudiants
     * 
     * @Route("/admin/students", name="students_index")
     */
    public function studentIndex(ObjectManager $manager)
    {
        $query = $manager->createQuery("SELECT t FROM App\Entity\User t JOIN t.userRoles r WHERE r.description = 'Etudiant'" );

        $students = $query->getResult();

        return $this->render('admin/user/student_index.html.twig', [
            'students' => $students]);

    }

    /**
     * Permet d'afficher la liste des écoles
     * 
     * @Route("/admin/schools", name="school_index")
     *
     */
    public function schoolIndex(SchoolRepository $repo)
    {

        return $this->render('admin/school/index.html.twig', [
           'schools' => $repo->findAll()
           ]);

    }

    /**
     * Permet d'afficher une école et ses utilisateurs
     * 
     * @Route("/admin/schools/{slug}", name="school_admin")
     *
     */
    public function schoolUsers(School $school)
    {
        $users = $school->getUser();

        return $this->render('admin/school/show.html.twig', [
            'school' => $school,
            'users' => $users
        ]);
    }
}
