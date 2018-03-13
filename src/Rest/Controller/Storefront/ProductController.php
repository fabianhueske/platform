<?php declare(strict_types=1);

namespace Shopware\Rest\Controller\Storefront;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Shopware\Api\Entity\Search\Criteria;
use Shopware\Api\Product\Definition\ProductDefinition;
use Shopware\Product\Exception\ProductNotFoundException;
use Shopware\Rest\Context\ApiStorefrontContext;
use Shopware\Rest\Context\RestContext;
use Shopware\Rest\Response\ResponseFactory;
use Shopware\Storefront\Bridge\Product\Repository\StorefrontProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @var StorefrontProductRepository
     */
    private $repository;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    public function __construct(StorefrontProductRepository $repository, ResponseFactory $responseFactory)
    {
        $this->repository = $repository;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @Route("/storefront-api/product", name="storefront.api.product.list")
     *
     * @param Request                                     $request
     * @param \Shopware\Rest\Context\ApiStorefrontContext $context
     *
     * @return Response
     */
    public function listAction(Request $request, ApiStorefrontContext $context): Response
    {
        $criteria = new Criteria();
        if ($request->query->has('offset')) {
            $criteria->setOffset($request->query->getInt('offset'));
        }
        if ($request->query->has('limit')) {
            $criteria->setLimit($request->query->getInt('limit'));
        }

        $result = $this->repository->search($criteria, $context);

        return $this->responseFactory->createListingResponse(
            $result,
            ProductDefinition::class,
            new RestContext($request, $context->getShopContext(), null)
        );
    }

    /**
     * @Route("/storefront-api/product/{productId}", name="storefront.api.product.detail")
     *
     * @param string               $productId
     * @param ApiStorefrontContext $context
     *
     * @throws ProductNotFoundException
     *
     * @return Response
     */
    public function detailAction(string $productId, ApiStorefrontContext $context, Request $request): Response
    {
        $products = $this->repository->readDetail([$productId], $context);
        if (!$products->has($productId)) {
            throw new ProductNotFoundException($productId);
        }

        return $this->responseFactory->createDetailResponse(
            $products->get($productId),
            ProductDefinition::class,
            new RestContext($request, $context->getShopContext(), null)
        );
    }
}