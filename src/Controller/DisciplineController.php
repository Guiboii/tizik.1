<?php

namespace App\Controller;

use App\Entity\School;
use App\Entity\Discipline;
use App\Form\DisciplineType;
use App\Repository\TeacherRepository;
use App\Repository\DisciplineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DisciplineController extends AbstractController
{
    /**
     * @Route("/discipline/", name="discipline_index", methods="GET")
     */
    public function index(DisciplineRepository $disciplineRepository): Response
    {
        return $this->render('discipline/index.html.twig', ['disciplines' => $disciplineRepository->findAll()]);
    }

    /**
     * @Route("teacher/{slug}/discipline_new", name="discipline_new", methods="GET|POST")
     */
    public function new(Request $request, School $school, TeacherRepository $teacherRepo): Response
    {
        $user = $this->getUser();
        $teacher = $teacherRepo->findOneByUser($user);
        $discipline = new Discipline();
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $discipline ->addTeacher($teacher)
                        ->addSchool($school);
            $em->persist($discipline);
            $em->flush();

            return $this->redirectToRoute('teacher_schools');
        }

        return $this->render('teacher/discipline_new.html.twig', [
            'discipline' => $discipline,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/discipline/{id}", name="discipline_show", methods="GET")
     */
    public function show(Discipline $discipline): Response
    {
        return $this->render('discipline/show.html.twig', ['discipline' => $discipline]);
    }

    /**
     * @Route("/discipline/{id}/edit", name="discipline_edit", methods="GET|POST")
     */
    public function edit(Request $request, Discipline $discipline): Response
    {
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('discipline_edit', ['id' => $discipline->getId()]);
        }

        return $this->render('discipline/edit.html.twig', [
            'discipline' => $discipline,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/discipline/{id}", name="discipline_delete", methods="DELETE")
     */
    public function delete(Request $request, Discipline $discipline): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discipline->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($discipline);
            $em->flush();
        }

        return $this->redirectToRoute('discipline_index');
    }
}
