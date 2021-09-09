<?php

declare(strict_types=1);

namespace HelpScoutDocs;

use BadMethodCallException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use HelpScoutDocs\Api\Article;
use HelpScoutDocs\Models\ArticleAsset;
use HelpScoutDocs\Models\Category;
use HelpScoutDocs\Models\Collection;
use HelpScoutDocs\Models\Redirect;
use HelpScoutDocs\Models\SettingsAsset;
use HelpScoutDocs\Models\Site;
use InvalidArgumentException;
use HelpScoutDocs\Models;
use Psr\Http\Message\ResponseInterface;

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
class DocsApiClient
{

    private const USER_AGENT = 'Help Scout API/Docs Php Client v1';
    public const API_URL = 'https://docsapi.helpscout.net/v1/';

    private ?string $userAgent = null;
    private string $apiKey;
    private bool $isDebug   = false;
    private ?string $debugDir  = null;
    private ClientInterface $httpClient;
    private ?ResponseInterface $lastResponse = null;

    private array $services = [
        'articles' => Api\Article::class,
        'collections' => Api\Collection::class,
        'categories' => Api\Category::class,
        'sites' => Api\Site::class,
        'assets' => Api\Asset::class,
        'redirects' => Api\Redirect::class
    ];

    public function __construct(string $apiKey, ?ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new Client();
        $this->apiKey = $apiKey;
    }

    public function getLastResponse(): ?ResponseInterface
    {
        return $this->lastResponse;
    }

    public function setLastResponse(ResponseInterface $response): self
    {
        $this->lastResponse = $response;
        return $this;
    }

    public function setDebug(bool $bool, ?string $dir = null): void
    {
        $this->isDebug = $bool;
        if (!$dir) {
            return;
        }
        if (!is_dir($dir)) {
            return;
        }
        $this->debugDir = $dir;
    }

    public function isDebug(): bool
    {
        return $this->isDebug;
    }

    public function getDebugDir(): ?string
    {
        return $this->debugDir;
    }

    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setUserAgent(string $userAgent): void
    {
        $userAgent = trim($userAgent);
        if (!empty($userAgent)) {
            $this->userAgent = $userAgent;
        }
    }

    public function getUserAgent(): string
    {
        if ($this->userAgent) {
            return $this->userAgent;
        }
        return self::USER_AGENT;
    }

    public function setHttpClient(ClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    private function api(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new \Exception("Invalid service {$name}");
        }

        return new $this->services[$name]($this);
    }

