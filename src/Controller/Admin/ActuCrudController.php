<?php

namespace App\Controller\Admin;

use App\Entity\Actu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actu::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
