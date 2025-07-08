<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Component\PaypalExpress;

use Magento\Framework\Data\Form\FormKey;
use Yireo\LokiCheckout\ViewModel\CheckoutState;
use Yireo\LokiComponents\Component\ComponentViewModel;

class PaypalExpressViewModel extends ComponentViewModel
{
    public function __construct(
        private CheckoutState $checkoutState,
        private FormKey $formKey,
    ) {
    }

    public function getAmount(): float
    {
        return $this->checkoutState->getQuote()->getGrandTotal();
    }

    public function getJsComponentName(): ?string
    {
        return 'LokiCheckoutPaypalExpress';
    }

    public function getJsData(): array
    {
        return [
            ...parent::getJsData(),
            'formKey' => $this->formKey->getFormKey(),
            'quoteId' => $this->checkoutState->getMaskedQuoteId(),
            'customerId' => (int)$this->checkoutState->getCustomerSession()->getId(),
        ];
    }
}
