<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/product/{!productId}", name="product_page", methods={"GET","HEAD"})
     */
    public function product(string $productId)
    {
        return $this->render('crap.html.twig', [
            'number' => $productId,
        ]);
    }

    /**
     * @Route("/products-for-category/{!categoryId}", name="product_by_category_page", methods={"GET","HEAD"})
     */
    public function productsByCategory(string $categoryId)
    {
        return $this->render('crap.html.twig', [
            'number' => $categoryId,
        ]);
    }

    /**
     * @Route("/products", name="product_full_catalog_page", methods={"GET","HEAD"})
     */
    public function productsCatalog()
    {
        return $this->render('crap.html.twig', [
            'number' => random_int(0, 100),
        ]);
    }
}