<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('User infos'),
            IdField::new('id')->setDisabled()->hideOnForm()->hideOnIndex(),
            FormField::addPanel('User data'),
            TextField::new('email'),

            TextField::new('password')->setDisabled()->hideOnIndex(),
            FormField::addPanel('User picture'),
            ImageField::new('picture')
                ->setLabel('User picture')
                ->setBasePath('uploads/user/')
                ->setUploadDir('public/uploads/user/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => 'image/png, image/jpeg'
                    ]
                ]),
            FormField::addTab('Roles'),
            FormField::addPanel('Role preferences'),
            ChoiceField::new('roles')->allowMultipleChoices()->setChoices([
                'Administrateur' => 'ROLE_ADMIN',
                'User' => 'ROLE_USER',
            ]),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions->remove(Crud::PAGE_INDEX, Action::NEW);
    }
}
