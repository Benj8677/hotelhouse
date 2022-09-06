<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Membre;
use App\Entity\Commande;
use App\Form\ResaChambreType;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(Request $superglobals, EntityManagerInterface $manager, CartService $cs): Response
    {
        $cartWithData = $cs->getCartWithData();
        $cs->setNbProduct();
        $cs->setTotalCart();


        $form = $this->createForm(ResaChambreType::class);

        $form->handleRequest($superglobals);

        if ($form->isSubmitted() && $form->isValid())
        {
            if ($this->getUser())
            {
                $commande = new Commande;
                
                $dateD = $form->get("dateDeb")->getData()->getTimestamp();
                $dateR = $form->get("dateFin")->getData()->getTimestamp();
                
                $debut = (new \DateTime())->setTimestamp($dateD);
                $fin = (new \DateTime())->setTimestamp($dateR);
                
                foreach ($cartWithData as $cart)
                {
                    $order = new Order;
                    $order->setChambre($cart['product']);
                    $order->setCommande($commande);
                    $order->setQuantite($cart['quantity']);
                    $commande->addOrder($order);
                    $manager->persist($order);
                }
                $membre = $this->getUser();
                $commande->setDateEnreg(new \DateTime());
                $commande->setMembre($membre);
                $commande->setDateDeb($debut);
                $commande->setDateFin($fin);
                $commande->setPrenom($this->getUser()->getPrenom());
                $commande->setNom($membre->getNom());
                $commande->setEmail($membre->getEmail());
                $commande->setTelephone($form->get("telephone")->getData());
                //dd($commande);
                $manager->persist($commande);
                $manager->flush();

                $cs->removeAll();
                $this->addFlash('success', "Votre réservation a été enregistré !");
                return $this->redirectToRoute('app_compte',[
                    'membre' => $membre,
                ]);
            }
        }



        return $this->renderForm('cart/index.html.twig', [
            'items' => $cartWithData,
            'formCommande' => $form,
        ]);
    }

    #[Route('/compte', name: 'app_compte')]
    public function compte(): Response
    {
        $user = $this->getUser();
        return $this->render('cart/compte.html.twig', [
            'membre' => $user,
        ]);
    }

    #[Route('/cartend', name: 'app_cart_end')]
    public function end(): Response
    {
        return $this->render('cart/compte.html.twig');
    }

    #[Route('/cart/add/{id}', name:'cart_add')]
    public function add($id, CartService $cs)
    {
        $cs->add($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/minus/{id}', name:'cart_min')]
    public function decrement($id, CartService $cs)
    {
        $cs->minus($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name:'cart_remove')]
    public function remove($id, CartService $cs)
    {
        $cs->remove($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/removeAll', name:'cart_destroy')]
    public function removeAll(CartService $cs)
    {
        $cs->removeAll();
        return $this->redirectToRoute('app_cart');
    }
}