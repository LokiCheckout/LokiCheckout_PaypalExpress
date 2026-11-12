<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Payment\Redirect;

use Magento\Framework\UrlFactory;
use LokiCheckout\Core\Payment\Redirect\RedirectResolverInterface;
use LokiCheckout\Core\Step\FinalStep\RedirectContext;
use Magento\Paypal\Model\Config;

class RedirectResolver implements RedirectResolverInterface
{
    public function __construct(
        private UrlFactory $urlFactory,
    ) {
    }

    public function resolve(RedirectContext $redirectContext): false|string
    {
        $paymentMethod = $redirectContext->getPaymentMethod();
        if (false === $paymentMethod || $paymentMethod->getCode() !== Config::METHOD_WPP_EXPRESS) {
            return false;
        }

        return $this->urlFactory->create()->getUrl('paypal/express/review');
    }
}
