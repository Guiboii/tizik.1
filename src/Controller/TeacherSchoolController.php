<?php

namespace App\Controller;

use App\Entity\School;
use App\Form\SchoolAddType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherSchoolController extends AbstractController
{

    /**
     * Ajouter un employeur
     * 
     * @Route("/teacher/school_add", name="school_add")
     *
     * @return Response
     */
    public function addSchool(Request $request, ObjectManager $manager){
        $school = new School();
        $form = $this->createForm(SchoolAddType::class, $school);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($school);
            $manager->flush();

            $this->addFlash('success', "L'école a bien été ajouté !");

            return $this->redirectToRoute('teacher');
        }

        return $this->render('teacher/school_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Afficher les activités d'une école
     * 
     * @Route("/teacher/{slug}", name="school")
     *
     * @return Response
     */
    public function showSchool(School $school,ObjectManager $manager, UserRepository $repo){

        $user = $this->getUser();
        $schoolid = $school->getId();
        $students = $repo->findStudentsBySchools($manager, $schoolid, $user);

        return $this->render('teacher/school.html.twig',[
            'user' => $user,
            'school' => $school,
            'students' => $students,
        ]);
    }

}
