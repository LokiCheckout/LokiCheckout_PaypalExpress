<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Payment\Icon;

use Magento\Framework\Module\Manager as ModuleManager;
use LokiCheckout\Core\Payment\Icon\IconResolverContext;
use LokiCheckout\Core\Payment\Icon\IconResolverInterface;
use Magento\Paypal\Model\Config;

class IconResolver implements IconResolverInterface
{
    private const PAYMENT_METHOD_CODES = [
        Config::METHOD_WPP_EXPRESS,
        Config::METHOD_WPP_PE_EXPRESS,
        Config::METHOD_WPP_PE_BML,
    ];

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

        if (false === in_array($paymentMethodCode, self::PAYMENT_METHOD_CODES, true)) {
            return false;
        }

        $iconFilePath = $iconResolverContext->getIconPath(
            'LokiCheckout_PaypalExpress',
            'view/frontend/web/images/paypal.svg'
        );

        return $iconResolverContext->getIconOutput($iconFilePath, 'svg');
    }
}
