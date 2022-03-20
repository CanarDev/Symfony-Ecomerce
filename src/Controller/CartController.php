<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CategoriesRepository $categoriesRepository, ProductsRepository $productsRepository, SessionInterface $session): Response
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
        return $this->render('cart/index.html.twig', [
            'controller_name' => self::class,
            'items' => $cartProducts,
            'total' => $total,
            'categories' => $categoriesRepository->findAll(),
        ]);
    }


    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);
        if(!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }


    #[Route('/cart/delete/{id}', name: 'cart_delete')]
    public function del($id, SessionInterface $session)
    {
        $cart = $session->get('cart', []);
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
            $session->set('cart', $cart);
            return $this->redirectToRoute('app_cart');
        }
    }

    #[Route('/cart/checkout', name: 'cart_checkout')]
    public function check(SessionInterface $session, UserInterface $user, EntityManagerInterface $manager, ProductsRepository $productsRepository)
    {
        $cart = $session->get('cart', []);

        $cartProducts = [];
        foreach ($cart as $id => $quantityItem) {
            $cartProducts[] = [
                'product' => $productsRepository->find($id),
                'quantity' => $quantityItem,
            ];
        }
        $order = new Orders();
        $total = 0;
        foreach ($cartProducts as $n){
            $total += $n['product']->getPrice() * $n['quantity'];
            $order->addProduct($n['product']);
            $product = $productsRepository->find($n['product']);
            $product->setStock($product->getStock() - $n['quantity']);
        }
        $order->setPrice($total);
        $order->setOrderNumber(1);
        $order->setUser($user);
        $manager->persist($order);
        $manager->flush();



        $session->set('cart', []);
        return $this->redirectToRoute('app_orders');
    }
}
