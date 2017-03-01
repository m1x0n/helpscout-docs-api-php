<?php

namespace HelpScoutDocs\Api;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;

class Collection extends AbstractApi
{
    /**
     * @param int $page
     * @param string $siteId
     * @param string $visibility
     * @param string $sort
     * @param string $order
     * @return bool|ResourceCollection
     */
    public function all($page = 1, $siteId = '', $visibility = 'all', $sort = 'order', $order = 'asc')
    {
        $params = [
            'page'       => $page,
            'siteId'     => $siteId,
            'visibility' => $visibility,
            'sort'       => $sort,
            'order'      => $order
        ];

        return $this->getResourceCollection(
            "collections",
            $this->getParams($params),
            Models\Collection::class
        );
    }

    /**
     * @param $collectionIdOrNumber
     * @return bool|Models\Collection
     */
    public function show($collectionIdOrNumber)
    {
        return $this->getItem(
            sprintf("collections/%s", $collectionIdOrNumber),
            array(),
            Models\Collection::class
        );
    }

    /**
     * @param Models\Collection $collection
     * @param bool $reload
     * @return bool|Models\Collection
     * @throws ApiException
     */
    public function create(Models\Collection $collection, $reload = false)
    {
        $url = "collections";

        $requestBody = $collection->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        list($id, $response) = $this->post($url, $requestBody);

        if ($reload) {
            $collectionData = (array)$response;
            $collectionData = reset($collectionData);
            return new Models\Collection($collectionData);
        } else {
            $collection->setId($id);
            return $collection;
        }
    }

    /**
     * @param Models\Collection $collection
     * @param bool $reload
     * @return Models\Collection
     * @throws ApiException
     */
    public function update(Models\Collection $collection, $reload = false)
    {
        $url = sprintf("collections/%s", $collection->getId());

        $requestBody = $collection->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        $response = $this->put($url, $requestBody);

        if ($reload) {
            $collectionData = (array)$response;
            $collectionData = reset($collectionData);
            return new Models\Collection($collectionData);
        } else {
            return $collection;
        }
    }

    /**
     * @param $collectionId
     */
    public function remove($collectionId)
    {
        $this->delete(sprintf("collections/%s", $collectionId));
    }
}
