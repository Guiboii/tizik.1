<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Student;
use App\Form\ChoiceRoleType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminStudentController extends AbstractController
{
     /**
     * Permet d'afficher la liste des étudiants
     * 
     * @Route("/admin/students", name="students_index")
     */
    public function studentIndex(ObjectManager $manager, UserRepository $users){
        
        $students = $users->findStudents($manager, $users);

        return $this->render('admin/student/index.html.twig', [
            'students' => $students,
            ]);

    }

    /**
     * Permet de valider l'inscription d'un eleve
     * 
     * @Route("/admin/students/{slug}/valid", name="valid_student")
     *
     * @return Request
     */
    public function validHousehold(ObjectManager $manager, User $user, RoleRepository $repo, Request $request){

        $student = new Student();
        $role = $repo->findOneByDescription('Etudiant');

        $form = $this->createForm(ChoiceRoleType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $user->addUserRole($role);
            $manager->persist($user);

            $student->setUser($user);
            $manager->persist($student);
            
            $manager->flush();

            $this->addFlash(
                'success',
                "Utilisateur accepté"
            );

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/user/valid.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