    public function __call(string $name, $arguments)
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(
                sprintf('Undefined method called: "%s"', $name),
                $e->getCode(),
                $e
            );
        }
    }

    public function getArticles(
        string $categoryId,
        int $page = 1,
        string $status = 'all',
        string $sort = 'order',
        string $order = 'asc',
        int $pageSize = Article::DEFAULT_PAGE_SIZE
    ): ResourceCollection {
        return $this->articles()->all($categoryId, $page, $status, $sort, $order, $pageSize);
    }

    public function getArticlesForCategory(
        string $categoryId,
        int $page = 1,
        string $status = 'all',
        string $sort = 'order',
        string $order = 'asc',
        int $pageSize = Article::DEFAULT_PAGE_SIZE
    ): ResourceCollection {
        return $this->articles()->allForCategory($categoryId, $page, $status, $sort, $order, $pageSize);
    }

    public function getArticlesForCollection(
        string $collectionId,
        int $page = 1,
        string $status = 'all',
        string $sort = 'order',
        string $order = 'asc',
        int $pageSize = Article::DEFAULT_PAGE_SIZE
    ): ResourceCollection {
        return $this->articles()->allForCollection($collectionId, $page, $status, $sort, $order, $pageSize);
    }

    public function searchArticles(
        string $query = '*',
        int $page = 1,
        string $collectionId = '',
        string $status = 'all',
        string $visibility = 'all'
    ): ResourceCollection {
        return $this->articles()->search($query, $page, $collectionId, $status, $visibility);
    }

    public function getRelatedArticles(
        string $articleId,
        int $page = 1,
        string $status = 'all',
        string $sort = 'order',
        string $order = 'desc'
    ): ResourceCollection {
        return $this->articles()->relatedArticles($articleId, $page, $status, $order, $sort);
    }

    public function getRevisions(string $articleId, int $page = 1): ResourceCollection
    {
        return $this->articles()->revisions($articleId, $page);
    }

    public function getArticle(string $articleIdOrNumber, bool $draft = false): Models\Article
    {
        return $this->articles()->show($articleIdOrNumber, $draft);
    }

    public function getRevision(string $revisionId): Models\ArticleRevision
    {
        return $this->articles()->revision($revisionId);
    }

    public function createArticle(Models\Article $article): void
    {
        $this->articles()->createArticle($article);
    }

    public function createArticleAndReturnCreated(Models\Article $article): Models\Article
    {
        return $this->articles()->createArticleAndReturnCreated($article);
    }

    public function updateArticle(Models\Article $article): void
    {
        $this->articles()->updateArticle($article);
    }

    public function updateArticleAndReturnUpdated(Models\Article $article): Models\Article
    {
        return $this->articles()->updateArticleAndReturnUpdated($article);
    }

    public function uploadArticle(Models\UploadArticle $uploadArticle): void
    {
        $this->articles()->uploadArticle($uploadArticle);
    }

    public function uploadArticleAndReturnUploaded(Models\UploadArticle $uploadArticle): Models\Article
    {
        return $this->articles()->uploadArticleAndReturnUploaded($uploadArticle);
    }

    public function updateViewCount(string $articleId, int $count = 1): void
    {
        $this->articles()->updateViewCount($articleId, $count);
    }

    public function deleteArticle(string $articleId): void
    {
        $this->articles()->remove($articleId);
    }

    public function saveArticleDraft(string $articleId, string $text): void
    {
        $this->articles()->saveDraft($articleId, $text);
    }

    public function deleteArticleDraft(string $articleId): void
    {
        $this->articles()->removeDraft($articleId);
    }

    public function getCategories(
        string $collectionId,
        int $page = 1,
        string $sort = 'order',
        string $order = 'asc'
    ): ResourceCollection {
        return $this->categories()->all($collectionId, $page, $sort, $order);
    }

    public function getCategory(string $categoryIdOrNumber): Category
    {
        return $this->categories()->show($categoryIdOrNumber);
    }

    public function createCategory(Category $category): void
    {
        $this->categories()->createCategory($category);
    }

    public function createCategoryAndReturnCreated(Category $category): Category
    {
        return $this->categories()->createCategoryAndReturnCreated($category);
    }

    public function updateCategory(Category $category): void
    {
        $this->categories()->updateCategory($category);
    }

    public function updateCategoryAndReturnUpdated(Category $category): Category
    {
        return $this->categories()->updateCategoryAndReturnUpdated($category);
    }

    /**
     * @param string $collectionId
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
    public function updateCategoryOrder(string $collectionId, array $categories): void
    {
        $this->categories()->updateOrder($collectionId, $categories);
    }

    public function deleteCategory(string $categoryId): void
    {
        $this->categories()->remove($categoryId);
    }

    public function getCollections(
        int $page = 1,
        string $siteId = '',
        string $visibility = 'all',
        string $sort = 'order',
        string $order = 'asc'
    ): ResourceCollection {
        return $this->collections()->all($page, $siteId, $visibility, $sort, $order);
    }

    public function getCollection(string $collectionIdOrNumber): Collection
    {
        return $this->collections()->show($collectionIdOrNumber);
    }

    public function createCollection(Collection $collection): void
    {
        $this->collections()->createCollection($collection);
    }

    public function createCollectionAndReturnCreated(Collection $collection): Collection
    {
        return $this->collections()->createCollectionAndReturnCreated($collection);
    }

    public function updateCollection(Collection $collection): void
    {
        $this->collections()->updateCollection($collection);
    }

    public function updateCollectionAndReturnUpdated(Collection $collection): Collection
    {
        return $this->collections()->updateCollectionAndReturnUpdated($collection);
    }

    public function deleteCollection(string $collectionId): void
    {
        $this->collections()->remove($collectionId);
    }

    public function getSites(int $page = 1): ResourceCollection
    {
        return $this->sites()->all($page);
    }

    public function getSite(int $siteId): Site
    {
        return $this->sites()->show($siteId);
    }

    public function createSite(Site $site): void
    {
        $this->sites()->createSite($site);
    }

    public function createSiteAndReturnCreated(Site $site): Site
    {
        return $this->sites()->createSiteAndReturnCreated($site);
    }

    public function updateSite(Site $site): void
    {
        $this->sites()->updateSite($site);
    }

    public function updateSiteAndReturnUpdated(Site $site): Site
    {
        return $this->sites()->updateSiteAndReturnUpdated($site);
    }

    public function deleteSite(int $siteId): void
    {
        $this->sites()->remove($siteId);
    }

    public function createArticleAsset(ArticleAsset $articleAsset): ArticleAsset
    {
        return $this->assets()->createArticleAsset($articleAsset);
    }

    public function createSettingsAsset(SettingsAsset $settingsAsset): SettingsAsset
    {
        return $this->assets()->createSettingsAsset($settingsAsset);
    }

    public function getRedirects(string $siteId, int $page = 1): ResourceCollection
    {
        return $this->redirects()->all($siteId, $page);
    }

    public function getRedirect(string $redirectId): Redirect
    {
        return $this->redirects()->show($redirectId);
    }

    public function findRedirect(string $url, string $siteId): Models\RedirectedUrl
    {
        return $this->redirects()->find($url, $siteId);
    }

    public function createRedirect(Redirect $redirect): void
    {
        $this->redirects()->createRedirect($redirect);
    }

    public function createRedirectAndReturnCreated(Redirect $redirect): Redirect
    {
        return $this->redirects()->createRedirectAndReturnCreated($redirect);
    }

    public function updateRedirect(Redirect $redirect): void
    {
        $this->redirects()->updateRedirect($redirect);
    }

    public function updateRedirectAndReturnUpdated(Redirect $redirect): Redirect
    {
        return $this->redirects()->updateRedirectAndReturnUpdated($redirect);
    }

    public function deleteRedirect(string $redirectId): void
    {
        $this->redirects()->remove($redirectId);
    }
}
