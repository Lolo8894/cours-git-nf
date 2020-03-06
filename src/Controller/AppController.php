<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="app_index")
     */
    public function index()
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

      /**
     * @Route("/services", methods={"GET"}, name="app_services")
     */
        
    public function services()
    {
        return $this->render('app/services.html.twig', [
            'title' => 'Mes services',
        ]);
    }

      /**
     * @Route("/about", methods={"GET"}, name="app_about")
     */
        
    public function about()
    {
        return $this->render('app/about.html.twig', [
            'title' => 'A propos',
        ]);
    }

      /**
     * @Route("/cgv", methods={"GET"}, name="app_cgv")
     */
        
    public function cgv()
    {
        return $this->render('app/cgv.html.twig', [
            'title' => 'Conditions générales de ventes',
        ]);
    }
}
