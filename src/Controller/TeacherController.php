<?php

namespace App\Controller;

use App\Form\TeacherAddSchoolType;
use App\Repository\UserRepository;
use App\Repository\SchoolRepository;
use App\Repository\TeacherRepository;
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
     * @Route("/teacher/school_add", name="school_add", methods="GET|POST")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param School $school
     * @return void
     */
    public function addSchool(Request $request, ObjectManager $manager, SchoolRepository $repoSchool, TeacherRepository $repoTeacher)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $teacher = $repoTeacher->findOneByUser($id);
        $relation = $teacher->getSchools();
        $schools = $repoSchool->findAll();
        $form = $this->createForm(TeacherAddSchoolType::class, $relation);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($relation);

            $manager->flush();

            $this->addFlash(
                'success',
                "l'établissement a bien été ajouté");

            return $this->redirectToRoute('teacher_home');
        }

        return $this->render('teacher/school_add.html.twig', [
            'form' => $form->createView()]
                );
    }
}
