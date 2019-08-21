<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReedController extends AbstractController
{
    /**
     * @Route("/reed", name="reed")
     */
    public function index()
    {
        return $this->render('reed/index.html.twig', [
            'controller_name' => 'ReedController',
        ]);
    }
}
