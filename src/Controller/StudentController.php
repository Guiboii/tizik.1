<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\StudentAddType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class StudentController extends AbstractController
{
    
    /**
     * La page d'accueil
     *
     *@Route("/student", name="student")
     */
    public function index(UserRepository $repo, RoleRepository $role){
        $students = $repo->findAll();
        
        return $this->render(
            'student/_student.html.twig', [
                'students' => $student
                ]);
            }
            
    /**
     * Permet d'afficher la page d'un élève
     *
     * @Route("/student/{slug}", name="student_show")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function show(User $student)
    {

        return $this->render('student/show.html.twig', [
            'student' => $student
            ]);
        }
        
    }
            