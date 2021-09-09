<?php

declare(strict_types=1);

namespace HelpScoutDocs\Api;

use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;

class Collection extends AbstractApi
{
    public function all(
        int $page = 1,
        string $siteId = '',
        string $visibility = 'all',
        string $sort = 'order',
        string $order = 'asc'
    ): ResourceCollection {
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

    public function show(string $collectionIdOrNumber): Models\Collection
    {
        return $this->getItem(
            sprintf("collections/%s", $collectionIdOrNumber),
            array(),
            Models\Collection::class
        );
    }

    public function createCollection(Models\Collection $collection): void
    {
        $requestBody = $collection->toArray();

        $this->post("collections", $requestBody);
    }

    public function createCollectionAndReturnCreated(Models\Collection $collection): Models\Collection
    {
        $requestBody = $collection->toArray();
        $requestBody['reload'] = true;

        [$id, $response] = $this->post("collections", $requestBody);

        $collectionData = (array)$response;
        $collectionData = reset($collectionData);
        return new Models\Collection($collectionData);
    }

    public function updateCollection(Models\Collection $collection, bool $reload = false): void
    {
        $url = sprintf("collections/%s", $collection->getId());

        $requestBody = $collection->toArray();

        $this->put($url, $requestBody);
    }

    public function updateCollectionAndReturnUpdated(Models\Collection $collection): Models\Collection
    {
        $url = sprintf("collections/%s", $collection->getId());

        $requestBody = $collection->toArray();

        $requestBody['reload'] = true;

        $response = $this->put($url, $requestBody);

        $collectionData = (array)$response;
        $collectionData = reset($collectionData);
        return new Models\Collection($collectionData);
        ;
    }

    public function remove(string $collectionId): void
    {
        $this->delete(sprintf("collections/%s", $collectionId));
    }
}
