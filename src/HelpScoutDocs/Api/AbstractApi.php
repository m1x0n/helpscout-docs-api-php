<?php

declare(strict_types=1);

namespace HelpScoutDocs\Api;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use HelpScoutDocs\ApiException;
use HelpScoutDocs\DocsApiClient;
use HelpScoutDocs\Models\DocsModel;
use HelpScoutDocs\ResourceCollection;
use JsonException;
use stdClass;

abstract class AbstractApi
{
    protected DocsApiClient $client;

    public function __construct(DocsApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @param array<string, mixed> $params
     * @return string
     * @throws ApiException
     * @throws GuzzleException
     */
    protected function get(string $url, array $params): string
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
        } catch (RequestException $e) {
            throw $this->apiException($e);
        }

        $this->client->setLastResponse($response);

        return $response->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param array<string, mixed> $requestBody
     * @return array<int, mixed>
     * @throws ApiException
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function post(string $url, array $requestBody): array
    {
        if (!$this->client->getApiKey()) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->client->isDebug()) {
            $this->debug(json_encode($requestBody, JSON_THROW_ON_ERROR));
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

        return [
            basename($location),
            empty($content) ? null : json_decode($content, false, 512, JSON_THROW_ON_ERROR)
        ];
    }

    /**
     * @param string $url
     * @param array<string, mixed> $requestBody
     * @return stdClass|null
     * @throws ApiException
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function put(string $url, array $requestBody): ?stdClass
    {
        if (!$this->client->getApiKey()) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->client->isDebug()) {
            $this->debug(json_encode($requestBody, JSON_THROW_ON_ERROR));
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

        if (empty($content)) {
            return null;
        }

        return json_decode($content, false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param string $url
     * @return bool
     * @throws ApiException
     * @throws GuzzleException
     */
    protected function delete(string $url): bool
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
     * @param string $url
     * @param array<int, mixed> $multipart
     * @return stdClass|null
     * @throws ApiException
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function postMultipart(string $url, array $multipart): ?stdClass
    {
        if (!$this->client->getApiKey()) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->client->isDebug()) {
            $this->debug(json_encode($multipart, JSON_THROW_ON_ERROR));
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
        } catch (RequestException $e) {
            throw $this->apiException($e);
        }

        $this->client->setLastResponse($response);
        $content = $response->getBody()->getContents();

        if (empty($content)) {
            return null;
        }

        return json_decode($content, false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     */
    protected function getParams(array $params = []): array
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

        if ($params === []) {
            return [];
        }
        foreach ($params as $key => $val) {
            $key = trim($key);
            if (empty($params[$key]) || !in_array($key, $accepted, true)) {
                unset($params[$key]);
                continue;
            }
            switch ($key) {
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
        if ($params !== []) {
            return $params;
        }
        return [];
    }

    /**
     * @param string $url
     * @param array<string, mixed> $params
     * @param string $modelClass
     * @return DocsModel
     * @throws ApiException
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function getItem(string $url, array $params, string $modelClass): DocsModel
    {
        $response = $this->get($url, $params);

        $json = json_decode($response, false, 512, JSON_THROW_ON_ERROR);

        return new $modelClass($json);
    }

    /**
     * @param string $url
     * @param array<string, mixed> $params
     * @param string $modelClass
     * @return ResourceCollection
     * @throws ApiException
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function getResourceCollection(
        string $url,
        array $params,
        string $modelClass
    ): ResourceCollection {
        $response = $this->get($url, $params);

        $json = json_decode($response, false, 512, JSON_THROW_ON_ERROR);

        return new ResourceCollection($json, $modelClass);
    }

    protected function apiException(RequestException $e): ApiException
    {
        $message = $e->hasResponse()
            ? $e->getResponse()->getBody()->getContents()
            : $e->getMessage();

        $code = $e->hasResponse()
            ? $e->getResponse()->getStatusCode()
            : null;

        return new ApiException($message, $code);
    }

    protected function debug(string $message): void
    {
        $text = strftime('%b %d %H:%M:%S') . ': ' . $message . PHP_EOL;

        if ($this->client->getDebugDir()) {
            file_put_contents($this->client->getDebugDir() . DIRECTORY_SEPARATOR . 'apiclient.log', $text, FILE_APPEND);
        } else {
            echo $text;
        }
    }
}
