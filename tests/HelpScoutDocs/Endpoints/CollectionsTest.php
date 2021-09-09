<?php
declare(strict_types=1);

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models\Collection;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class CollectionsTest extends TestCase
{
    public function test_should_return_collections_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/collections/collections.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $collections = $apiClient->getCollections();

        $this->assertInstanceOf(ResourceCollection::class, $collections);
    }

    public function test_should_return_collection_by_given_exiting_id_or_number(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/collections/collection.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = $apiClient->getCollection(uniqid('', true));

        $this->assertInstanceOf(Collection::class, $collection);
    }

    public function test_should_throw_an_exception_for_non_existing_id_or_number(): void
    {
        $this->expectException(ApiException::class);

        $responseMock = $this->createResponseMock(404);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getCollection(uniqid('', true));
    }

    public function test_should_create_collection_and_respond_with_entity(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/collections/collection.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();
        $collection->setSiteId(uniqid('', true));
        $collection->setName(uniqid("Test collection ", true));
        $collection->setVisibility(Collection::COLLECTION_VISIBILITY_PUBLIC);

        $created = $apiClient->createCollectionAndReturnCreated($collection);

        $this->assertInstanceOf(Collection::class, $created);
    }

    public function test_should_create_collection(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();
        $collection->setSiteId(uniqid('', true));
        $collection->setName(uniqid("Test collection ", true));
        $collection->setVisibility(Collection::COLLECTION_VISIBILITY_PUBLIC);

        $apiClient->createCollection($collection, false);
    }

    public function test_should_update_collection_and_respond_with_entity(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/collections/collection.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();
        $collection->setName(uniqid("Updated collection ", true));

        $updated = $apiClient->updateCollectionAndReturnUpdated($collection);

        $this->assertInstanceOf(Collection::class, $updated);
    }

    public function test_should_update_collection_and_respond_without_entity(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();
        $collection->setName(uniqid("Updated collection ", true));

        $apiClient->updateCollection($collection);
    }

    public function test_should_delete_collection(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteCollection(uniqid());
    }

    public function test_should_throw_an_exception_on_malformed_collection_create_attempt(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        $responseMock = $this->createResponseMock(400);
        $apiClient = $this->createTestApiClient($responseMock);

        $collection = new Collection();

        $apiClient->createCollection($collection);
    }
}
