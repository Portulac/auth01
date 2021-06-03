<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

use App\Entity\CheckboxItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CheckboxItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CheckboxItem::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('checkbox'),
            TextField::new('ShortName')->hideOnForm(),
            TextareaField::new('description')->hideOnIndex(),
        ];
    }
   
}
