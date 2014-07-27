<?php

namespace HelpScoutDocs;

require_once 'ClassLoader.php';

/**
 * Class DocsApiClient
 *
 * This class is mostly replicated from ApiClient
 * https://github.com/helpscout/helpscout-api-php
 *
 * @package HelpScoutDocs
 */
final class DocsApiClient {
    const USER_AGENT = 'Help Scout API/Php Client v1';
    const API_URL = 'https://docsapi.helpscout.net/v1/';
    const NAMESPACE_SEPARATOR = '\\';

    private $userAgent = false;
    private $apiKey    = false;
    private $isDebug   = false;
    private $debugDir  = false;

    /**
     * @var \HelpScoutDocs\DocsApiClient
     */
    private static $instance = false;

    private function __construct() {
        ClassLoader::register();
    }

    /**
     * Get an instance of the DocsApiClient
     *
     * @return \HelpScoutDocs\DocsApiClient
     * @static
     */
    public static function getInstance() {
        if (self::$instance === false) {
            self::$instance = new DocsApiClient();
        }
        return self::$instance;
    }

    /**
     * Put ApiClient in debug mode or note.
     *
     * If in debug mode, you can optionally supply a directory
     * in which to write debug messages.
     * If no directory is set, debug messages are echo'ed out.
     *
     * @param  boolean        $bool
     * @param  boolean|string $dir
     * @return void
     */
    public function setDebug($bool, $dir=false) {
        $this->isDebug = $bool;
        if ($dir && is_dir($dir)) {
            $this->debugDir = $dir;
        }
    }

    /**
     * Set the API Key to use with this request
     *
     * @param string $apiKey
     */
    public function setKey($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function setUserAgent($userAgent) {
        $userAgent = trim($userAgent);
        if (!empty($userAgent)) {
            $this->userAgent = $userAgent;
        }
    }

    private function getUserAgent() {
        if ($this->userAgent) {
            return $this->userAgent;
        }
        return self::USER_AGENT;
    }

    /**
     * @param  string $url
     * @param  array  $params
     * @param  string $method
     * @param  string $model
     * @return \HelpScoutDocs\Collection|boolean
     */
    private function getCollection($url, $params, $method, $model) {
        list($statusCode, $json) = $this->callServer($url, 'GET', $params);

        $this->checkStatus($statusCode, $method);

        $json = reset(json_decode($json));
        if ($json) {
            if (isset($params['fields'])) {
                return $json;
            } else {
                return new Collection($json, $model);
            }
        }
        return false;
    }

    /**
     * @param  string $url
     * @param  array $params
     * @param  string $method
     * @param  string $model
     * @return bool $model|boolean
     */
    private function getItem($url, $params, $method, $model) {
        list($statusCode, $json) = $this->callServer($url, 'GET', $params);
        $this->checkStatus($statusCode, $method);

        $json = reset(json_decode($json));
        if ($json) {
            if (isset($params['fields']) || !$model) {
                return $json;
            } else {
                return new $model($json);
            }
        }
        return false;
    }

    /**
     * @param  integer $statusCode The HTTP status code returned
     * @param  string  $type       The type of request (e.g., GET, POST, etc.)
     * @param  integer $expected   The expected HTTP status code
     * @return void
     * @throws \HelpScoutDocs\ApiException If the expected $statusCode isn't returned
     */
    private function checkStatus($statusCode, $type, $expected = 200) {
        if (!is_array($expected)) {
            $expected = array($expected);
        }

        if (!in_array($statusCode, $expected)) {
            switch($statusCode) {
                case 400:
                    throw new ApiException('The request was not formatted correctly', 400);
                    break;
                case 401:
                    throw new ApiException('Invalid API key', 401);
                    break;
                case 402:
                    throw new ApiException('API key suspended', 402);
                    break;
                case 403:
                    throw new ApiException('Access denied', 403);
                    break;
                case 404:
                    throw new ApiException(sprintf('Resource not found [%s]', $type), 404);
                    break;
                case 405:
                    throw new ApiException('Invalid method type', 405);
                    break;
                case 429:
                    throw new ApiException('Throttle limit reached. Too many requests', 429);
                    break;
                case 500:
                    throw new ApiException('Application error or server error', 500);
                    break;
                case 503:
                    throw new ApiException('Service Temporarily Unavailable', 503);
                    break;
                default:
                    throw new ApiException(sprintf('Method %s returned status code %d but we expected code(s) %s', $type, $statusCode, implode(',', $expected)));
                    break;
            }
        }
    }

    /**
     * @param  array  $params
     * @param  array  $accepted
     * @return null|array
     */
    private function getParams($params=null, array $accepted=array('page', 'sort', 'order', 'status', 'query')) {
        if (!$params) {
            return null;
        }
        foreach($params as $key => $val) {
            $key = trim($key);
            if (!in_array($key, $accepted) || empty($params[$key])) {
                unset($params[$key]);
                continue;
            }
            switch($key) {
                case 'fields':
                    $val = $this->validateFieldSelectors($val);
                    if (empty($val)) {
                        unset($params[$key]);
                    } else {
                        $params[$key] = $val;
                    }
                    break;
                case 'page':
                    $val = intval($val);
                    if ($val < 1) {
                        unset($params[$key]);
                    }
                    break;
                case 'sort':
                    $params[$key] = $val;
                    break;
                case 'order':
                    $params[$key] = $val;
                    break;
                case 'visibility':
                    $params[$key] = $val;
                    break;
                case 'status':
                    $params[$key] = $val;
                    break;
            }
        }
        if ($params) {
            return $params;
        }
        return null;
    }

    /**
     * @param array $params
     * @return array
     */
    private function prepareParams(array $params) {
        foreach($params as $key => $value) {
            if (empty($value)) {
                unset($params[$key]);
            }
        }

        return $params;
    }

    /**
     * @param  string|array $fields
     * @return string
     */
    private function validateFieldSelectors($fields) {
        if (is_string($fields)) {
            $fields = explode(',', $fields);
        }
        if (is_array($fields) && count($fields) > 0) {
            array_walk($fields, create_function('&$val', '$val = trim($val);'));

            $fields = array_filter($fields);
        }

        if ($fields) {
            return implode(',', $fields);
        }
        return $fields;
    }

    /**
     * @param  string   $url
     * @param  boolean  $requestBody
     * @param  integer  $expectedCode
     * @return array
     * @throws \HelpScoutDocs\ApiException If no API key is provided
     */
    private function doPost($url, $requestBody=false, $expectedCode) {
        if ($this->apiKey === false || empty($this->apiKey)) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->isDebug) {
            $this->debug($requestBody);
        }

        $httpHeaders = array();
        if ($requestBody !== false) {
            $httpHeaders[] = 'Accept: application/json';
            $httpHeaders[] = 'Content-Type: application/json';
            $httpHeaders[] = 'Content-Length: ' . strlen($requestBody);
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
                CURLOPT_URL            => self::API_URL . $url,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_HTTPHEADER     => $httpHeaders,
                CURLOPT_POSTFIELDS     => $requestBody,
                CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
                CURLOPT_USERPWD        => $this->apiKey . ':X',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_FAILONERROR    => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_HEADER         => true,
                CURLOPT_ENCODING       => 'gzip,deflate',
                CURLOPT_USERAGENT      => $this->getUserAgent()
            ));

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $this->checkStatus($info['http_code'], 'POST', $expectedCode);

