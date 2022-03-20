<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Orders;
use App\Entity\Products;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@gmail.com');
        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $user->setRoles([
            'ROLE_USER',
            'ROLE_ADMIN'
        ]);
        $user->setPicture('user.png');
        $manager->persist($user);
        $manager->flush();

        for ($u = 1; $u < 50; $u++)
        {
            $user = new User();
            $user->setEmail('user' . $u . '@gmail.com');
            $password = $this->hasher->hashPassword($user, 'user');
            $user->setPassword($password);
            $user->setRoles([
                'ROLE_USER',
            ]);
            $user->setPicture('user.png');
            $manager->persist($user);
        }
        $manager->flush();

        $productsAPIM = ['Oath', 'Virtual Friends', 'Casual Trouble', 'Broken bricks', 'Komorebi',
            'Written Maze', 'Petrified', 'World Full Of Snakes', 'Grind & Hustle', 'Push Through'];


        $category = new Categories();
        $category->setName('A Promise Is Made');
        $category->setPicture('APromiseIsMade.jpeg');
        foreach($productsAPIM as $product)
        {
            $productEntity = new Products();
            $productEntity->setName($product);
            $productEntity->setStock(rand(1, 200));
            $productEntity->setPrice(rand(1, 5));
            $productEntity->setCategory($category);
            $productEntity->setDescription('this is a description');
            $productEntity->setPicture('APromiseIsMade.jpeg');

            $manager->persist($productEntity);
        }
        $manager->persist($category);

        $manager->flush();

        $productsAMOP = [/*Disque 1*/'Panorama', 'Sunburn (Reimagined)', 'Open Blinds', 'Looking Back (Reimagined)', 'Roadside Flowers', 'Virtual Friends (Reimagined)', 'Treasure Map',
            /*Disque 2*/'Back When (1997)', 'Sunburn', 'Lilypads', 'Homebound', 'Just Now (2017)',
            /*Disque 3*/'the First Wish', 'Weird Machine', 'taking Flight', 'Limbo', 'Step By Step', 'Turn Arround', 'Looking Back',
            /*Disque 4*/'Oath', 'Virtual Friends', 'Casual Trouble', 'Broken bricks', 'Komorebi', 'Written Maze', 'Petrified', 'World Full Of Snakes', 'Grind & Hustle', 'Push Through'];

        $category = new Categories();
        $category->setName('A Matter Of Perspective');
        $category->setPicture('AMatterOfPerspective.jpeg');
        foreach($productsAMOP as $product)
        {
            $productEntity = new Products();
            $productEntity->setName($product);
            $productEntity->setStock(rand(1, 100));
            $productEntity->setPrice(rand(1, 100));
            $productEntity->setCategory($category);
            $productEntity->setDescription('this is a description');
            $productEntity->setPicture('AMatterOfPerspective.jpeg');

            $manager->persist($productEntity);
        }
        $manager->persist($category);
        $manager->flush();


        $productsTCWF = ['the First Wish', 'Weird Machine', 'taking Flight', 'Limbo', 'Step By Step', 'Turn Arround', 'Looking Back'];

        $category = new Categories();
        $category->setName('The choices We Face');
        $category->setPicture('theChoicesWeFace.jpeg');
        foreach($productsTCWF as $product)
        {
            $productEntity = new Products();
            $productEntity->setName($product);
            $productEntity->setStock(rand(1, 200));
            $productEntity->setPrice(rand(1, 5));
            $productEntity->setCategory($category);
            $productEntity->setDescription('this is a description');
            $productEntity->setPicture('theChoicesWeFace.jpeg');

            $manager->persist($productEntity);
        }
        $manager->persist($category);
        $manager->flush();

        $order = new Orders();
        $order->setPrice(1);
        $order->setUser($user);
        $order->setOrderNumber(12);
        $order->addProduct($productEntity);
        $manager->persist($order);
        $manager->flush();


    }
}
