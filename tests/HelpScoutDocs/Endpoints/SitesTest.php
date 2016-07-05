<?php

namespace HelpScoutDocs\Tests\Endpoints;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class SitesTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_sites_collection()
    {
        $responseMock = $this->prepareResponseMockForGetSites();
        $apiClient = $this->createTestApiClient($responseMock);

        $sites = $apiClient->getSites();

        $this->assertInstanceOf(ResourceCollection::class, $sites);
    }

    private function prepareResponseMockForGetSites()
    {
        $body = file_get_contents(__DIR__ . '/../../fixtures/sites/sites.json');
        
        $mock = new MockHandler([
            new Response(200, [], $body)
        ]);

        return $mock;
    }
}