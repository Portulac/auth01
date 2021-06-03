<?php

namespace App\Controller\Admin;

use App\Entity\Checkbox;
use App\Entity\CheckboxItem;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        //$routeBuilder = $this->get(CrudUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(CheckboxCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Easyadmin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Important');
        yield MenuItem::linkToCrud('Checkboxes', 'fa fa-file', Checkbox::class);
        yield MenuItem::linkToCrud('CheckboxItems', 'fa fa-file', CheckboxItem::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-file', User::class);
    }
}
