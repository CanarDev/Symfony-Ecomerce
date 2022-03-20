<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(ProductsRepository $productsRepository, CategoriesRepository $categoriesRepository, Request $request): Response
    {
        if ($request->get('sortBy')){
            $products = $productsRepository->findBy([], [
                'price' => $request->get('sortBy')
            ]);
            //if ($request->get('sortBy') && $request->get('sortBy') === 'asc'){
            //    $products = $productsRepository->findBy([], [
            //        'price' => 'asc'
            //    ]);
            //} elseif ($request->get('sortBy') && $request->get('sortBy') === 'desc') {
            //    $products = $productsRepository->findBy([], [
            //        'price' => 'desc'
            //    ]);
        } else {
            $products = $productsRepository->findAll();
        }


        return $this->render('products/index.html.twig', [
            'controller_name' => self::class,
            'products' => $products,
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route('/product/{id}', name: 'app_product')]
    public function show(Products $product, CategoriesRepository $categoriesRepository, ProductsRepository $productsRepository): Response
    {
        //$product = $productsRepository->find($id);
        return $this->render('products/show.html.twig', [
            'controller_name' => self::class,
            'product' => $product,
            'categories' => $categoriesRepository->findAll(),
            'productLinked' => $productsRepository->findBy(['category'=> $product->getCategory()],[],4)
        ]);
    }
}
