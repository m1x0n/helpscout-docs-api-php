<?php

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\Models\Collection;
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

    /**
     * @test
     */
    public function should_return_collection_by_given_exiting_id_or_number()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/collections/collection.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = $apiClient->getCollection(uniqid());

        $this->assertInstanceOf(Collection::class, $collection);
    }

    /**
     * @test
     * @expectedException \HelpScoutDocs\ApiException
     */
    public function should_throw_an_exception_for_non_existing_id_or_number()
    {
        $responseMock = $this->createResponseMock(404, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getCollection(uniqid());
    }

    /**
     * @test
     */
    public function should_create_collection_and_respond_with_entity()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/collections/collection.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();
        $collection->setSiteId(uniqid());
        $collection->setName(uniqid("Test collection "));
        $collection->setVisibility(Collection::COLLECTION_VISIBILITY_PUBLIC);

        $created = $apiClient->createCollection($collection, true);

        $this->assertInstanceOf(Collection::class, $created);
    }

    /**
     * @test
     */
    public function should_create_collection_and_assign_id()
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();
        $collection->setSiteId(uniqid());
        $collection->setName(uniqid("Test collection "));
        $collection->setVisibility(Collection::COLLECTION_VISIBILITY_PUBLIC);

        $created = $apiClient->createCollection($collection, false);

        $this->assertInstanceOf(Collection::class, $created);
        $this->assertNotEmpty($created->getId());
    }

    /**
     * @test
     */
    public function should_update_collection_and_respond_with_entity()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/collections/collection.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();
        $collection->setName(uniqid("Updated collection "));

        $updated = $apiClient->updateCollection($collection, true);

        $this->assertInstanceOf(Collection::class, $updated);
    }

    /**
     * @test
     */
    public function should_update_collection_and_respond_without_entity()
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();
        $collection->setName(uniqid("Updated collection "));

        $updated = $apiClient->updateCollection($collection, false);

        $this->assertInstanceOf(Collection::class, $updated);
        $this->assertSame($collection, $updated);
    }

    /**
     * @test
     */
    public function should_delete_collection()
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteCollection(uniqid());
    }

    /**
     * @test
     * @expectedException \HelpScoutDocs\ApiException
     * @expectedExceptionCode 400
     */
    public function should_throw_an_exception_on_malformed_collection_create_attempt()
    {
        $responseMock = $this->createResponseMock(400, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();

        $apiClient->createCollection($collection);
    }
}