<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\CheckType;
use App\Form\SiteType;
use App\Repository\SiteRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ChecklistController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    
    public function index(SiteRepository $siteRepository): Response
    {
   
        $user = $this->getUser();
        
        $sites = $siteRepository->createQueryBuilder('s')
            ->andWhere('s.user = ('.$user->getId().')')
            ->getQuery()
            ->getResult()
        ;
        return $this->render('checklist/index.html.twig', [
            'sites' => $sites,
        ]);
       
    }
    
    /**
     * @Route("/{id}/check", name="site_check", methods={"GET"})
     */
    public function check(Request $request, Site $site): Response
    {
        $form = $this->createForm(CheckType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('checklist/check.html.twig', [
            'site' => $site,
            'form' => $form->createView()
        ]);

    }

}
