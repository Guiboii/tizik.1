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

/**
 * @Route("/school")
 */
class SchoolController extends AbstractController
{
    /**
     * @Route("/", name="school_index", methods="GET")
     */
    public function index(SchoolRepository $schoolRepository): Response
    {
        return $this->render('school/index.html.twig', ['schools' => $schoolRepository->findAll()]);
    }

    /**
     * @Route("teacher/new", name="school_new", methods="GET|POST")
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
     * @Route("/{id}", name="school_show", methods="GET")
     */
    public function show(School $school): Response
    {
        return $this->render('school/show.html.twig', ['school' => $school]);
    }

    /**
     * @Route("teacher/{id}/add_teacher", name="school_teacher", methods="GET|POST")
     */

     public function addTeacher(Request $request, School $school, TeacherRepository $repo, ObjectManager $manager)
     {
         $user = $this->getUser();
         $teacher = $repo->findOneByUser($user);

        $form = $this->createForm(SchoolTeacherType::class, $teacher);

        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $school->addTeacher($teacher);
            $em->persist($school);
            $em->flush();

            $this->addFlash(
                'success',
                "l'établissement a bien été ajouté");

            return $this->redirectToRoute('teacher_home');
        }

         return $this->render('school/teacher.html.twig', [
            'school' => $school,
            'teacher' => $teacher,
            'form' => $form->createView()
         ]);
     }
    /**public function addTeacher(Request $request, School $school, TeacherRepository $repo): Response
    {
        $user = $this->getUser()->getId();
        $teacher = $repo->findOneById($user);

        dump($school);

        $form = $this->createForm(SchoolTeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('school_teacher', ['id' => $school->getId()]);
        }

        return $this->render('school/teacher.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    } */
    

    /**
     * @Route("teacher/{id}/rem_teacher", name="teacherSchool_delete", methods="DELETE")
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
     * @Route("teacher/{id}/edit", name="school_edit", methods="GET|POST")
     */
    public function edit(Request $request, School $school, TeacherRepository $teacherRepo) : Response
    {
        $user = $this->getUser();
        $teacher = $teacherRepo->findOneByUser($user);

        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $school->addTeacher($teacher);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('school_edit', ['id' => $school->getId()]);
        }

        return $this->render('school/edit.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/{id}", name="school_delete", methods="DELETE")
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
