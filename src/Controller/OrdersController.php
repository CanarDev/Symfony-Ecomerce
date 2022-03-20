<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Orders;
use App\Repository\CategoriesRepository;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class OrdersController extends AbstractController
{
    #[Route('/orders', name: 'app_orders')]
    public function index(CategoriesRepository $categoriesRepository, OrdersRepository $ordersRepository, UserInterface $user): Response
    {
        return $this->render('orders/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
            'orders' => $ordersRepository->findBy(['user' => $user])
        ]);
    }
}
