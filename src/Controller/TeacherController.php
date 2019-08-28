<?php

namespace App\Controller;

use App\Form\TeacherAddSchoolType;
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
