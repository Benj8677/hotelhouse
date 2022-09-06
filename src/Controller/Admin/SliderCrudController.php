<?php

namespace App\Controller\Admin;

use App\Entity\Slider;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            //ImageField::new('photo'),
            ImageField::new('photo')->setBasePath('img/slider/')->setUploadedFileNamePattern('[ulid].[extension]')->setUploadDir('public/img/slider')->setRequired(false),
            NumberField::new('ordre', 'Ordre'),
            DateTimeField::new('dateModif', 'Date de mise à jour')->setFormat('d/M/y')->onlyOnIndex(),
        ];
    }
    
    public function createEntity(string $entityFqcn)
    {
        $slider = new Slider;

        $file = $slider->getImageFile();

        if (!$file)
        {
            $slider->setPhoto('default.jpg');
        }

        $slider->setDateEnreg(new \DateTime)->setDateModif(new \DateTime);
        return $slider;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setDateModif(new \DateTime);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
