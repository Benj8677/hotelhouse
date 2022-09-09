<?php

namespace App\Controller\Admin;

use App\Entity\Actu;
use App\Entity\Avis;
use App\Entity\Membre;
use App\Entity\Slider;
use App\Entity\Chambre;
use App\Entity\Contact;
use App\Entity\Commande;
use App\Entity\Newsletter;
use App\Entity\Page;
use App\Entity\Service;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //return parent::index();
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // Option 1. Make your dashboard redirect to the same page for all users
        return $this->redirect($adminUrlGenerator->setController(CommandeCrudController::class)->generateUrl());
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
            MenuItem::linkToCrud('Commande', 'fas fa-coins', Commande::class),
            MenuItem::linkToCrud('Membre', 'fas fa-user', Membre::class),
            MenuItem::linkToCrud('Chambre', 'fas fa-moon', Chambre::class),
            MenuItem::linkToCrud('Service', 'fas fa-utensils', Service::class),
            MenuItem::section('Contact'),
            MenuItem::linkToCrud('Message', 'fas fa-envelope', Contact::class),
            //MenuItem::linkToCrud('Avis', 'fas fa-comment', Avis::class),
            MenuItem::linkToCrud('Inscrit Newsletter', 'fas fa-list', Newsletter::class),
            MenuItem::section('Site'),
            MenuItem::linkToCrud('Actualité', 'fas fa-info', Actu::class),
            MenuItem::linkToCrud('Slider', 'fas fa-images', Slider::class),
            MenuItem::linkToCrud('Page du site', 'fas fa-solid fa-file', Page::class),
        ];
    }
}
