<?php

namespace HelpScoutDocs\Api;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;

class Site extends AbstractApi
{
    /**
     * @param int $page
     * @return bool|ResourceCollection
     */
    public function all($page = 1)
    {
        $params = ['page' => $page];

        return $this->getResourceCollection(
            "sites",
            $this->getParams($params),
            Models\Site::class
        );
    }

    /**
     * @param $siteId
     * @return bool|mixed
     */
    public function show($siteId)
    {
        return $this->getItem(
            sprintf("sites/%s", $siteId),
            array(),
            Models\Site::class
        );
    }

    /**
     * @param Models\Site $site
     * @param bool $reload
     * @return bool|Models\Site
     * @throws ApiException
     */
    public function create(Models\Site $site, $reload = false)
    {
        $url = "sites";

        $requestBody = $site->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        list($id, $response) = $this->post($url, $requestBody);

        if ($reload) {
            $siteData = (array)$response;
            $siteData = reset($siteData);
            return new Models\Site($siteData);
        } else {
            $site->setId($id);
            return $site;
        }
    }

    /**
     * @param Models\Site $site
     * @param bool $reload
     * @return Models\Site
     * @throws ApiException
     */
    public function update(Models\Site $site, $reload = true)
    {
        $url = sprintf("sites/%s", $site->getId());

        $requestBody = $site->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        $response = $this->put($url, $requestBody);

        if ($reload) {
            $siteData = (array)$response;
            $siteData = reset($siteData);
            return new Models\Site($siteData);
        } else {
            return $site;
        }
    }

    /**
     * @param $siteId
     */
    public function remove($siteId)
    {
        $this->delete(sprintf("sites/%s", $siteId));
    }
}
