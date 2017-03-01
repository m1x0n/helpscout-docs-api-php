<?php

namespace HelpScoutDocs\Api;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;

class Category extends AbstractApi
{
    /**
     * @param $collectionId
     * @param int $page
     * @param string $sort
     * @param string $order
     * @return bool|ResourceCollection
     */
    public function all($collectionId, $page = 1, $sort = 'order', $order = 'asc')
    {
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

    /**
     * @param $categoryIdOrNumber
     * @return bool|Models\Category
     */
    public function show($categoryIdOrNumber)
    {
        return $this->getItem(
            sprintf("categories/%s", $categoryIdOrNumber),
            array(),
            Models\Category::class
        );
    }

    /**
     * @param Models\Category $category
     * @param bool $reload
     * @return bool|Models\Category
     * @throws ApiException
     */
    public function create(Models\Category $category, $reload = false)
    {
        $url = "categories";

        $requestBody = $category->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        list($id, $response) = $this->post($url, $requestBody);

        if ($reload) {
            $categoryData = (array)$response;
            $categoryData = reset($categoryData);
            return new Models\Category($categoryData);
        } else {
            $category->setId($id);
            return $category;
        }
    }

    /**
     * @param Models\Category $category
     * @param bool $reload
     * @return Models\Category
     * @throws ApiException
     */
    public function update(Models\Category $category, $reload = false)
    {
        $url = sprintf("categories/%s", $category->getId());

        $requestBody = $category->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        $response = $this->put($url, $requestBody);

        if ($reload) {
            $categoryData = (array)$response;
            $categoryData = reset($categoryData);
            return new Models\Category($categoryData);
        } else {
            return $category;
        }
    }

    /**
     * @param $collectionId
     * @param array $categories
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
    public function updateOrder($collectionId, array $categories)
    {
        $this->put(
            sprintf("collections/%s/categories", $collectionId),
            $categories
        );
    }

    /**
     * @param $categoryId
     */
    public function remove($categoryId)
    {
        $this->delete(sprintf("categories/%s", $categoryId));
    }
}
