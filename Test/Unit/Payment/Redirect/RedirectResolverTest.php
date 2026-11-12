<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Test\Unit\Payment\Redirect;

use LokiCheckout\Core\Step\FinalStep\RedirectContext;
use LokiCheckout\PaypalExpress\Payment\Redirect\RedirectResolver;
use Magento\Framework\Url;
use Magento\Framework\UrlFactory;
use Magento\Payment\Model\MethodInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RedirectResolverTest extends TestCase
{
    public function testRedirectsPaypalExpressToTheReviewPage(): void
    {
        $url = $this->createMock(Url::class);
        $url->expects($this->once())
            ->method('getUrl')
            ->with('paypal/express/review')
            ->willReturn('https://example.com/paypal/express/review/');
        $urlFactory = $this->createStub(UrlFactory::class);
        $urlFactory->method('create')->willReturn($url);

        $resolver = new RedirectResolver($urlFactory);

        $this->assertSame(
            'https://example.com/paypal/express/review/',
            $resolver->resolve($this->createContext('paypal_express'))
        );
    }

    #[DataProvider('getOtherMethodCodes')]
    public function testIgnoresOtherMethods(?string $methodCode): void
    {
        $urlFactory = $this->createMock(UrlFactory::class);
        $urlFactory->expects($this->never())->method('create');

        $resolver = new RedirectResolver($urlFactory);

        $this->assertFalse($resolver->resolve($this->createContext($methodCode)));
    }

    public static function getOtherMethodCodes(): array
    {
        return [
            ['payflow_link'],
            ['payflow_express'],
            ['checkmo'],
            [null],
        ];
    }

    private function createContext(?string $methodCode): RedirectContext
    {
        $context = $this->createStub(RedirectContext::class);
        if ($methodCode === null) {
            $context->method('getPaymentMethod')->willReturn(false);
            return $context;
        }

        $method = $this->createStub(MethodInterface::class);
        $method->method('getCode')->willReturn($methodCode);
        $context->method('getPaymentMethod')->willReturn($method);

        return $context;
    }
}
