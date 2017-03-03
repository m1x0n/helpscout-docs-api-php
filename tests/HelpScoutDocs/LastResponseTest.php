<?php

namespace HelpScoutDocs\Test;

use GuzzleHttp\Psr7\Response;
use HelpScoutDocs\Tests\TestCase;

class LastResponseTest extends TestCase
{
    public function test_last_response_should_be_stored()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getArticles(uniqid());

        $this->assertInstanceOf(Response::class, $apiClient->getLastResponse());
    }
}
