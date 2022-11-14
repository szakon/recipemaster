<?php

namespace App\Controller\Admin;

use App\Entity\RecipeBook;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RecipeBookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RecipeBook::class;
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
