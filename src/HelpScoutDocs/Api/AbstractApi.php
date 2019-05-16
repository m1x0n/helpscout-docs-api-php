<?php

namespace HelpScoutDocs\Api;

use GuzzleHttp\Exception\RequestException;
use HelpScoutDocs\ApiException;
use HelpScoutDocs\DocsApiClient;
use HelpScoutDocs\ResourceCollection;

abstract class AbstractApi
{
    /**
     * @var DocsApiClient
     */
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param $url
     * @param array $params
     * @return string
     * @throws ApiException
     */
    protected function get($url, array $params)
    {
        if (!$this->client->getApiKey()) {
            throw new ApiException('Invalid API Key', 401);
        }

        try {
            $response = $this->client->getHttpClient()->request(
                'GET',
                DocsApiClient::API_URL . $url,
                [
                    'query' => $params,
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'User-Agent' => $this->client->getUserAgent()
                    ],
                    'auth' => [$this->client->getApiKey(), 'X']
                ]
            );
        } catch(RequestException $e) {
            throw $this->apiException($e);
        }

        $this->client->setLastResponse($response);

        return $response->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param array $requestBody
     * @return array
     * @throws ApiException
     */
    protected function post($url, array $requestBody)
    {
        if (!$this->client->getApiKey()) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->client->isDebug()) {
            $this->debug(json_encode($requestBody));
        }

        try {
            $response = $this->client->getHttpClient()->request(
                'POST',
                DocsApiClient::API_URL . $url,
                [
                    'json' => $requestBody,
                    'auth' => [$this->client->getApiKey(), 'X'],
                    'headers' => [
                        'User-Agent' => $this->client->getUserAgent()
                    ]
                ]
            );
        } catch (RequestException $e) {
            throw $this->apiException($e);
        }

        $this->client->setLastResponse($response);

        $content = $response->getBody()->getContents();
        $location = $response->getHeaderLine('Location');

        return array(basename($location), json_decode($content));
    }

    /**
     * @param $url
     * @param array $requestBody
     * @return mixed
     * @throws ApiException
     */
    protected function put($url, array $requestBody)
    {
        if (!$this->client->getApiKey()) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->client->isDebug()) {
            $this->debug(json_encode($requestBody));
        }

        try {
            $response = $this->client->getHttpClient()->request(
                'PUT',
                DocsApiClient::API_URL . $url,
                [
                    'json' => $requestBody,
                    'auth' => [$this->client->getApiKey(), 'X'],
                    'headers' => [
                        'User-Agent' => $this->client->getUserAgent()
                    ]
                ]
            );
        } catch (RequestException $e) {
            throw $this->apiException($e);
        }

        $this->client->setLastResponse($response);
        $content = $response->getBody()->getContents();

        return json_decode($content);
    }

    /**
     * @param $url
     * @return bool
     * @throws ApiException
     */
    protected function delete($url)
    {
        if (!$this->client->getApiKey()) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->client->isDebug()) {
            $this->debug($url);
        }

        try {
            $response = $this->client->getHttpClient()->request(
                'DELETE',
                DocsApiClient::API_URL . $url,
                [
                    'auth' => [$this->client->getApiKey(), 'X'],
                    'headers' => [
                        'User-Agent' => $this->client->getUserAgent()
                    ]
                ]
            );
        } catch (RequestException $e) {
            throw $this->apiException($e);
        }

        $this->client->setLastResponse($response);

        return true;
    }

    /**
     * @param $url
     * @param array $multipart
     * @return mixed
     * @throws ApiException
     */
    protected function postMultipart($url, array $multipart)
    {
        if (!$this->client->getApiKey()) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->client->isDebug()) {
            $this->debug(json_encode($multipart));
        }

        try {
            $response = $this->client->getHttpClient()->request(
                'POST',
                DocsApiClient::API_URL . $url,
                [
                    'multipart' => $multipart,
                    'auth' => [$this->client->getApiKey(), 'X'],
                    'headers' => [
                        'User-Agent' => $this->client->getUserAgent()
                    ]
                ]
            );
        } catch(RequestException $e) {
            throw $this->apiException($e);
        }

        $this->client->setLastResponse($response);
        $content = $response->getBody()->getContents();

        return json_decode($content);
    }

    /**
     * @param array $params
     * @return array
     */
    protected function getParams(array $params = [])
    {
        //TODO: Move to const array after PHP 5.5 support drop
        $accepted = [
            'page',
            'sort',
            'order',
            'status',
            'query',
            'visibility',
            'collectionId',
            'pageSize'
        ];

        if (!$params) {
            return [];
        }
        foreach($params as $key => $val) {
            $key = trim($key);
            if (empty($params[$key]) || !in_array($key, $accepted, true)) {
                unset($params[$key]);
                continue;
            }
            switch($key) {
                case 'page':
                case 'pageSize':
                    $val = (int)$val;
                    if ($val < 1) {
                        unset($params[$key]);
                    }
                    break;
                case 'sort':
                case 'order':
                case 'visibility':
                case 'status':
                    $params[$key] = $val;
                    break;
            }
        }
        if ($params) {
            return $params;
        }
        return [];
    }

    /**
     * @param $url
     * @param $params
     * @param $modelClass
     * @return bool|mixed
     * @throws ApiException
     */
    protected function getItem($url, $params, $modelClass)
    {
        $response = $this->get($url, $params);

        $json = json_decode($response);
        $json = reset($json);

        return new $modelClass($json);
    }

    /**
     * @param string $url
     * @param array $params
     * @param string $modelClass
     * @return ResourceCollection|mixed
     * @throws ApiException
     */
    protected function getResourceCollection($url, $params, $modelClass)
    {
        $response = $this->get($url, $params);

        $json = json_decode($response);
        $json = reset($json);

        return new ResourceCollection($json, $modelClass);
    }

    /**
     * @param RequestException $e
     * @return ApiException
     */
    protected function apiException(RequestException $e)
    {
        $message = $e->hasResponse()
            ? $e->getResponse()->getBody()->getContents()
            : $e->getMessage();

        $code = $e->hasResponse()
            ? $e->getResponse()->getStatusCode()
            : null;

        return new ApiException($message, $code);
    }

    /**
     * @param $message
     */
    protected function debug($message)
    {
        $text = strftime('%b %d %H:%M:%S') . ': ' . $message . PHP_EOL;

        if ($this->client->getDebugDir()) {
            file_put_contents($this->client->getDebugDir() . DIRECTORY_SEPARATOR . 'apiclient.log', $text, FILE_APPEND);
        } else {
            echo $text;
        }
    }
}
