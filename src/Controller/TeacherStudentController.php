<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\School;
use App\Form\StudentAddType;
use App\Repository\RoleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TeacherStudentController extends AbstractController
{
    
     /**
     * Ajouter un élève
     * 
     * @Route("/teacher/{slug}/student_add", name="student_add")
     * 
     * @return Response
     */
    /**public function register(School $school, RoleRepository $role, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){

        $teacher = $this->getUser();
        $slug = $school->getSlug();
        $studentRole = $role->findOneBy(['description' => 'Etudiant']);
        $user = new User();

        $form = $this->createForm(StudentAddType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $teacher = $this->getUser();
            $user   ->setHash($hash)
                    ->setMentor($teacher)
                    ->addUserRole($studentRole)
                    ->addSchool($school);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'élève a bien été ajouté !"
            );

            return $this->redirectToRoute('school',['slug' => $slug]);
        }

        return $this->render('teacher/student_add.html.twig', [
            'mentor' => $teacher,
            'form' => $form->createView(),
        ]);
    } */
}
