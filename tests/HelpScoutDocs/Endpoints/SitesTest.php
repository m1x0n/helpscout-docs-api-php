<?php

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class SitesTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_sites_collection()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/sites/sites.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $sites = $apiClient->getSites();

        $this->assertInstanceOf(ResourceCollection::class, $sites);
    }
}