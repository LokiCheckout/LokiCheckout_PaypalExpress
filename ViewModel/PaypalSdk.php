<?php
namespace LokiCheckout\PaypalExpress\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Paypal\Model\SdkUrl;

class PaypalSdk implements ArgumentInterface
{
    public function __construct(
        private SdkUrl $sdkUrl,
    ) {
    }

    public function getSdkUrl(): string
    {
        return $this->sdkUrl->getUrl();
    }
}
