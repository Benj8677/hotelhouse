<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('membre', 'Utilisateur'),
            TextField::new('titre'),
            TextField::new('email'),
            TextEditorField::new('contenu'),
            DateTimeField::new('dateEnreg', 'Date du message')->setFormat('d/M/y')->onlyOnIndex(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $contact = new Contact;

        $contact->setDateEnreg(new \DateTime);
        return $contact;
    }
}
