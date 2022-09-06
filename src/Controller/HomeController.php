<?php

namespace App\Controller;

use App\Repository\SliderRepository;
use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SliderRepository $repo): Response
    {
        $sliders = $repo->findBy([], ['ordre' => 'ASC']);
        return $this->render('home/index.html.twig', [
            'sliders' => $sliders,
        ]);
    }

    #[Route('/chambres', name: 'app_chambres')]
    public function listeChambre(ChambreRepository $repo): Response
    {
        $chambres = $repo->findAll();
        return $this->render('home/chambres.html.twig', [
            'tabChambres' => $chambres,
        ]);
    }

    #[Route('/chambre/{id}', name: 'app_chambre')]
    public function showChambre(ChambreRepository $repo, $id): Response
    {
        $chambre = $repo->find($id);
        return $this->render('home/showChambre.html.twig', [
            'chambre' => $chambre,
        ]);
    }
}
