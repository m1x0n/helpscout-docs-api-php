<?php

namespace HelpScoutDocs\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
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
        if ($expectedCode >= 400 || $expectedCode >= 500) {
            $response = new Response();
            $response = $response->withStatus($expectedCode);
            $request = new Request('GET', '/');
            $responseMock = new RequestException("", $request, $response);
        } else {
            $responseMock = new Response();
            $responseMock = $responseMock->withStatus($expectedCode);
            $responseMock = $responseMock->withHeader('Location', uniqid());

            if (!empty($fixtureFile)) {
                $fixture = file_get_contents($fixtureFile);
                $responseMock = $responseMock->withBody(\GuzzleHttp\Psr7\stream_for($fixture));
            }
        }

        return new MockHandler([$responseMock]);
    }
}