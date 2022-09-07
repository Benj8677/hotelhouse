<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            ImageField::new('photo')->setBasePath('img/page/')->setUploadedFileNamePattern('[ulid].[extension]')->setUploadDir('public/img/page')->setRequired(false),
            TextEditorField::new('contenu'),
        ];
    }
    public function createEntity(string $entityFqcn)
    {
        $page = new Page;

        $page->setDateEnreg(new \DateTime)->setDateModif(new \DateTime);
        return $page;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setDateModif(new \DateTime);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
