<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Product'),

            IdField::new('id')->setDisabled()->hideOnIndex()->hideOnForm(),
            FormField::addPanel('Product infos'),
            TextField::new('name')->setLabel('Product name'),
            TextField::new('description')->hideOnIndex()->setLabel('Product Description'),
            AssociationField::new('category'),
            FormField::addPanel('Picture'),
            ImageField::new('picture')
                ->setLabel('Product picture')
                ->setBasePath('uploads/product/')
                ->setUploadDir('public/uploads/product/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => 'image/png, image/jpeg'
                    ]
                ]),
            FormField::addTab('Stock & Price'),
            FormField::addPanel('PRICE HERE'),
            NumberField::new('price')->setLabel('Product price'),
            FormField::addPanel('STOCKS HERE'),
            IntegerField::new('stock')->setLabel('Product stock')
                ->formatValue(function ($value) {
                    return $value < 5 ? sprintf('LOW STOCK : %d left', $value) : $value;
                }),
            FormField::addTab('Dates'),
            FormField::addPanel('Dates'),
            DateTimeField::new('createdAt')->setDisabled()->hideOnIndex(),
            DateTimeField::new('updatedAt')->setDisabled()->hideOnIndex(),

        ];
    }
}
