<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Repository\PostRepository;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;
use Wizaplace\SDK\ApiClient;
use Wizaplace\SDK\Catalog\CatalogService;

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

        // wizaplace api example call
        $marketplaceApiUri = 'https://sandbox.wizaplace.com/api/v1/'; // replace that value with your own
        $httpClient = new Client(
            [
                'base_uri' => $marketplaceApiUri,
            ]
        );
        $wizaplaceClient = new ApiClient($httpClient);
        $catalogService = new CatalogService($wizaplaceClient);
        $userToken = $wizaplaceClient->authenticate('davidmaggi57@gmail.com', 'wizapass');
        $categories = $catalogService->getCategories();

        return [
            'posts' => $posts,
            'routes' => $routes,
            'token' => $userToken,
            'categories' => $categories,
        ];
    }
}
