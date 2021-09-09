<?php

declare(strict_types=1);

namespace HelpScoutDocs\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use HelpScoutDocs\DocsApiClient;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

use function floor;

abstract class TestCase extends PHPUnitTestCase
{
    public function createTestApiClient(MockHandler $mockHandler): DocsApiClient
    {
        $httpClientMock = new Client(['handler' => $mockHandler]);
        $apiClient = new DocsApiClient('');
        $apiClient->setApiKey('X');
        $apiClient->setHttpClient($httpClientMock);

        return $apiClient;
    }

    public function createResponseMock(int $expectedCode, ?string $fixtureFile = null): MockHandler
    {
        $level = (int) floor($expectedCode / 100);

        if ($level === 4 || $level === 5) {
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
                $responseMock = $responseMock->withBody(\GuzzleHttp\Psr7\Utils::streamFor($fixture));
            }
        }

        return new MockHandler([$responseMock]);
    }
}
