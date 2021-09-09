<?php

declare(strict_types=1);

namespace HelpScoutDocs\Api;

use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;

class Site extends AbstractApi
{
    public function all(int $page = 1): ResourceCollection
    {
        $params = ['page' => $page];

        return $this->getResourceCollection(
            "sites",
            $this->getParams($params),
            Models\Site::class
        );
    }

    public function show(int $siteId): Models\Site
    {
        /** @var Models\Site $item */
        $item = $this->getItem(
            sprintf("sites/%d", $siteId),
            array(),
            Models\Site::class
        );

        return $item;
    }

    public function createSite(Models\Site $site): void
    {
        $requestBody = $site->toArray();

        $this->post("sites", $requestBody);
    }

    public function createSiteAndReturnCreated(Models\Site $site): Models\Site
    {
        $requestBody = $site->toArray();
        $requestBody['reload'] = true;

        [$id, $response] = $this->post("sites", $requestBody);

        $siteData = (array)$response;
        $siteData = reset($siteData);

        return new Models\Site($siteData);
    }

    public function updateSite(Models\Site $site): void
    {
        $url = sprintf("sites/%d", $site->getId());

        $requestBody = $site->toArray();

        $this->put($url, $requestBody);
    }

    public function updateSiteAndReturnUpdated(Models\Site $site): Models\Site
    {
        $url = sprintf("sites/%d", $site->getId());

        $requestBody = $site->toArray();
        $requestBody['reload'] = true;

        $response = $this->put($url, $requestBody);

        $siteData = (array)$response;
        $siteData = reset($siteData);

        return new Models\Site($siteData);
    }

    public function remove(int $siteId): void
    {
        $this->delete(sprintf("sites/%d", $siteId));
    }
}
