<?php declare(strict_types=1);

namespace Shopware\Storefront\Pagelet\AccountRegistration;

use Shopware\Core\Checkout\CheckoutContext;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Event\NestedEvent;
use Symfony\Component\HttpFoundation\Request;

class AccountRegistrationPageletRequestEvent extends NestedEvent
{
    public const NAME = 'account-registration.pagelet.request.event';

    /**
     * @var CheckoutContext
     */
    protected $context;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var AccountRegistrationPageletRequest
     */
    protected $accountRegistrationPageletRequest;

    public function __construct(Request $request, CheckoutContext $context, AccountRegistrationPageletRequest $registrationPageletRequest)
    {
        $this->context = $context;
        $this->request = $request;
        $this->accountRegistrationPageletRequest = $registrationPageletRequest;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): Context
    {
        return $this->context->getContext();
    }

    public function getCheckoutContext(): CheckoutContext
    {
        return $this->context;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getAccountRegistrationPageletRequest(): AccountRegistrationPageletRequest
    {
        return $this->accountRegistrationPageletRequest;
    }
}