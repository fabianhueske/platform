<?php declare(strict_types=1);

namespace Shopware\Storefront\PageController;

use Shopware\Core\Checkout\CheckoutContext;
use Shopware\Core\Framework\Routing\InternalRequest;
use Shopware\Storefront\Framework\Controller\StorefrontController;
use Shopware\Storefront\Page\Product\ProductPageLoader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductPageController extends StorefrontController
{
    /**
     * @var ProductPageLoader
     */
    private $detailPageLoader;

    public function __construct(ProductPageLoader $detailPageLoader)
    {
        $this->detailPageLoader = $detailPageLoader;
    }

    /**
     * @Route("/detail/{productId}", name="frontend.detail.page", options={"seo"="true"}, methods={"GET"})
     */
    public function index(CheckoutContext $context, InternalRequest $request): Response
    {
        $page = $this->detailPageLoader->load($request, $context);

        return $this->renderStorefront('@Storefront/index/index.html.twig', ['page' => $page]);
    }
}
