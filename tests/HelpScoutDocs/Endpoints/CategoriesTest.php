<?php

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class CategoriesTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_categories_collection()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/categories/categories.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $categories = $apiClient->getCategories(uniqid());

        $this->assertInstanceOf(ResourceCollection::class, $categories);
    }
}