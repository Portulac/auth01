<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChecklistController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    
    public function homepage()
    {
        
        return $this->render('checklist/index.html.twig', [
            'controller_name' => 'ChecklistController',
        ]);
    }

    /**
     * @Route("/checklist", name="checklist")
     */
    
    public function index(): Response
    {
        return $this->render('checklist/index.html.twig', [
            'controller_name' => 'ChecklistController',
        ]);
    }
}
