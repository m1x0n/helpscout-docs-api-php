<?php
declare(strict_types=1);

namespace HelpScoutDocs\Tests;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\DocsApiClient;

class DocsApiClientTest extends TestCase
{
    private DocsApiClient $apiClient;

    public function setUp(): void
    {
        parent::setUp();
        $this->apiClient = new DocsApiClient('');
    }

    public function test_should_throw_an_exception_if_no_api_key_provided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage("Invalid API Key");

        $this->apiClient->getSites();
    }
}
