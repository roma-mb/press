<?php

namespace RomaMb\Press\Tests;

use RomaMb\Press\PressBaseServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/../database/factories');
    }

    /** @inheritDoc */
    protected function getPackageProviders($app): array
    {
        return [
            PressBaseServiceProvider::class,
        ];
    }

    /** @inheritDoc */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }
}
