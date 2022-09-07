<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('dateDeb', 'Date d\'arrivée')->setFormat('d/M/y'),
            DateTimeField::new('dateFin', 'Date de départ')->setFormat('d/M/y'),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email'),
            TextField::new('telephone'),
            DateTimeField::new('dateEnreg', 'Date de mise à jour')->setFormat('d/M/y')->onlyOnIndex(),
        ];
    }
    

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::DELETE, Action::EDIT);
    }
}
