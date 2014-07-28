helpscout-docs-api-php
======================

PHP Wrapper for the Help Scout Docs API.
More information about Docs API: [http://developer.helpscout.net/docs-api/](http://developer.helpscout.net/docs-api/).

Inspired and followed by original [https://github.com/helpscout/helpscout-api-php](https://github.com/helpscout/helpscout-api-php) repository.

Requirements
---------------------
* PHP >= 5.3.x
* curl

Example Usage:
---------------------
```php
include_once "../src/HelpScoutDocs/DocsApiClient.php";

use HelpScoutDocs\DocsApiClient;

// Create client instance
$docsApiClient = DocsApiClient::getInstance();
$docsApiClient->setKey('my-api-key');

// Get available collections
$collections = $docsApiClient->getCollections();

// Get categories which belong to specified collection
$helpCategories = $docsApiClient->getCategories('collection-id-here');

// Get articles by category
$helpCategoryArticles = $docsApiClient->getArticles('category-id-here');

// Get available sites
$sites = $docsApiClient->getSites();

// Get certain site
$site = $docsApiClient->getSite('your-site-id');

// Get all available articles
$articles = $docsApiClient->searchArticles();
```

Docs API Client Endpoints Methods
--------------------

### Collections
* getCollections($page = 1, $siteId = '', $visibility = 'all', $sort = 'order', $order = 'asc')
* getCollection($collectionIdOrNumber)
* createCollection(model\Collection $collection, $reload = false)
* updateCollection(model\Collection $collection, $reload = false)
* deleteCollection($collectionId)

### Categories
* getCategories($collectionId, $page = 1, $sort = 'order', $order = 'asc')
* getCategory($categoryIdOrNumber)
* createCategory(model\Category $category, $reload = false)
* updateCategory(model\Category $category, $reload = false)
* updateCategoryOrder($collectionId, array $categories)
* deleteCategory($categoryId)

### Articles
* getArticles($categoryId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc')
* searchArticles($query = '*', $page = 1, $collectionId = '', $status = 'all', $visibility = 'all')
* getRelatedArticles($articleId, $page = 1, $status = 'all', $sort = 'order', $order = 'desc')
* getRevisions($articleId, $page = 1)
* getArticle($articleIdOrNumber, $draft = false)
* getRevision($revisionId)
* createArticle(model\Article $article, $reload = false)
* updateArticle(model\Article $article, $reload = false)
* uploadArticle($collectionId, $file, $categoryId = null, $name = null, $slug = null, $type = null, $reload = false)
* updateViewCount($articleId, $count = 1)
* deleteArticle($articleId)
* saveArticleDraft($articleId, $text)
* deleteArticleDraft($articleId)

### Sites
* getSites($page = 1)
* getSite($siteId)

### Assets
* Not implemented yet
