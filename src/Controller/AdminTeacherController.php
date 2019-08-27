<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Teacher;
use App\Form\ChoiceRoleType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\TeacherRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTeacherController extends AbstractController
{
    /**
     * Permet d'afficher la liste des enseignants
     * 
     * @Route("/admin/teachers", name="teachers_index")
     */
   public function teacherIndex(ObjectManager $manager, UserRepository $users){
        
        $teachers = $users->findTeachers($manager, $users);

        return $this->render('admin/teacher/index.html.twig', [
            'teachers' => $teachers,
            ]);
    }

    /**
     * Permet de valider l'inscription d'un enseignant
     * 
     * @Route("/admin/teachers/{slug}/valid", name="valid_teacher")
     *
     * @return Request
     */
    public function validUser(ObjectManager $manager, User $user, RoleRepository $repo, Request $request){

        $teacher = new Teacher();
        $role = $repo->findOneByDescription('Enseignant');

        $form = $this->createForm(ChoiceRoleType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $user->addUserRole($role);
            $manager->persist($user);

            $teacher->setUser($user);
            $manager->persist($teacher);

            $manager->flush();

            $this->addFlash(
                'success',
                "Utilisateur accepté"
            );

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/user/valid.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

}
