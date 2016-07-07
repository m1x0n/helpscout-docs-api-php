<?php

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\Models\Category;
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

    /**
     * @test
     */
    public function should_return_category_by_id_or_number()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/categories/category.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $category = $apiClient->getCategory(uniqid());

        $this->assertInstanceOf(Category::class, $category);
    }

    /**
     * @test
     * @expectedException \HelpScoutDocs\ApiException
     */
    public function should_throw_an_exception_if_non_existing_id_or_number_provided()
    {
        $responseMock = $this->createResponseMock(404, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getCategory(uniqid());
    }

    /**
     * @test
     */
    public function should_create_category_and_respond_with_new_instance()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/categories/category.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $category->setCollectionId(uniqid());
        $category->setName(uniqid("Category name "));

        $created = $apiClient->createCategory($category, true);

        $this->assertInstanceOf(Category::class, $created);
    }

    /**
     * @test
     */
    public function should_create_category_and_assign_id()
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $category->setCollectionId(uniqid());
        $category->setName(uniqid("Category name "));

        $created = $apiClient->createCategory($category, false);

        $this->assertInstanceOf(Category::class, $created);
        $this->assertNotEmpty($created->getId());
    }

    /**
     * @test
     * @expectedException \HelpScoutDocs\ApiException
     * @expectedExceptionCode 400
     */
    public function should_throw_an_exception_if_malformed_category_provided()
    {
        $responseMock = $this->createResponseMock(400, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $apiClient->createCategory($category, true);
    }

    /**
     * @test
     */
    public function should_update_category_and_respond_with_new_instance()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/categories/category.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $category->setCollectionId(uniqid());
        $category->setId(uniqid());
        $category->setName(uniqid("New Category name "));

        $updated = $apiClient->updateCategory($category, true);

        $this->assertInstanceOf(Category::class, $updated);
    }

    /**
     * @test
     */
    public function should_update_category_and_respond_without_new_instance()
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $category->setCollectionId(uniqid());
        $category->setId(uniqid());
        $category->setName(uniqid("New Category name "));

        $updated = $apiClient->updateCategory($category, false);

        $this->assertInstanceOf(Category::class, $updated);
        $this->assertSame($updated, $category);
    }

    /**
     * @test
     */
    public function should_delete_category()
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteCategory(uniqid());
    }

    /**
     * @test
     */
    public function should_reorder_categories()
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);
        
        $apiClient->updateCategoryOrder(uniqid(), [
            'categories' => [
                ['id' => uniqid(), 'order' => 1 ],
                ['id' => uniqid(), 'order' => 2 ],
                ['id' => uniqid(), 'order' => 3 ],
            ]
        ]);
    }
}