<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Newsletter;
use App\Form\ContactType;
use App\Form\NewsletterType;
use App\Repository\ActuRepository;
use App\Repository\PageRepository;
use App\Repository\SliderRepository;
use App\Repository\ChambreRepository;
use App\Repository\ServiceRepository;
use App\Repository\NewsletterRepository;
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

    #[Route('/actu', name: 'app_actu')]
    public function actu(ActuRepository $repo): Response
    {
        $actu = $repo->findBy([], ["dateActu" => "DESC"]);
        return $this->render('home/actu.html.twig', [
            'tabActus' => $actu,
        ]);
    }

    #[Route('/restaurants', name: 'app_restaurants')]
    public function restos(ServiceRepository $repo): Response
    {
        $restaurants = $repo->findBy(["type" => "Restaurant"], ["id" => "ASC"]);
        return $this->render('home/restaurants.html.twig', [
            'tabRestaurants' => $restaurants,
        ]);
    }

    #[Route('/restaurant/{id}', name: 'app_restaurant')]
    public function resto(ServiceRepository $repo, $id): Response
    {
        $restaurant = $repo->find($id);
        return $this->render('home/restaurant.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    #[Route('/spas', name: 'app_spas')]
    public function spas(ServiceRepository $repo): Response
    {
        $spas = $repo->findBy(["type" => "Spa"], ["id" => "ASC"]);
        return $this->render('home/spas.html.twig', [
            'tabSpas' => $spas,
        ]);
    }

    #[Route('/spa/{id}', name: 'app_spa')]
    public function spa(ServiceRepository $repo, $id): Response
    {
        $spa = $repo->find($id);
        return $this->render('home/spa.html.twig', [
            'spa' => $spa,
        ]);
    }

    #[Route('/newsletter', name: 'app_news')]
    public function news(NewsletterRepository $repo, Request $superglobals, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(NewsletterType::class);

        $form->handleRequest($superglobals);

        $action = $superglobals->query->get('action');
        $email = $superglobals->query->get('email');

        if ($form->isSubmitted() && $form->isValid())
        {
            $action = $repo->find($form->get("action")->getData());
            $email = $repo->find($form->get("email")->getData());
        }

        if (!empty($action) && $action=='add')
        {
            //$verif = $repo->find($form->get("email")->getData());
            if ($repo->findBy(["email" => $email]))
            {
                $this->addFlash('error', "Adresse e-mail déjà enregistrée.");
                return $this->redirectToRoute('app_news');
            }
            else
            {
                $news = new Newsletter;
                $news->setEmail($email);
                $manager->persist($news);
                $manager->flush();
                        
                $this->addFlash('success', "Votre adresse e-mail a bien été enregistrée.");
                return $this->redirectToRoute('app_news');
            }
        }
        elseif (!empty($action) && $action=='sup')
        {
            //$verif = $repo->find($form->get("email")->getData());
            if ($repo->findBy(["email" => $email]))
            {
                $news = $repo->findOneBy(["email" => $email]);
                $manager->remove($news);
                $manager->flush();
                $this->addFlash('success', "Vous n'êtes plus inscrit à notre newsletter.");
                return $this->redirectToRoute('app_news');
            }
            else
            {
                $this->addFlash('error', "L'adresse e-mail n'est pas enregistrée.");
                return $this->redirectToRoute('app_news');
            }
        }
        else
        {
            return $this->renderForm('home/news.html.twig',[
                'newsletterForm' => $form,
            ]);
        }
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
