<?php

namespace HelpScoutDocs\Tests;

use HelpScoutDocs\DocsApiClient;

class DocsApiClientTest extends TestCase
{
    /**
     * @var DocsApiClient
     */
    private $apiClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiClient = new DocsApiClient();
    }

    /**
     * @test
     */
    public function should_throw_an_exception_if_no_api_key_provided(): void
    {
        $this->expectException(\HelpScoutDocs\ApiException::class);
        $this->expectExceptionMessage("Invalid API Key");

        $this->apiClient->getSites();
    }
}
