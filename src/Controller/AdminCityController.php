<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCityController extends AbstractController
{
    /**
     * @Route("/admin/city", name="city_admin")
     */
    public function index(CityRepository $repo)
    {
        $cities = $repo->findAll();

        return $this->render('admin/city/index.html.twig', [
            'cities' => $cities,
        ]);
    }

    /**
     * Ajouter une ville
     * 
     * @Route("/admin/city/add", name="city_add")
     *
     * @return Response
     */
    public function addCity(ObjectManager $manager, Request $request)
    {
        $city = new City();

        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($city);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "ville ajoutée"
            );

            return $this->redirectToRoute('city_admin');
        }

        return $this->render('admin/city/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/city/{slug}", name="city_edit")
     */
    public function editCity(City $city)
    {
        return $this->render('admin/city/show.html.twig', [
            'city' => $city
        ]);
    }
}
