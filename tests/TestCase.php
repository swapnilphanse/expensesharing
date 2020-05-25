<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use DB;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        if (DB::connection() instanceof \Illuminate\Database\SQLiteConnection) {
            DB::statement(DB::raw('PRAGMA foreign_keys=on'));
        }
    }

    public function tearDown(): void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
