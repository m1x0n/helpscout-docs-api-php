<?php

namespace HelpScoutDocs\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
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
}