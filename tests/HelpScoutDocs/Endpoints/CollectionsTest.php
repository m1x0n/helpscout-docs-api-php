<?php

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class CollectionsTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_collections_collection()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/collections/collections.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $collections = $apiClient->getCollections();

        $this->assertInstanceOf(ResourceCollection::class, $collections);
    }
}