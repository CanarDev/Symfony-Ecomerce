<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoriesRepository $categoriesRepository, ProductsRepository $productsRepository, UserRepository $userRepository, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);

        $cartProducts = [];

        foreach ($cart as $id => $quantityItem) {
            $cartProducts[] = [
                'product' => $productsRepository->find($id),
                'quantity' => $quantityItem,
            ];
        }
        $total = 0;
        foreach ($cartProducts as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
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
