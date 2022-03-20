<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategoriesRepository $categoriesRepository, SessionInterface $session, ProductsRepository $productsRepository): Response
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
        return $this->render('categories/index.html.twig', [
            'controller_name' => self::class,
            'categories' => $categoriesRepository->findAll()
        ]);
    }

    #[Route('/category/{id}', name: 'app_category')]
    public function show(Categories $category, CategoriesRepository $categoriesRepository, SessionInterface $session, ProductsRepository $productsRepository): Response
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
        return $this->render('categories/show.html.twig', [
            'controller_name' => self::class,
            'category' => $category,
            'categories' => $categoriesRepository->findAll()
        ]);
    }
}
