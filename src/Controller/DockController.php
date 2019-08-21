<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DockController extends AbstractController
{
    /**
     * @Route("/dock", name="dock")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function index()
    {
        return $this->render('dock/index.html.twig', [
            'controller_name' => 'DockController',
            'title' => "Un projet extraordinaire",
            'introduction' => "une intro qui déchire, comme d'hab...",
            'students' => "Jules, Edouard, Moustique",
            'event' => "Cours",
            'date' => "13/05/2019"
        ]);
    }
}
