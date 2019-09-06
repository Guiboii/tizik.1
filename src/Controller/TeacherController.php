<?php

namespace App\Controller;

use App\Entity\School;
use App\Form\SchoolTeacherType;
use App\Form\TeacherAddSchoolType;
use App\Repository\UserRepository;
use App\Repository\SchoolRepository;
use App\Repository\TeacherRepository;
use App\Form\TeacherAddDisciplineType;
use App\Repository\DisciplineRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherController extends AbstractController
{
    /**
     * Affiche la liste des écoles de l'enseignant
     * 
     * @Route("/teacher/schools", name="teacher_schools")
     * 
     * @return Response
     */
    public function teacherHome(TeacherRepository $teacherRepo)
    {
        $user = $this->getUser();
        $teacher = $teacherRepo->findOneByUser($user);

        return $this->render('teacher/schools.index.html.twig', [
                    'user' => $user,
                    'teacher' => $teacher,
                    ]);

        
    }

    /**
     * Permet d'ajouter une école à un(e) enseignant(e)
     * 
     * @Route("teacher/{slug}/add_school", name="school_teacher", methods="GET|POST")
     */

     public function addTeacher(Request $request, School $school, TeacherRepository $repo, ObjectManager $manager)
     {
         $user = $this->getUser();
         $teacher = $repo->findOneByUser($user);

        $form = $this->createForm(SchoolTeacherType::class, $school);

        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $school->addTeacher($teacher);
            $manager->persist($school);
            $manager->flush();

            $this->addFlash(
                'success',
                "l'établissement a bien été ajouté");

            return $this->redirectToRoute('teacher_schools');
        }

         return $this->render('teacher/school_add.html.twig', [
            'school' => $school,
            'teacher' => $teacher,
            'form' => $form->createView()
         ]);
     }
}
