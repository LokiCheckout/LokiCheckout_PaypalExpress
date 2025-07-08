<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Payment\Redirect;

use Magento\Framework\UrlFactory;
use Yireo\LokiCheckout\Payment\Redirect\RedirectResolverInterface;
use Yireo\LokiCheckout\Step\FinalStep\RedirectContext;

class RedirectResolver implements RedirectResolverInterface
{
    public function __construct(
        private UrlFactory $urlFactory,
    ) {
    }

    public function resolve(RedirectContext $redirectContext): false|string
    {
        return $this->urlFactory->create()->getUrl('paypal/express/review');
    }
}
