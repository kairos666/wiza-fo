<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Repository\PostRepository;
use Psr\Log\LoggerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET","HEAD"})
     * @Template
     */
    public function index(PostRepository $postRepository, LoggerInterface $logger)
    {
        // posts
        $logger->info('get posts list');
        $posts = $postRepository->findAll();

        // routes links
        $logger->info('generate dynamic routes links');
        $routes = [
            $this->generateUrl('home'),
            $this->generateUrl('product_page', [ 'productId' => 'some-product-id' ]),
            $this->generateUrl('product_by_category_page', [ 'categoryId' => 'some-product-category-id', 'unrelated-param' => 'appears-as-querystring-param' ], UrlGeneratorInterface::ABSOLUTE_URL),
            $this->generateUrl('product_full_catalog_page'),
        ];

        return [
            'posts' => $posts,
            'routes' => $routes,
        ];
    }
}
