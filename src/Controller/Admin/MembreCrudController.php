<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MembreCrudController extends AbstractCrudController
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }    
    
    public static function getEntityFqcn(): string
    {
        return Membre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('pseudo'),
            TextField::new('password')->setFormType(PasswordType::class)->onlyOnForms()->onlyWhenCreating(),
            TextField::new('email'),
            TextField::new('nom'),
            TextField::new('prenom'),
            ChoiceField ::new('civilite')->setChoices([
                'M.' => 'M.',
                'Mme' => 'Mme',
                'Mx' => 'Mx',
        ]),
            CollectionField::new('roles')->setTemplatePath('admin/field/roles.html.twig'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $membre = new Membre;

        $membre->setDateEnreg(new \DateTime);
        return $membre;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance->getId()) {
            $entityInstance->setPassword(
                $this->hasher->hashPassword($entityInstance, $entityInstance->getPassword())
            );
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
