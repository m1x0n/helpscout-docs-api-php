<?php

namespace HelpScoutDocs;

use BadMethodCallException;
use GuzzleHttp\Client;
use HelpScoutDocs\Api\Article;
use InvalidArgumentException;
use HelpScoutDocs\Models;

/**
 * Class DocsApiClient
 *
 * This class is partially replicated from ApiClient
 * https://github.com/helpscout/helpscout-api-php
 *
 * @package HelpScoutDocs
 *
 * @method Api\Article    articles()
 * @method Api\Collection collections()
 * @method Api\Category   categories()
 * @method Api\Site       sites()
 * @method Api\Asset      assets()
 * @method Api\Redirect   redirects()
 */
class DocsApiClient {

    const USER_AGENT = 'Help Scout API/Php Client v1';
    const API_URL = 'https://docsapi.helpscout.net/v1/';

    private $userAgent = false;
    private $apiKey    = false;
    private $isDebug   = false;
    private $debugDir  = false;
    private $httpClient;
    private $lastResponse = null;

    private $services = [
        'articles' => Api\Article::class,
        'collections' => Api\Collection::class,
        'categories' => Api\Category::class,
        'sites' => Api\Site::class,
        'assets' => Api\Asset::class,
        'redirects' => Api\Redirect::class
    ];

    public function __construct($apiKey = null)
    {
        $this->httpClient = new Client();
        $this->apiKey = $apiKey;
    }

