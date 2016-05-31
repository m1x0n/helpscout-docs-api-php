helpscout-docs-api-php
======================

PHP Wrapper for the Help Scout Docs API.
More information about Docs API: [http://developer.helpscout.net/docs-api/](http://developer.helpscout.net/docs-api/).

Inspired and followed by original [https://github.com/helpscout/helpscout-api-php](https://github.com/helpscout/helpscout-api-php) repository.

Requirements
---------------------
* PHP >= 5.3.x
* curl

Installation
--------------------
TBD

Example Usage:
---------------------
```php
require_once __DIR__ . '/../vendor/autoload.php';

use HelpScoutDocs\DocsApiClient;

$docsApiClient = new DocsApiClient();
$docsApiClient->setKey('your-api-key');

$collections = $docsApiClient->getCollections();

```

Docs API Client Endpoints Methods
--------------------

### Collections
* getCollections($page = 1, $siteId = '', $visibility = 'all', $sort = 'order', $order = 'asc')
* getCollection($collectionIdOrNumber)
* createCollection(Collection $collection, $reload = false)
* updateCollection(Collection $collection, $reload = false)
* deleteCollection($collectionId)

### Categories
* getCategories($collectionId, $page = 1, $sort = 'order', $order = 'asc')
* getCategory($categoryIdOrNumber)
* createCategory(Category $category, $reload = false)
* updateCategory(Category $category, $reload = false)
* updateCategoryOrder($collectionId, array $categories)
* deleteCategory($categoryId)

### Articles
* getArticles($categoryId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc')
* searchArticles($query = '*', $page = 1, $collectionId = '', $status = 'all', $visibility = 'all')
* getRelatedArticles($articleId, $page = 1, $status = 'all', $sort = 'order', $order = 'desc')
* getRevisions($articleId, $page = 1)
* getArticle($articleIdOrNumber, $draft = false)
* getRevision($revisionId)
* createArticle(Article $article, $reload = false)
* updateArticle(Article $article, $reload = false)
* uploadArticle($collectionId, $file, $categoryId = null, $name = null, $slug = null, $type = null, $reload = false)
* updateViewCount($articleId, $count = 1)
* deleteArticle($articleId)
* saveArticleDraft($articleId, $text)
* deleteArticleDraft($articleId)

### Sites
* getSites($page = 1)
* getSite($siteId)
* createSite(Site $site, $reload = false)
* updateSite(Site $site, $reload = false)
* deleteSite($siteId)

### Assets
* Not implemented yet
