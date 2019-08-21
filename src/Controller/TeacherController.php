<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherController extends AbstractController
{
    /**
     * @Route("/teacher", name="teacher")
     */
    public function home(){
        $user = $this->getUser();

        return $this->render('teacher/home.html.twig', [
            'user' => $user,
        ]);
    }

}
