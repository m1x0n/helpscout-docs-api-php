<?php

declare(strict_types=1);

namespace HelpScoutDocs\Api;

use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;

class Redirect extends AbstractApi
{
    public function all(string $siteId, int $page = 1): ResourceCollection
    {
        $params = ['page' => $page];

        return $this->getResourceCollection(
            sprintf("redirects/site/%s", $siteId),
            $this->getParams($params),
            Models\Redirect::class
        );
    }

    public function show(string $redirectId): Models\Redirect
    {
        /** @var Models\Redirect $item */
        $item = $this->getItem(
            sprintf("redirects/%s", $redirectId),
            array(),
            Models\Redirect::class
        );

        return $item;
    }

    public function find(string $url, string $siteId): Models\RedirectedUrl
    {
        $params = ['url' => $url, 'siteId' => $siteId];

        /** @var Models\RedirectedUrl $item */
        $item = $this->getItem(
            "redirects",
            $this->getParams($params),
            Models\RedirectedUrl::class
        );

        return $item;
    }

    public function createRedirect(Models\Redirect $redirect): void
    {
        $requestBody = $redirect->toArray();

        $this->post("redirects", $requestBody);
    }

    public function createRedirectAndReturnCreated(Models\Redirect $redirect): Models\Redirect
    {
        $requestBody = $redirect->toArray();
        $requestBody['reload'] = true;

        [$id, $response] = $this->post("redirects", $requestBody);

        $redirectData = (array)$response;
        $redirectData = reset($redirectData);

        return new Models\Redirect($redirectData);
    }

    public function updateRedirect(Models\Redirect $redirect): void
    {
        $url = sprintf("redirect/%s", $redirect->getId());

        $requestBody = $redirect->toArray();

        $this->put($url, $requestBody);
    }

    public function updateRedirectAndReturnUpdated(Models\Redirect $redirect): Models\Redirect
    {
        $url = sprintf("redirect/%s", $redirect->getId());

        $requestBody = $redirect->toArray();
        $requestBody['reload'] = true;

        $response = $this->put($url, $requestBody);

        $redirectData = (array)$response;
        $redirectData = reset($redirectData);
        return new Models\Redirect($redirectData);
    }

    public function remove(string $redirectId): void
    {
        $this->delete(sprintf("redirects/%s", $redirectId));
    }
}
