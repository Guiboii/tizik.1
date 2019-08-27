<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Household;
use App\Form\ChoiceRoleType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\HouseholdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminHouseholdController extends AbstractController
{
    /**
     * @Route("/admin/household", name="households_index")
     */
    public function householdIndex(ObjectManager $manager, UserRepository $users){
    
    $households = $users->findHouseholds($manager, $users);

    return $this->render('admin/household/index.html.twig', [
        'households' => $households,
        ]);
    }

    /**
     * Permet de valider l'inscription d'un foyer
     * 
     * @Route("/admin/households/{slug}/valid", name="valid_household")
     *
     * @return Request
     */
    public function validHousehold(ObjectManager $manager, User $user, RoleRepository $repo, Request $request){

        $household = new Household();
        $role = $repo->findOneByDescription('Foyer');

        $form = $this->createForm(ChoiceRoleType::class, $user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $user->addUserRole($role);
            $manager->persist($user);
            
            $manager->flush();

            $this->addFlash(
                'success',
                "Utilisateur accepté"
            );

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/user/valid.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
