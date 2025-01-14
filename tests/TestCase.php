<?php

use Illuminate\Support\Facades\Artisan;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public function setupDatabase()
    {
        Artisan::call('migrate:refresh');
    }

    protected function mockGuzzle(array $response_stack)
    {
        $mock_responses = [];
        foreach ($response_stack as $response) {
            $mock_responses[] = new Response($response['code'], [], json_encode($response['content']));
        }
        $mock = new MockHandler($mock_responses);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->app->instance('GuzzleHttp\Client', $client);
    }
}
