<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Teacher;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use App\Form\StudentProfileType;
use App\Repository\RoleRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends Controller
{

    /**
     * Permet de se connecter
     * 
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */

    public function login(AuthenticationUtils $utils) {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' =>$error !== null,
            'username' => $username
        ]);
        
    }
    /**
     * Permet de se déconnecter
     *
     * @Route("/logout", name="account_logout")
     * 
     * @return void
     */
    public function logout() {}
    
    /**
     * Permet d'afficher le formulaire d'inscription d'un utilisateur
     *
     * @Route("/register", name="account_register")
     * 
     * @return Response
     */
    public function register(Request $request, ObjectManager $manager, RoleRepository $role, UserPasswordEncoderInterface $encoder){

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user   ->setHash($hash)
                    ->setValidation(1)
                    ->setWish('simple');

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'inscription d'un(e) enseignant(e)
     *
     * @Route("/register-teacher", name="teacher_register")
     * 
     * @return Response
     */
    public function teacherRegister(Request $request, ObjectManager $manager, RoleRepository $role, UserPasswordEncoderInterface $encoder){

        $user = new User();
        
        $teacherRole = 'teachers';

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user   ->setHash($hash)
                    ->setValidation(0)
                    ->setWish($teacherRole);

            $manager->persist($user);
            
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'inscription d'un(e) etudiant(e)
     *
     * @Route("/register-student", name="student_register")
     * 
     * @return Response
     */
    public function studentRegister(Request $request, ObjectManager $manager, RoleRepository $role, UserPasswordEncoderInterface $encoder){

        $user = new User();

        $studentRole = 'students';
        

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user   ->setHash($hash)
                    ->setValidation(0)
                    ->setWish($studentRole);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'inscription d'un foyer
     *
     * @Route("/register-household", name="household_register")
     * 
     * @return Response
     */
    public function householdRegister(Request $request, ObjectManager $manager, RoleRepository $role, UserPasswordEncoderInterface $encoder){

        $user = new User();

        $householdRole = 'households';

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user   ->setHash($hash)
                    ->setValidation(0)
                    ->setWish($householdRole);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Affichage du profil utilisateur 1/ autodidacte
     * 
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function profileUser(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profil ont bien été enregistrées"
            );
        }

        return $this->render('account/profile.html.twig', [
            'form' =>$form->createView()
        ]);
    }
    /**
     * Affichage du profil utilisateur 2/ étudiant(e)
     * 
     * @Route("/student/profile", name="student_profile")
     * 
     * @return Response
     */
    public function profileStudent(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();

        $form = $this->createForm(StudentProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profil ont bien été enregistrées"
            );
        }

        return $this->render('student/profile.html.twig', [
            'form' =>$form->createView()
        ]);
    }
    /**
     * Affichage du profil utilisateur 3/ enseignat(e)
     * 
     * @Route("/teacher/profile", name="teacher_profile")
     * 
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profil ont bien été enregistrées"
            );
        }

        return $this->render('teacher/profile.html.twig', [
            'form' =>$form->createView()
        ]);

    }

    /**
     * Permet de mettre à jour le mot de passe
     * 
     * @Route("/account/password-update", name="account_password")
     *
     * @return Response
     */

    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager){
        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //1. Vérifier que le oldPassword du formulaire soit le même que le password de l'user
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash())){
                //Gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé est erroné"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setHash($hash);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié !"
                );
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);

        return $this->redirectToRoute('homepage');
    }

}
