<?php

namespace HelpScoutDocs\Api;

use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;

class Redirect extends AbstractApi
{
    /**
     * @param $siteId
     * @param int $page
     * @return ResourceCollection|mixed
     */
    public function all($siteId, $page = 1)
    {
        $params = ['page' => $page];

        return $this->getResourceCollection(
            sprintf("redirects/site/%s", $siteId),
            $this->getParams($params),
            Models\Redirect::class
        );
    }

    /**
     * @param $redirectId
     * @return bool|Models\Redirect
     */
    public function show($redirectId)
    {
        return $this->getItem(
            sprintf("redirects/%s", $redirectId),
            array(),
            Models\Redirect::class
        );
    }

    /**
     * @param $url
     * @param $siteId
     * @return bool|Models\RedirectedUrl
     */
    public function find($url, $siteId)
    {
        $params = ['url' => $url, 'siteId' => $siteId];

        return $this->getItem(
            "redirects",
            $this->getParams($params),
            Models\RedirectedUrl::class
        );
    }

    /**
     * @param Models\Redirect $redirect
     * @param bool $reload
     * @return Models\Redirect
     */
    public function create(Models\Redirect $redirect, $reload = false)
    {
        $url = "redirects";

        $requestBody = $redirect->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        list($id, $response) = $this->post($url, $requestBody);

        if ($reload) {
            $redirectData = (array)$response;
            $redirectData = reset($redirectData);
            return new Models\Redirect($redirectData);
        } else {
            $redirect->setId($id);
            return $redirect;
        }
    }

    /**
     * @param Models\Redirect $redirect
     * @param bool $reload
     * @return Models\Redirect
     */
    public function update(Models\Redirect $redirect, $reload = false)
    {
        $url = sprintf("redirect/%s", $redirect->getId());

        $requestBody = $redirect->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        $response = $this->put($url, $requestBody);

        if ($reload) {
            $redirectData = (array)$response;
            $redirectData = reset($redirectData);
            return new Models\Redirect($redirectData);
        } else {
            return $redirect;
        }
    }

    /**
     * @param $redirectId
     */
    public function remove($redirectId)
    {
        $this->delete(sprintf("redirects/%s", $redirectId));
    }
}
