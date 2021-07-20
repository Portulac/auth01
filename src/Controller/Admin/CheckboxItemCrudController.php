<?php

namespace App\Controller\Admin;
use App\Form\CheckboxItemType;
use App\Repository\CheckboxItemRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['parent'=>'ASC','name' => 'DESC','description'=>'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('Name');
        yield TextareaField::new('description');
        yield TextField::new('parentStr', 'Parent')->hideOnForm();
        yield AssociationField::new('parent')
            ->setFormTypeOptions([
                'query_builder'=>
                    function (CheckboxItemRepository $checkboxItemRepository){
                        return $checkboxItemRepository->createQueryBuilder('c')
                            ->Where('c.parent is NULL')
                            ->orderBy('c.name', 'ASC');}
            ])
        ->hideOnIndex();
    }
/*
yield FormField::addPanel('Account Information');
yield IntegerField::new('id', 'ID')->onlyOnIndex();
yield BooleanField::new('active');
yield TextField::new('username');
yield TextField::new('email');

yield FormField::addPanel('Legal Information');
yield TextField::new('contract')->setTemplatePath('admin/user/contract.html.twig');

yield FormField::addPanel('Transactions History');
yield AssociationField::new('purchases')->autocomplete();
*/
//todo при редактировании присваивать новое значение
}
