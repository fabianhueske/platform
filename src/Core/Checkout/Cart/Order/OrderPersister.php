<?php declare(strict_types=1);

namespace Shopware\Core\Checkout\Cart\Order;

use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\Exception\CustomerNotLoggedInException;
use Shopware\Core\Checkout\Cart\Exception\InvalidCartException;
use Shopware\Core\Checkout\CheckoutContext;
use Shopware\Core\Checkout\Order\Exception\DeliveryWithoutAddressException;
use Shopware\Core\Checkout\Order\Exception\EmptyCartException;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenContainerEvent;

class OrderPersister implements OrderPersisterInterface
{
    /**
     * @var EntityRepositoryInterface
     */
    private $repository;

    /**
     * @var OrderConverter
     */
    private $converter;

    public function __construct(EntityRepositoryInterface $repository, OrderConverter $converter)
    {
        $this->repository = $repository;
        $this->converter = $converter;
    }

    /**
     * @throws CustomerNotLoggedInException
     * @throws DeliveryWithoutAddressException
     * @throws EmptyCartException
     * @throws InvalidCartException
     */
    public function persist(Cart $cart, CheckoutContext $context): EntityWrittenContainerEvent
    {
        if ($cart->getErrors()->blockOrder()) {
            throw new InvalidCartException($cart->getErrors());
        }

        if (!$context->getCustomer()) {
            throw new CustomerNotLoggedInException();
        }
        if ($cart->getLineItems()->count() <= 0) {
            throw new EmptyCartException();
        }

        $order = $this->converter->convertToOrder($cart, $context, new OrderConversionContext());

        return $this->repository->create([$order], $context->getContext());
    }
}
