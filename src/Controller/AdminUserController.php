<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\School;
use App\Entity\Teacher;
use App\Form\ChoiceRoleType;
use Doctrine\ORM\EntityManager;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\SchoolRepository;
use App\Repository\TeacherRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * Affiche le tableau de bord de l'administration
     *
     * @Route("/admin", name="admin_dashboard")
     */
    public function adminDashboard(ObjectManager $manager, UserRepository $repo){

        $users = $repo->findUsersByUnverified($manager, $repo);

        return $this->render('admin/home.html.twig', [
            'users' => $users]);
    }

    /**
     * Permet d'afficher la liste des utilisateurs
     * 
     * @Route("/admin/users", name="users_index")
     */
    public function index(ObjectManager $manager, UserRepository $repo)
    {
        $users = $repo->findSimpleUsers($manager, $repo);

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * Permet d'afficher un utilisateur
     *
     * @Route("/admin/users/{slug}", name="user_show")
     */

    public function showUser(User $user, ObjectManager $manager)
    {
        $roles = $user->getUserRoles();

        dump($roles);
                return $this->render('admin/user/show.html.twig', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Permet de valider la demande d'un utilisateur
     *
     * @Route("/admin/{wish}/{slug}/valid", name="user_valid")
     */

    public function validUser(User $user, ObjectManager $manager)
    {
        $roles = $user->getUserRoles();

            return $this->render('admin/user/show.html.twig', [
            'user' => $user,
            'roles' => $roles
        ]);
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
