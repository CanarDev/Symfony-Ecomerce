<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Category infos'),
            IdField::new('id')->setDisabled()->hideOnIndex()->hideOnForm(),
            FormField::addPanel('Name'),
            TextField::new('name')->setLabel('Category name'),
            FormField::addPanel('Picture'),
            ImageField::new('picture')
                ->setLabel('Category picture')
                ->setBasePath('uploads/category/')
                ->setUploadDir('public/uploads/category/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => 'image/png, image/jpeg'
                    ]
                ]),
            FormField::addTab('Products links'),
            FormField::addPanel('Category products'),
            AssociationField::new('products'),
        ];
    }
}
