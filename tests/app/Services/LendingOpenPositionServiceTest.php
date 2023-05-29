<?php

namespace Tests\App\Http\Repositories;

use App\Repositories\LendingOpenPositionRepository;
use App\Services\LendingOpenPositionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

# docker-compose exec app php artisan test --filter=LendingOpenPositionServiceTest
class LendingOpenPositionServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * docker-compose exec app php artisan test --filter=LendingOpenPositionServiceTest::testClassService
     *
     * Checks if the service class is behaving as expected
     *
     * @return void
     */
    public function testClassService()
    {
        // New instance Service
        $service = new LendingOpenPositionService();

        // Assert that the 'getPapers' exists in the LendingOpenPositionService.
        // This test ensures that the desired function is implemented and available for use.
        $this->assertTrue(method_exists($service, 'getPapers'));
    }
}
