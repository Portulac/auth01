<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

use App\Entity\Checkbox;
use App\Entity\CheckboxItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use App\Form\CheckboxItemType;

class CheckboxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Checkbox::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('ShortDescription')->hideOnForm(),
            TextEditorField::new('description'),
            NumberField::new('CountItems', 'Count items')->hideOnForm(),
            CollectionField::new('checkboxItems', 'Items')
            ->allowAdd() 
            ->allowDelete()
            ->setEntryIsComplex(true)
            ->setEntryType(CheckboxItemType::class)
            ->setFormTypeOptions([
                'allow_delete' => true,
                'by_reference' => false
            ])->hideOnIndex(),
        ];
    }
    
}
