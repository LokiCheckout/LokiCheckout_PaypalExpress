<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Step\FinalStep\Task;

use Loki\Components\Exception\RedirectException;
use LokiCheckout\Core\Step\FinalStep\Task\TaskInterface;
use Magento\Framework\UrlInterface;
use Magento\Paypal\Model\Config;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Quote;

class PayflowExpressRedirectTask implements TaskInterface
{
    private const START_ROUTES = [
        Config::METHOD_WPP_PE_EXPRESS => 'paypal/payflowexpress/start',
        Config::METHOD_WPP_PE_BML => 'paypal/payflowbml/start',
    ];

    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly UrlInterface $url,
    ) {
    }

    /**
     * @throws RedirectException
     */
    public function beforePlaceOrder(Quote $quote): void
    {
        $paymentMethodCode = (string)$quote->getPayment()->getMethod();
        if (false === isset(self::START_ROUTES[$paymentMethodCode])) {
            return;
        }

        $this->cartRepository->save($quote);

        $redirectUrl = $this->url->getUrl(self::START_ROUTES[$paymentMethodCode], ['_secure' => true]);
        throw (new RedirectException())->setUrl($redirectUrl);
    }

    public function afterPlaceOrder(int $orderId): void
    {
        return;
    }
}
