<?php

namespace App\Controller\Admin;

use App\Entity\Chambre;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChambreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chambre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            ImageField::new('photo')->setBasePath('img/chambre/')->setUploadedFileNamePattern('[ulid].[extension]')->setUploadDir('public/img/chambre')->setRequired(false),
            TextareaField::new('descShort'),
            TextEditorField::new('descLong'),
            NumberField::new('prix', 'Prix'),
            NumberField::new('nbChambre', 'Nombre de chambre'),
            DateTimeField::new('dateModif', 'Date de mise à jour')->setFormat('d/M/y')->onlyOnIndex(),
        ];
    }
    
    public function createEntity(string $entityFqcn)
    {
        $chambre = new Chambre;

        $file = $chambre->getImageFile();

        if (!$file)
        {
            $chambre->setPhoto('default.jpg');
        }

        $chambre->setDateEnreg(new \DateTime)->setDateModif(new \DateTime);
        return $chambre;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setDateModif(new \DateTime);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
