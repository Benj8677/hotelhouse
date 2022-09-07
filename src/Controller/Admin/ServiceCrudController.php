<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField ::new('type')->setChoices([
                'Restaurant' => 'Restaurant',
                'Spa' => 'Spa',
            ])->renderExpanded(),
            TextField::new('titre'),
            ImageField::new('photo')->setBasePath('img/service/')->setUploadedFileNamePattern('[ulid].[extension]')->setUploadDir('public/img/service')->setRequired(false),
            TextareaField::new('descShort'),
            TextEditorField::new('descLong'),
            NumberField::new('prix', 'Prix'),
            NumberField::new('nbPlace', 'Nombre de place'),
            DateTimeField::new('dateModif', 'Date de mise à jour')->setFormat('d/M/y')->onlyOnIndex(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $service = new Service;

        $file = $service->getImageFile();

        if (!$file)
        {
            $service->setPhoto('default.jpg');
        }

        $service->setDateEnreg(new \DateTime)->setDateModif(new \DateTime);
        return $service;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setDateModif(new \DateTime);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
