<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoriesRepository $categoriesRepository, ProductsRepository $productsRepository, UserRepository $userRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categoriesRepository->findAll(),
            'products' => $productsRepository->findBy([],array('stock' => 'asc'),8),
        ]);
    }
    public function base(CategoriesRepository $categoriesRepository, UserRepository $userRepository): Response
    {
        return $this->render('home/base.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categoriesRepository->findAll(),
            'users' => $userRepository->findAll(),
        ]);
    }
}
