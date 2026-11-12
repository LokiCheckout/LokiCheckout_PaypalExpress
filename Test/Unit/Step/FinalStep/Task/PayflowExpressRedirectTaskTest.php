<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Test\Unit\Step\FinalStep\Task;

use Loki\Components\Exception\RedirectException;
use LokiCheckout\PaypalExpress\Step\FinalStep\Task\PayflowExpressRedirectTask;
use Magento\Framework\UrlInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Payment;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PayflowExpressRedirectTaskTest extends TestCase
{
    #[DataProvider('getPayflowExpressMethods')]
    public function testPayflowExpressRedirectsToPaypalBeforeTheOrderIsPlaced(string $method, string $route): void
    {
        $quote = $this->createQuote($method);
        $cartRepository = $this->createMock(CartRepositoryInterface::class);
        $cartRepository->expects($this->once())->method('save')->with($quote);

        $url = $this->createMock(UrlInterface::class);
        $url->expects($this->once())
            ->method('getUrl')
            ->with($route, ['_secure' => true])
            ->willReturn('https://example.com/' . $route . '/');

        $task = new PayflowExpressRedirectTask($cartRepository, $url);

        try {
            $task->beforePlaceOrder($quote);
            $this->fail('Expected a redirect');
        } catch (RedirectException $exception) {
            $this->assertSame('https://example.com/' . $route . '/', $exception->getUrl());
        }
    }

    #[DataProvider('getOtherMethods')]
    public function testNothingHappensForOtherMethods(string $method): void
    {
        $cartRepository = $this->createMock(CartRepositoryInterface::class);
        $cartRepository->expects($this->never())->method('save');
        $url = $this->createMock(UrlInterface::class);
        $url->expects($this->never())->method('getUrl');

        $task = new PayflowExpressRedirectTask($cartRepository, $url);
        $task->beforePlaceOrder($this->createQuote($method));
        $task->afterPlaceOrder(42);
    }

    public static function getPayflowExpressMethods(): array
    {
        return [
            ['payflow_express', 'paypal/payflowexpress/start'],
            ['payflow_express_bml', 'paypal/payflowbml/start'],
        ];
    }

    public static function getOtherMethods(): array
    {
        return [
            ['paypal_express'],
            ['payflow_link'],
            ['checkmo'],
            [''],
        ];
    }

    private function createQuote(string $paymentMethod): Quote
    {
        $payment = $this->createStub(Payment::class);
        $payment->method('getMethod')->willReturn($paymentMethod);

        $quote = $this->createStub(Quote::class);
        $quote->method('getPayment')->willReturn($payment);

        return $quote;
    }
}
