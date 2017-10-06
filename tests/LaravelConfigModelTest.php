<?php

use Fnp\Dto\Config\LaravelConfigModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;

class LaravelConfigModelTest extends Orchestra\Testbench\TestCase
{
    public function provideConfigData()
    {
        return [
            'session' => [
                'driver'          => env('SESSION_DRIVER', 'file'),
                'lifetime'        => 120,
                'expire_on_close' => FALSE,
                'encrypt'         => FALSE,
                'files'           => storage_path('framework/sessions'),
                'connection'      => NULL,
                'table'           => 'sessions',
                'store'           => NULL,
                'lottery'         => [2, 100],
                'cookie'          => 'laravel_session',
                'path'            => '/',
                'domain'          => env('SESSION_DOMAIN', NULL),
                'secure'          => env('SESSION_SECURE_COOKIE', FALSE),
                'http_only'       => TRUE,
            ],
            'queue'   => [
                'connections' => [
                    'sync'       => [
                        'driver' => 'sync',
                    ],
                    'database'   => [
                        'driver'      => 'database',
                        'table'       => 'jobs',
                        'queue'       => 'default',
                        'retry_after' => 90,
                    ],
                    'beanstalkd' => [
                        'driver'      => 'beanstalkd',
                        'host'        => 'localhost',
                        'queue'       => 'default',
                        'retry_after' => 90,
                    ],
                    'sqs'        => [
                        'driver' => 'sqs',
                        'key'    => 'your-public-key',
                        'secret' => 'your-secret-key',
                        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
                        'queue'  => 'your-queue-name',
                        'region' => 'us-east-1',
                    ],
                    'redis'      => [
                        'driver'      => 'redis',
                        'connection'  => 'default',
                        'queue'       => 'default',
                        'retry_after' => 90,
                    ],
                ],
            ],
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $data = $this->provideConfigData();

        foreach ($data as $key => $value) {
            $app['config']->set($key, $value);
        }
    }

    public function testLaravelConfig()
    {
        $data = $this->provideConfigData();

        /** @var LaravelConfig $config */
        $config = $this->app->make(LaravelConfig::class);

        /*
         * Simple Mapping
         */
        $this->assertEquals(Arr::get($data, 'session.driver'), $config->driver);
        $this->assertEquals(Arr::get($data, 'session.lifetime'), $config->lifetime);
        $this->assertEquals(Arr::get($data, 'queue.connections.database.table'), $config->queueDatabaseTable);

        /*
         * With fill method
         */
        $this->assertEquals(strtoupper(Arr::get($data, 'queue.connections.sqs.key')), $config->queueSqsKey);


        /*
         * Overrides
         */
        $this->assertEquals(1, $config->redisRetry);
        $this->assertEquals(2, $config->redisQueue);
        $this->assertEquals(3, $config->redisConnections);
        $this->assertEquals(4, $config->testingOnly);
        $this->assertEquals(3, $config->anotherTestingOnly);
    }

    public function testEnvironmentConfig()
    {
        /** @var EnvConfig $config */
        $config = $this->app->make(EnvConfig::class);

        $this->assertEquals('testing', $config->appEnv);
        $this->assertEquals(120, $config->lifetime);
        $this->assertEquals('SOME_VALUE_TESTING', $config->someValue);
        $this->assertEquals('YOUR-PUBLIC-KEY', $config->getPrivate());
    }
}

class LaravelConfig extends LaravelConfigModel
{
    public $driver             = 'session.driver';
    public $lifetime           = 'session.lifetime';
    public $queueDatabaseTable = 'queue.connections.database.table';
    public $queueSqsKey        = 'queue.connections.sqs.key';
    public $redisRetry         = 'queue.connections.redis.retry_after';
    public $redisQueue         = 'queue.connections.redis.queue';
    public $redisConnections   = 'queue.connections.redis.connection';
    public $testingOnly;
    public $anotherTestingOnly;

    public function fillQueueSqsKey($key)
    {
        return strtoupper($key);
    }

    public function getConfig()
    {
        return [
            'redisRetry'       => 1,
            'redisQueue'       => 1,
            'redisConnections' => 1,
        ];
    }

    public function setConfig()
    {
        $this->redisQueue = 2;
    }

    public function getTestingConfig()
    {
        return [
            'redisConnections'   => 3,
            'testingOnly'        => 3,
            'anotherTestingOnly' => 3,
        ];
    }

    public function setTestingConfig()
    {
        $this->testingOnly = 4;
    }

    public function getSomeValue(Application $app)
    {
        return 'SOME_VALUE_' . strtoupper($app->environment());
    }
}

class EnvConfig extends LaravelConfigModel
{
    public  $appEnv    = '#APP_ENV';
    public  $lifetime  = 'LaravelConfig@lifetime';
    public  $someValue = 'LaravelConfig@getSomeValue()';
    private $hidden   = 'LaravelConfig@queueSqsKey';

    public function getPrivate()
    {
        return $this->hidden;
    }
}