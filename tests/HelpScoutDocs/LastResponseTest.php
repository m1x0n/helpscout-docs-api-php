<?php

declare(strict_types=1);

namespace HelpScoutDocs\Tests;

use GuzzleHttp\Psr7\Response;

class LastResponseTest extends TestCase
{
    public function testLastResponseShouldBeStored(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getArticles(uniqid('', true));

        $this->assertInstanceOf(Response::class, $apiClient->getLastResponse());
    }
}
