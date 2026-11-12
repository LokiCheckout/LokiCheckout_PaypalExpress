<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Test\Integration;

use PHPUnit\Framework\TestCase;
use Yireo\IntegrationTestHelper\Test\Integration\Traits\AssertModuleIsEnabled;
use Yireo\IntegrationTestHelper\Test\Integration\Traits\AssertModuleIsRegistered;

class ModuleTest extends TestCase
{
    use AssertModuleIsEnabled;
    use AssertModuleIsRegistered;

    public function testModule(): void
    {
        foreach (['LokiCheckout_PaypalExpress', 'LokiCheckout_Core', 'Magento_Paypal', 'Magento_Quote'] as $moduleName) {
            $this->assertModuleIsEnabled($moduleName);
            $this->assertModuleIsRegistered($moduleName);
        }
    }
}
