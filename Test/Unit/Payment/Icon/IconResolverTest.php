<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Test\Unit\Payment\Icon;

use LokiCheckout\Core\Payment\Icon\IconResolverContext;
use LokiCheckout\PaypalExpress\Payment\Icon\IconResolver;
use Magento\Framework\Module\Manager as ModuleManager;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IconResolverTest extends TestCase
{
    #[DataProvider('getSupportedCodes')]
    public function testSupportedMethodsGetThePaypalIcon(string $code): void
    {
        $context = $this->createMock(IconResolverContext::class);
        $context->method('getPaymentMethodCode')->willReturn($code);
        $context->expects($this->once())
            ->method('getIconPath')
            ->with('LokiCheckout_PaypalExpress', 'view/frontend/web/images/paypal.svg')
            ->willReturn('/path/paypal.svg');
        $context->expects($this->once())
            ->method('getIconOutput')
            ->with('/path/paypal.svg', 'svg')
            ->willReturn('<svg></svg>');

        $this->assertSame('<svg></svg>', $this->createResolver(true)->resolve($context));
    }

    public function testOtherMethodsAreIgnored(): void
    {
        $context = $this->createMock(IconResolverContext::class);
        $context->method('getPaymentMethodCode')->willReturn('payflow_link');
        $context->expects($this->never())->method('getIconOutput');

        $this->assertFalse($this->createResolver(true)->resolve($context));
    }

    public function testNothingIsResolvedWithoutMagentoPaypal(): void
    {
        $context = $this->createMock(IconResolverContext::class);
        $context->method('getPaymentMethodCode')->willReturn('payflow_express');
        $context->expects($this->never())->method('getIconOutput');

        $this->assertFalse($this->createResolver(false)->resolve($context));
    }

    public static function getSupportedCodes(): array
    {
        return [
            ['paypal_express'],
            ['payflow_express'],
            ['payflow_express_bml'],
        ];
    }

    private function createResolver(bool $isPaypalEnabled): IconResolver
    {
        $moduleManager = $this->createStub(ModuleManager::class);
        $moduleManager->method('isEnabled')->willReturn($isPaypalEnabled);

        return new IconResolver($moduleManager);
    }
}
