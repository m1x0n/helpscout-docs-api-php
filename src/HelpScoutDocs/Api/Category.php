<?php

declare(strict_types=1);

namespace HelpScoutDocs\Api;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;

class Category extends AbstractApi
{
    public function all(
        string $collectionId,
        int $page = 1,
        string $sort = 'order',
        string $order = 'asc'
    ): ResourceCollection {
        $params = [
            'page'  => $page,
            'sort'  => $sort,
            'order' => $order
        ];

        return $this->getResourceCollection(
            sprintf("collections/%s/categories", $collectionId),
            $this->getParams($params),
            Models\Category::class
        );
    }

    public function show(string $categoryIdOrNumber): Models\Category
    {
        /** @var Models\Category $item */
        $item = $this->getItem(
            sprintf("categories/%s", $categoryIdOrNumber),
            array(),
            Models\Category::class
        );

        return $item;
    }

    public function createCategory(Models\Category $category): void
    {
        $requestBody = $category->toArray();

        $this->post("categories", $requestBody);
    }

    public function createCategoryAndReturnCreated(Models\Category $category): Models\Category
    {
        $requestBody = $category->toArray();

        $requestBody['reload'] = true;

        [$id, $response] = $this->post("categories", $requestBody);

        $categoryData = (array)$response;
        $categoryData = reset($categoryData);

        return new Models\Category($categoryData);
    }

    public function updateCategory(Models\Category $category): void
    {
        $url = sprintf("categories/%s", $category->getId());

        $requestBody = $category->toArray();

        $this->put($url, $requestBody);
    }

    public function updateCategoryAndReturnUpdated(Models\Category $category): Models\Category
    {
        $url = sprintf("categories/%s", $category->getId());

        $requestBody = $category->toArray();
        $requestBody['reload'] = true;

        $response = $this->put($url, $requestBody);

        $categoryData = (array)$response;
        $categoryData = reset($categoryData);

        return new Models\Category($categoryData);
    }

    /**
     * @param string $collectionId
     * @param array<string, array> $categories
     *
     * Categories should be an associative array:
     *
     * $categories = array(
     *      'categories' => array(
     *          array(
     *              'id'    => 'some-id-here',
     *              'order' => '1'
     *          ),
     *          array(
     *              'id'    => 'another-id-here',
     *              'order' => '2'
     *          )
     *          ...
     *      )
     * );
     *
     * @throws ApiException
     */
    public function updateOrder(string $collectionId, array $categories): void
    {
        $this->put(
            sprintf("collections/%s/categories", $collectionId),
            $categories
        );
    }

    public function remove(string $categoryId): void
    {
        $this->delete(sprintf("categories/%s", $categoryId));
    }
}
