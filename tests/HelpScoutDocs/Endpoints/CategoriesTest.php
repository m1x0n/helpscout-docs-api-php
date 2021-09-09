<?php
declare(strict_types=1);

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models\Category;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class CategoriesTest extends TestCase
{
    public function test_should_return_categories_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/categories/categories.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $categories = $apiClient->getCategories(uniqid('', true));

        $this->assertInstanceOf(ResourceCollection::class, $categories);
    }

    public function test_should_return_category_by_id_or_number(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/categories/category.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $category = $apiClient->getCategory(uniqid('', true));

        $this->assertInstanceOf(Category::class, $category);
    }

    public function test_should_throw_an_exception_if_non_existing_id_or_number_provided(): void
    {
        $this->expectException(ApiException::class);

        $responseMock = $this->createResponseMock(404);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getCategory(uniqid('', true));
    }

    public function test_should_create_category_and_respond_with_new_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/categories/category.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $category->setCollectionId(uniqid('', true));
        $category->setName(uniqid("Category name ", true));

        $created = $apiClient->createCategoryAndReturnCreated($category);

        $this->assertInstanceOf(Category::class, $created);
    }

    public function test_should_create_category(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $category->setCollectionId(uniqid('', true));
        $category->setName(uniqid("Category name ", true));

        $apiClient->createCategory($category);
    }

    public function test_should_throw_an_exception_if_malformed_category_provided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        $responseMock = $this->createResponseMock(400);
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $apiClient->createCategory($category, true);
    }

    public function test_should_update_category_and_respond_with_new_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/categories/category.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $category->setCollectionId(uniqid('', true));
        $category->setId(uniqid('', true));
        $category->setName(uniqid("New Category name ", true));

        $updated = $apiClient->updateCategoryAndReturnUpdated($category);

        $this->assertInstanceOf(Category::class, $updated);
    }

    public function test_should_update_category_and_respond_without_new_instance(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $category = new Category();
        $category->setCollectionId(uniqid('', true));
        $category->setId(uniqid('', true));
        $category->setName(uniqid("New Category name ", true));

        $updated = $apiClient->updateCategoryAndReturnUpdated($category);

        $this->assertInstanceOf(Category::class, $updated);
    }

    public function test_should_delete_category(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteCategory(uniqid());
    }

    public function test_should_reorder_categories(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->updateCategoryOrder(uniqid('', true), [
            'categories' => [
                ['id' => uniqid('', true), 'order' => 1],
                ['id' => uniqid('', true), 'order' => 2],
                ['id' => uniqid('', true), 'order' => 3],
            ]
        ]);
    }
}
