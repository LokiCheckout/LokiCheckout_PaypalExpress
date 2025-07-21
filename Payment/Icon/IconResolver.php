<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Payment\Icon;

use Magento\Framework\Module\Manager as ModuleManager;
use LokiCheckout\Core\Payment\Icon\IconResolverContext;
use LokiCheckout\Core\Payment\Icon\IconResolverInterface;

class IconResolver implements IconResolverInterface
{
    public function __construct(
        private ModuleManager $moduleManager,
    ) {
    }

    public function resolve(IconResolverContext $iconResolverContext): false|string
    {
        $paymentMethodCode = $iconResolverContext->getPaymentMethodCode();
        if (false === $this->moduleManager->isEnabled('Magento_Paypal')) {
            return false;
        }

        if ($paymentMethodCode !== 'paypal_express') {
            return false;
        };

        $iconFilePath = $iconResolverContext->getIconPath(
            'LokiCheckout_PaypalExpress',
            'view/frontend/web/images/paypal.svg'
        );

        return $iconResolverContext->getIconOutput($iconFilePath, 'svg');
    }
}
