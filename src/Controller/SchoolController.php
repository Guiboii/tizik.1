<?php

namespace App\Controller;

use App\Entity\School;
use App\Entity\Teacher;
use App\Form\SchoolType;
use App\Form\SchoolTeacherType;
use App\Repository\SchoolRepository;
use App\Repository\TeacherRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SchoolController extends AbstractController
{
    /**
     * @Route("/school/", name="school_index", methods="GET")
     */
    public function index(ObjectManager $manager, TeacherRepository $teacherRepo, SchoolRepository $schoolRepository): Response
    {
        $user = $this->getUser();
        $teacher = $teacherRepo->findByUser($user);
        $schools = $schoolRepository->findAll();

        return $this->render('school/index.html.twig', [
            'user' => $user,
            'teacher' => $teacher,
            'schools' => $schools]);
    }

    /**
     * @Route("teacher/new_school", name="school_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $school = new School();
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($school);
            $em->flush();

            return $this->redirectToRoute('school_index');
        }

        return $this->render('school/new.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/school/{slug}", name="school_show", methods="GET")
     */
    public function show(School $school): Response
    {
        return $this->render('school/show.html.twig', ['school' => $school]);
    }
   
    /**
     * @Route("teacher/{slug}/rem_teacher", name="teacherSchool_delete", methods="DELETE")
     */
    public function deleteTeacher(Request $request, Teacher $teacher): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getSchools()->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($school);
            $em->flush();
        }

        return $this->redirectToRoute('school_index');
    }

    /**
     * @Route("school/{slug}/edit", name="school_edit", methods="GET|POST")
     */
    public function edit(ObjectManager $manager, Request $request, School $school, TeacherRepository $teacherRepo) : Response
    {

        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($school);
            $manager->flush();

            return $this->redirectToRoute('school_edit', ['slug' => $school->getSlug()]);
        }

        return $this->render('school/edit.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/{slug}", name="school_delete", methods="DELETE")
     */
    public function delete(Request $request, School $school): Response
    {
        if ($this->isCsrfTokenValid('delete'.$school->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($school);
            $em->flush();
        }

        return $this->redirectToRoute('school_index');
    }
}