        return array($this->getIdFromLocation($response, $info['header_size']), substr($response, $info['header_size']));
    }

    private function doPostFile($url, array $requestBody, $expectedCode) {
        if ($this->apiKey === false || empty($this->apiKey)) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->isDebug) {
            $this->debug(json_encode($requestBody));
        }

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => self::API_URL . $url,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $requestBody,
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $this->checkStatus($info['http_code'], 'POST', $expectedCode);

        return $response;
    }

    /**
     * @param  string  $response
     * @param  integer $headerSize
     * @return boolean|string
     */
    private function getIdFromLocation($response, $headerSize) {
        $location = false;
        $headerText = substr($response, 0, $headerSize);
        $headerLines = explode("\r\n", $headerText);

        foreach($headerLines as $line) {
            $parts = explode(': ',$line);
            if (strtolower($parts[0]) == 'location') {
                $location = chop($parts[1]);
                break;
            }
        }

        $id = false;
        if ($location) {
            $start = strrpos($location, '/') + 1;
            $id = substr($location, $start, strlen($location));
        }
        return $id;
    }

    /**
     * @param  string $url
     * @param  string $requestBody
     * @param  integer $expectedCode
     * @throws ApiException
     * @return void
     */
    private function doPut($url, $requestBody, $expectedCode) {
        if ($this->apiKey === false || empty($this->apiKey)) {
            throw new ApiException('Invalid API Key', 401);
        }
        if ($this->isDebug) {
            $this->debug($requestBody);
        }

        $ch = curl_init();

        curl_setopt_array($ch, array(
                CURLOPT_URL            => self::API_URL . $url,
                CURLOPT_CUSTOMREQUEST  => 'PUT',
                CURLOPT_HTTPHEADER     => array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($requestBody)
                ),
                CURLOPT_POSTFIELDS     => $requestBody,
                CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
                CURLOPT_USERPWD        => $this->apiKey . ':X',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_FAILONERROR    => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_HEADER         => true,
                CURLOPT_ENCODING       => 'gzip,deflate',
                CURLOPT_USERAGENT      => $this->getUserAgent()
            ));

        /** @noinspection PhpUnusedLocalVariableInspection */
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $this->checkStatus($info['http_code'], 'PUT', $expectedCode);
    }

    /**
     * @param  string $url [description]
     * @param  integer $expectedCode [description]
     * @throws ApiException
     * @return void
     */
    private function doDelete($url, $expectedCode) {
        if ($this->apiKey === false || empty($this->apiKey)) {
            throw new ApiException('Invalid API Key', 401);
        }

        if ($this->isDebug) {
            $this->debug($url);
        }
        $ch = curl_init();

        curl_setopt_array($ch, array(
                CURLOPT_URL            => self::API_URL . $url,
                CURLOPT_CUSTOMREQUEST  => 'DELETE',
                CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
                CURLOPT_USERPWD        => $this->apiKey . ':X',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_FAILONERROR    => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_HEADER         => true,
                CURLOPT_ENCODING       => 'gzip,deflate',
                CURLOPT_USERAGENT      => $this->getUserAgent()
            ));

        /** @noinspection PhpUnusedLocalVariableInspection */
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $this->checkStatus($info['http_code'], 'DELETE', $expectedCode);
    }

    /**
     * @param  string $url
     * @param  string $method
     * @param  array $params
     * @throws ApiException
     * @return array
     */
    private function callServer($url, $method='GET', $params=null) {
        if ($this->apiKey === false || empty($this->apiKey)) {
            throw new ApiException('Invalid API Key', 401);
        }

        $ch = curl_init();
        $opts = array(
            CURLOPT_URL            => self::API_URL . $url,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_USERPWD        => $this->apiKey . ':X',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_HEADER         => false,
            CURLOPT_ENCODING       => 'gzip,deflate',
            CURLOPT_USERAGENT      => $this->getUserAgent()
        );
        if ($params) {
            if ($method=='GET') {
                $opts[CURLOPT_URL] = self::API_URL . $url . '?' . http_build_query($params);
            } else {
                $opts[CURLOPT_POSTFIELDS] = $params;
            }
        }
        curl_setopt_array($ch, $opts);

        $response   = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return array($statusCode, $response);
    }

    /**
     * @param  string $mesg
     * @return void
     */
    private function debug($mesg) {
        $text = strftime('%b %d %H:%M:%S') . ': ' . $mesg . PHP_EOL;

        if ($this->debugDir) {
            file_put_contents($this->debugDir . DIRECTORY_SEPARATOR . 'apiclient.log', $text, FILE_APPEND);
        } else {
            echo $text;
        }
    }

    /**
     * @param int $page
     * @param string $siteId
     * @param string $visibility
     * @param string $sort
     * @param string $order
     * @return bool|Collection
     */
    public function getCollections($page = 1, $siteId = '', $visibility = 'all', $sort = 'order', $order = 'asc') {
        $params = array(
            'page'       => $page,
            'siteId'     => $siteId,
            'visibility' => $visibility,
            'sort'       => $sort,
            'order'      => $order
        );

        return $this->getCollection(
            "collections",
            $this->getParams($params),
            'getCategories',
            '\HelpScoutDocs\model\Collection'
        );
    }

    /**
     * @param $collectionId
     * @param int $page
     * @param string $sort
     * @param string $order
     * @return bool|Collection
     */
    public function getCategories($collectionId, $page = 1, $sort = 'order', $order = 'asc') {
        $params = array(
            'page'  => $page,
            'sort'  => $sort,
            'order' => $order
        );

        return $this->getCollection(
            sprintf("collections/%s/categories", $collectionId),
            $this->getParams($params),
            'getCategories',
            '\HelpScoutDocs\model\Category'
        );
    }

    /**
     * @param $categoryId
     * @param int $page
     * @param string $status
     * @param string $sort
     * @param string $order
     * @return bool|Collection
     */
    public function getArticles($categoryId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc') {
        $params = array(
            'page'   => $page,
            'status' => $status,
            'sort'   => $sort,
            'order'  => $order
        );

        return $this->getCollection(
            sprintf("categories/%s/articles", $categoryId),
            $this->getParams($params),
            'getCategories',
            '\HelpScoutDocs\model\ArticleRef'
        );
    }

    /**
     * @param int $page
     * @return bool|Collection
     */
    public function getSites($page = 1) {
        $params = array('page' => $page);

        return $this->getCollection(
            "sites",
            $this->getParams($params),
            'getSites',
            '\HelpScoutDocs\model\Site'
        );
    }

    /**
     * @param $siteId
     * @return bool
     */
    public function getSite($siteId) {
        return $this->getItem(
            sprintf("sites/%s", $siteId),
            array(),
            'getSite',
            '\HelpScoutDocs\model\Site'
        );
    }

    /**
     * @param string $query
     * @param int $page
     * @param string $collectionId
     * @param string $status
     * @param string $visibility
     * @return bool|Collection
     */
    public function searchArticles($query = '*', $page = 1, $collectionId = '', $status = 'all', $visibility = 'all') {
        $params = array(
            'query'        => $query,
            'page'         => $page,
            'collectionId' => $collectionId,
            'status'       => $status,
            'visibility'   => $visibility
        );

        return $this->getCollection(
            "search/articles",
            $this->getParams($params),
            'searchArticles',
            '\HelpScoutDocs\model\ArticleSearch'
        );
    }

    /**
     * @param $articleId
     * @param int $page
     * @param string $status
     * @param string $sort
     * @param string $order
     * @return bool|Collection
     */
    public function getRelatedArticles($articleId, $page = 1, $status = 'all', $sort = 'order', $order = 'desc') {
        $params = array(
            'page'   => $page,
            'status' => $status,
            'sort'   => $sort,
            'order'  => $order
        );

        return $this->getCollection(
            sprintf("articles/%s/related", $articleId),
            $this->getParams($params),
            "getRelatedArticles",
            '\HelpScoutDocs\model\ArticleRef'
        );
    }

    /**
     * @param $articleId
     * @param int $page
     * @return bool|Collection
     */
    public function getRevisions($articleId, $page = 1) {
        $params = array('page' => $page);

        return $this->getCollection(
            sprintf("articles/%s/revisions", $articleId),
            $this->getParams($params),
            "getRevisions",
            '\HelpScoutDocs\model\ArticleRevisionRef'
        );
    }

    /**
     * @param $articleIdOrNumber
     * @param bool $draft
     * @return bool
     */
    public function getArticle($articleIdOrNumber, $draft = false) {
        $params = array('draft' => $draft);

        return $this->getItem(
            sprintf("articles/%s", $articleIdOrNumber),
            $this->getParams($params),
            "getArticle",
            '\HelpScoutDocs\model\Article'
        );
    }

    /**
     * @param $revisionId
     * @return bool
     */
    public function getRevision($revisionId) {
        return $this->getItem(
            sprintf("revisions/%s", $revisionId),
            array(),
            "getRevision",
            'HelpScoutDocs\model\ArticleRevision'
        );
    }

    /**
     * @param model\Article $article
     * @param bool $reload
     * @return bool|model\Article
     */
    public function createArticle(model\Article $article, $reload = false) {
        $url = "articles";

        if ($reload) {
            $url .= "?reload=true";
        }

        list($id, ) = $this->doPost($url, $article->toJson(), 200);
        $article->setId($id);

        return $reload ? $article : true;
    }

    /**
     * @param model\Article $article
     * @param bool $reload
     */
    public function updateArticle(model\Article $article, $reload = false) {
        $url = sprintf("articles/%s", $article->getId());

        if ($reload) {
            $url .= "?reload=true";
        }

        $this->doPut($url, $article->toJson(), 200);
    }

    /**
     * @param $collectionId
     * @param $file
     * @param null $categoryId
     * @param null $name
     * @param null $slug
     * @param null $type
     * @param bool $reload
     * @return bool|model\Article
     * @throws ApiException
     */
    public function uploadArticle($collectionId, $file, $categoryId = null, $name = null, $slug = null,
        $type = null, $reload = false) {

        if (!file_exists($file)) {
            throw new ApiException("Unable to locate file: %s", $file);
        }

        $params = array(
            'key'          => $this->apiKey,
            'collectionId' => $collectionId,
            'file'         => '@' . $file,
            'name'         => empty($name) ? pathinfo($file, PATHINFO_FILENAME) : $name,
            'categoryId'   => $categoryId,
            'slug'         => $slug,
            'type'         => $type,
            'reload'       => $reload
        );

        $response = $this->doPostFile("articles/upload", $this->prepareParams($params), $reload ? 200 : 201);

        return $reload ? new model\Article(reset(json_decode($response))) : true;
    }

    /**
     * @param $articleId
     * @param int $count
     */
    public function updateViewCount($articleId, $count = 1) {
        $this->doPut(sprintf("articles/%s/views", $articleId), json_encode(array('count' => $count)), 200);
    }

    /**
     * @param $articleId
     */
    public function deleteArticle($articleId) {
        $this->doDelete(sprintf("articles/%s", $articleId), 200);
    }

    /**
     * @param $articleId
     * @param $text
     */
    public function saveArticleDraft($articleId, $text) {
        $this->doPut(sprintf("articles/%s/drafts", $articleId), json_encode(array('text' => $text)), 200);
    }

    /**
     * @param $articleId
     */
    public function deleteArticleDraft($articleId) {
        $this->doDelete(sprintf("articles/%s/drafts", $articleId), 200);
    }
}