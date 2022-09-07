<?php

namespace App\Controller\Admin;

use App\Entity\Actu;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actu::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('chambre', 'Chambre'),
            AssociationField::new('service', 'Service'),
            TextField::new('titre'),
            TextEditorField::new('contenu'),
            ImageField::new('photo')->setBasePath('img/actu/')->setUploadedFileNamePattern('[ulid].[extension]')->setUploadDir('public/img/actu')->setRequired(false),
            DateTimeField::new('dateActu', 'Date d\'effet de l\'actu')->setFormat('d/M/y'),
            DateTimeField::new('dateModif', 'Date de mise à jour')->setFormat('d/M/y')->onlyOnIndex(),
        ];
    }
    

    public function createEntity(string $entityFqcn)
    {
        $actu = new Actu;

        $file = $actu->getImageFile();

        if (!$file)
        {
            $actu->setPhoto('default.jpg');
        }

        $actu->setDateEnreg(new \DateTime)->setDateModif(new \DateTime);
        return $actu;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setDateModif(new \DateTime);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

}
