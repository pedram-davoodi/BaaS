<?php

namespace Modules\Shop\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends \Tests\TestCase
{
    use RefreshDatabase;

    protected array $headers = ['accept' => 'application/json'];

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->artisan('passport:install');
    }
}
