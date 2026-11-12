<?php declare(strict_types=1);

namespace LokiCheckout\PaypalExpress\Test\Integration;

use LokiCheckout\Core\Step\FinalStep\TaskListing;
use LokiCheckout\PaypalExpress\Step\FinalStep\Task\PayflowExpressRedirectTask;
use Magento\TestFramework\Fixture\AppArea;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;

#[AppArea('frontend')]
class RegistrationTest extends TestCase
{
    public function testFinalStepTaskIsRegistered(): void
    {
        $tasks = Bootstrap::getObjectManager()->create(TaskListing::class)->getTasks();

        $this->assertContains(PayflowExpressRedirectTask::class, array_map('get_class', $tasks));
    }

    public function testFinalStepTaskRunsAfterTheCoreTasks(): void
    {
        $taskNames = array_keys(Bootstrap::getObjectManager()->create(TaskListing::class)->getTasks());

        $position = array_search('paypalPayflowExpressRedirect', $taskNames, true);
        $this->assertIsInt($position);

        foreach (['agreements', 'saveInAddressBook', 'newsletter'] as $coreTaskName) {
            $coreTaskPosition = array_search($coreTaskName, $taskNames, true);
            $this->assertIsInt($coreTaskPosition, $coreTaskName);
            $this->assertLessThan($position, $coreTaskPosition, $coreTaskName);
        }
    }
}
