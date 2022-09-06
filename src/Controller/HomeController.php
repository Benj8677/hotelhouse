<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\PageRepository;
use App\Repository\SliderRepository;
use App\Repository\ChambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/page/{id}', name: 'app_page')]
    public function page(PageRepository $repo, $id): Response
    {
        $page = $repo->find($id);
        return $this->render('home/page.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(EntityManagerInterface $manager, Request $superglobals): Response
    {
        if ($this->getUser())
        {
            $form = $this->createForm(ContactType::class);

            $form->handleRequest($superglobals);
    
            if ($form->isSubmitted() && $form->isValid())
            {
                if ($this->getUser())
                {
                    $contact = new Contact;
                    $contact->setEmail($form->get("email")->getData());
                    $contact->setContenu($form->get("contenu")->getData());
                    $contact->setTitre($form->get("titre")->getData());
                    $contact->setDateEnreg(new \DateTime());
                    $contact->setMembre($this->getUser());

                    $manager->persist($contact);
                    $manager->flush();
                            
                    $this->addFlash('success', "Votre message a bien été envoyé.");
                    return $this->redirectToRoute('app_compte');
                }
            }

            return $this->renderForm('home/contact.html.twig',[
                'contactForm' => $form,
            ]);
        }
        else
        {
            return $this->redirectToRoute('app_login');
        }
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
