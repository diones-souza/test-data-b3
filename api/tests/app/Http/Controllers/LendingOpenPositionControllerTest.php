<?php

namespace Tests\App\Http\Controllers;

use App\Models\LendingOpenPosition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

# docker-compose exec app php artisan test --filter=LendingOpenPositionControllerTest
class LendingOpenPositionControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * docker-compose exec app php artisan test --filter=LendingOpenPositionControllerTest::testGetPapers
     *
     * @return void
     */
    public function testGetPapers()
    {
        // Send a GET request to try to get the items
        $response = $this->get('api/lending-open-position/papers');

        // Check the HTTP status of the response
        $response->assertStatus(200);
    }

    /**
     * docker-compose exec app php artisan test --filter=LendingOpenPositionControllerTest::testGetPaperData
     *
     * @return void
     */
    public function testGetPaperData()
    {
        // Send a GET request to try to get the items
        $response = $this->get('api/lending-open-position/paper-data');

        // Check the HTTP status of the response
        $response->assertStatus(200);
    }
}