    /**
    * Get the last response
    *
    * @return mixed
    */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    public function setLastResponse($response)
    {
        $this->lastResponse = $response;
        return $this;
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
    public function setDebug($bool, $dir = false)
    {
        $this->isDebug = $bool;
        if ($dir && is_dir($dir)) {
            $this->debugDir = $dir;
        }
    }

    public function isDebug()
    {
        return $this->isDebug;
    }

    public function getDebugDir()
    {
        return $this->debugDir;
    }

    /**
     * Set the API Key to use with this request
     *
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setUserAgent($userAgent)
    {
        $userAgent = trim($userAgent);
        if (!empty($userAgent)) {
            $this->userAgent = $userAgent;
        }
    }

    public function getUserAgent()
    {
        if ($this->userAgent) {
            return $this->userAgent;
        }
        return self::USER_AGENT;
    }

    public function setHttpClient($client)
    {
        $this->httpClient = $client;
    }

    public function getHttpClient()
    {
        return $this->httpClient;
    }

    private function api($name)
    {
        if (!isset($this->services[$name])) {
            throw new \Exception("Invalid service {$name}");
        }

        return new $this->services[$name]($this);
    }

    public function __call($name, $arguments)
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }

    /**
     * @param $categoryId
     * @param int $page
     * @param string $status
     * @param string $sort
     * @param string $order
     * @param int $pageSize
     * @return bool|ResourceCollection
     * @throws ApiException
     *
     * @deprecated
     */
    public function getArticles($categoryId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc', $pageSize = Article::DEFAULT_PAGE_SIZE)
    {
        return $this->articles()->all($categoryId, $page, $status, $sort, $order, $pageSize);
    }

    /**
     * @param $categoryId
     * @param int $page
     * @param string $status
     * @param string $sort
     * @param string $order
     * @param int $pageSize
     * @return ResourceCollection|mixed
     * @throws ApiException
     */
    public function getArticlesForCategory($categoryId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc', $pageSize = Article::DEFAULT_PAGE_SIZE)
    {
        return $this->articles()->allForCategory($categoryId, $page, $status, $sort, $order, $pageSize);
    }

    /**
     * @param $collectionId
     * @param int $page
     * @param string $status
     * @param string $sort
     * @param string $order
     * @param int $pageSize
     * @return ResourceCollection|mixed
     * @throws ApiException
     */
    public function getArticlesForCollection($collectionId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc', $pageSize = Article::DEFAULT_PAGE_SIZE)
    {
        return $this->articles()->allForCollection($collectionId, $page, $status, $sort, $order, $pageSize);
    }

    /**
     * @param string $query
     * @param int $page
     * @param string $collectionId
     * @param string $status
     * @param string $visibility
     * @return bool|ResourceCollection
     */
    public function searchArticles($query = '*', $page = 1, $collectionId = '', $status = 'all', $visibility = 'all')
    {
        return $this->articles()->search($query, $page, $collectionId, $status, $visibility);
    }

    /**
     * @param $articleId
     * @param int $page
     * @param string $status
     * @param string $sort
     * @param string $order
     * @return bool|ResourceCollection
     */
    public function getRelatedArticles($articleId, $page = 1, $status = 'all', $sort = 'order', $order = 'desc')
    {
        return $this->articles()->relatedArticles($articleId, $page, $status, $order, $sort);
    }

    /**
     * @param $articleId
     * @param int $page
     * @return bool|ResourceCollection
     */
    public function getRevisions($articleId, $page = 1)
    {
        return $this->articles()->revisions($articleId, $page);
    }

    /**
     * @param $articleIdOrNumber
     * @param bool $draft
     * @return bool|Models\Article
     */
    public function getArticle($articleIdOrNumber, $draft = false)
    {
        return $this->articles()->show($articleIdOrNumber, $draft);
    }

    /**
     * @param $revisionId
     * @return bool|Models\ArticleRevision
     */
    public function getRevision($revisionId)
    {
        return $this->articles()->revision($revisionId);
    }

    /**
     * @param Models\Article $article
     * @param bool $reload
     * @return bool|Models\Article
     * @throws ApiException
     */
    public function createArticle(Models\Article $article, $reload = false)
    {
        return $this->articles()->create($article, $reload);
    }

    /**
     * @param Models\Article $article
     * @param bool $reload
     * @return Models\Article
     * @throws ApiException
     */
    public function updateArticle(Models\Article $article, $reload = false)
    {
        return $this->articles()->update($article, $reload);
    }

    /**
     * @param Models\UploadArticle $uploadArticle
     * @param bool $reload
     * @return bool|Models\Article
     * @throws ApiException
     */
    public function uploadArticle(Models\UploadArticle $uploadArticle, $reload = false)
    {
        return $this->articles()->upload($uploadArticle, $reload);
    }

    /**
     * @param $articleId
     * @param int $count
     */
    public function updateViewCount($articleId, $count = 1)
    {
        return $this->articles()->updateViewCount($articleId, $count);
    }

    /**
     * @param $articleId
     */
    public function deleteArticle($articleId)
    {
        return $this->articles()->remove($articleId);
    }

    /**
     * @param $articleId
     * @param $text
     */
    public function saveArticleDraft($articleId, $text)
    {
        $this->articles()->saveDraft($articleId, $text);
    }

    /**
     * @param $articleId
     */
    public function deleteArticleDraft($articleId)
    {
        $this->articles()->removeDraft($articleId);
    }

    /**
     * @param $collectionId
     * @param int $page
     * @param string $sort
     * @param string $order
     * @return bool|ResourceCollection
     */
    public function getCategories($collectionId, $page = 1, $sort = 'order', $order = 'asc')
    {
        return $this->categories()->all($collectionId, $page, $sort, $order);
    }

    /**
     * @param $categoryIdOrNumber
     * @return bool|Models\Category
     */
    public function getCategory($categoryIdOrNumber)
    {
        return $this->categories()->show($categoryIdOrNumber);
    }

    /**
     * @param Models\Category $category
     * @param bool $reload
     * @return bool|Models\Category
     * @throws ApiException
     */
    public function createCategory(Models\Category $category, $reload = false)
    {
        return $this->categories()->create($category, $reload);
    }

    /**
     * @param Models\Category $category
     * @param bool $reload
     * @return Models\Category
     * @throws ApiException
     */
    public function updateCategory(Models\Category $category, $reload = false)
    {
        return $this->categories()->update($category, $reload);
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
    public function updateCategoryOrder($collectionId, array $categories)
    {
        $this->categories()->updateOrder($collectionId, $categories);
    }

    /**
     * @param $categoryId
     * @throws ApiException
     */
    public function deleteCategory($categoryId)
    {
        $this->categories()->remove($categoryId);
    }

    /**
     * @param int $page
     * @param string $siteId
     * @param string $visibility
     * @param string $sort
     * @param string $order
     * @return bool|ResourceCollection
     */
    public function getCollections($page = 1, $siteId = '', $visibility = 'all', $sort = 'order', $order = 'asc')
    {
        return $this->collections()->all($page, $siteId, $visibility, $sort, $order);
    }

    /**
     * @param $collectionIdOrNumber
     * @return bool|Models\Collection
     */
    public function getCollection($collectionIdOrNumber)
    {
        return $this->collections()->show($collectionIdOrNumber);
    }

    /**
     * @param Models\Collection $collection
     * @param bool $reload
     * @return bool|Models\Collection
     * @throws ApiException
     */
    public function createCollection(Models\Collection $collection, $reload = false)
    {
        return $this->collections()->create($collection, $reload);
    }

    /**
     * @param Models\Collection $collection
     * @param bool $reload
     * @return Models\Collection
     * @throws ApiException
     */
    public function updateCollection(Models\Collection $collection, $reload = false)
    {
        return $this->collections()->update($collection, $reload);
    }

    /**
     * @param $collectionId
     * @throws ApiException
     */
    public function deleteCollection($collectionId)
    {
        $this->collections()->remove($collectionId);
    }

    /**
     * @param int $page
     * @return bool|ResourceCollection
     */
    public function getSites($page = 1)
    {
        return $this->sites()->all($page);
    }

    /**
     * @param $siteId
     * @return bool|Models\Site
     */
    public function getSite($siteId)
    {
        return $this->sites()->show($siteId);
    }

    /**
     * @param Models\Site $site
     * @param bool $reload
     * @return bool|Models\Site
     * @throws ApiException
     */
    public function createSite(Models\Site $site, $reload = false)
    {
        return $this->sites()->create($site, $reload);
    }

    /**
     * @param Models\Site $site
     * @param bool $reload
     * @return Models\Site
     * @throws ApiException
     */
    public function updateSite(Models\Site $site, $reload = false)
    {
        return $this->sites()->update($site, $reload);
    }

    /**
     * @param $siteId
     * @throws ApiException
     */
    public function deleteSite($siteId)
    {
        $this->sites()->remove($siteId);
    }

    /**
     * @param Models\ArticleAsset $articleAsset
     * @return Models\ArticleAsset
     * @throws ApiException
     */
    public function createArticleAsset(Models\ArticleAsset $articleAsset)
    {
        return $this->assets()->createArticleAsset($articleAsset);
    }

    /**
     * @param Models\SettingsAsset $settingsAsset
     * @return Models\SettingsAsset
     * @throws ApiException
     */
    public function createSettingsAsset(Models\SettingsAsset $settingsAsset)
    {
        return $this->assets()->createSettingsAsset($settingsAsset);
    }

    /**
     * @param $siteId
     * @param int $page
     * @return ResourceCollection|mixed
     */
    public function getRedirects($siteId, $page = 1)
    {
        return $this->redirects()->all($siteId, $page);
    }

    /**
     * @param $redirectId
     * @return bool|Models\Redirect
     */
    public function getRedirect($redirectId)
    {
        return $this->redirects()->show($redirectId);
    }

    /**
     * @param $url
     * @param $siteId
     * @return bool|Models\RedirectedUrl
     */
    public function findRedirect($url, $siteId)
    {
        return $this->redirects()->find($url, $siteId);
    }

    /**
     * @param Models\Redirect $redirect
     * @param bool $reload
     * @return Models\Redirect
     */
    public function createRedirect(Models\Redirect $redirect, $reload = false)
    {
        return $this->redirects()->create($redirect, $reload);
    }

    /**
     * @param Models\Redirect $redirect
     * @param bool $reload
     * @return Models\Redirect
     */
    public function updateRedirect(Models\Redirect $redirect, $reload = false)
    {
        return $this->redirects()->update($redirect, $reload);
    }

    /**
     * @param $redirectId
     */
    public function deleteRedirect($redirectId)
    {
        $this->redirects()->remove($redirectId);
    }
}
