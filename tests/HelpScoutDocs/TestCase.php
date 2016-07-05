<?php

namespace HelpScoutDocs\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use HelpScoutDocs\DocsApiClient;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param MockHandler $mockHandler
     * @return DocsApiClient
     */
    public function createTestApiClient(MockHandler $mockHandler)
    {
        $httpClientMock = new Client(['handler' => $mockHandler]);
        $apiClient = new DocsApiClient();
        $apiClient->setKey('X');
        $apiClient->setHttpClient($httpClientMock);

        return $apiClient;
    }

    /**
     * @param int $expectedCode
     * @param null|string $fixtureFile
     * @return MockHandler
     */
    public function createResponseMock($expectedCode, $fixtureFile = null)
    {
        $response = new Response();
        $response = $response->withStatus($expectedCode);
        
        if (!empty($fixtureFile)) {
            $fixture = file_get_contents($fixtureFile);
            $response = $response->withBody(\GuzzleHttp\Psr7\stream_for($fixture));
        }
        
        return new MockHandler([$response]);
    }
}