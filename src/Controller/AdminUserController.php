<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\School;
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
    public function adminDashboard(ObjectManager $manager){

        $query = $manager->createQuery("SELECT t FROM App\Entity\User t JOIN t.userRoles r WHERE r.description = 'Verified'" );

        $users = $query->getResult();

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
        $users = $repo->findUsersByUnverified($manager, $repo);

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Permet d'afficher un utilisateur
     *
     * @Route("/admin/users/{slug}", name="user_show")
     */
    public function moderateRole(User $user, ObjectManager $manager)
    {
        //$role = $user->getUserRoles();
        //dump($role);

        //$form = $this->createForm(ChoiceRoleType::class, $user);
        
        //$form->handleRequest($request);
        
        //if($form->isSubmitted() && $form->isValid()) {

        //    $manager->persist($user);
        //    $manager->flush();

        //    $this->addFlash(
        //        'success',
        //        "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !"
        //    );

        //    return $this->redirectToRoute('account_login');
        //}
        
        $roles = $user->getUserRoles();

        dump($roles);
                return $this->render('admin/user/show.html.twig', [
            'user' => $user,
            'roles' => $roles
        //    'form' => $form
        ]);
    }

    /**
     * Permet de valider l'inscription d'un utilisateur
     * 
     * @Route("/admin/user/{slug}/valid", name="valid_user")
     *
     * @return void
     */
    public function validUser(User $user, RoleRepository $repo){

        $roles = $repo->findAll();

        return $this->render('admin/user/valid.html.twig', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

     /**
     * Permet d'afficher la liste des enseignants
     * 
     * @Route("/admin/teachers", name="teachers_index")
     */
   public function teacherIndex(ObjectManager $manager, TeacherRepository $repo, UserRepository $users){
        
        $teachers = $repo->findByVerified($manager, $users);

        return $this->render('admin/user/teacher_index.html.twig', [
            'teachers' => $teachers,
            ]);
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
