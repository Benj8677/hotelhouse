<?php

namespace App\Controller\Admin;

use App\Entity\Chambre;
use App\Entity\Membre;
use App\Entity\Slider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hotel House');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToRoute('retour au site', 'fa fa-home', 'app_home'),
            MenuItem::section('Hotel'),
            MenuItem::linkToCrud('Chambre', 'fas fa-moon', Chambre::class),
            MenuItem::linkToCrud('Membre', 'fas fa-user', Membre::class),
            MenuItem::section('Site'),
            MenuItem::linkToCrud('Slider', 'fas fa-images', Slider::class),
        ];
    }
}
