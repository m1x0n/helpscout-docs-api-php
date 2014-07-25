helpscout-docs-api-php
======================

PHP Wrapper for the Help Scout Docs API.
More information about Docs API: [http://developer.helpscout.net/docs-api/](http://developer.helpscout.net/docs-api/).

Inspired and followed by original [https://github.com/helpscout/helpscout-api-php](helpscout/helpscout-api-php) repository.

Requirements
---------------------
* PHP 5.3.x
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

$helpCollectionName = "Existing Collection Name";

$helpCollection = reset(array_filter($collections->getItems(), function($item) use ($helpCollectionName) {
    return $item->getName() == $helpCollectionName;
}));


// Get categories which belong to specified collection
$helpCategories = $docsApiClient->getCategories($helpCollection->getId());

$helpCategoryName = 'Existing Category Name';

$helpCategory = reset(array_filter($helpCategories->getItems(), function($item) use ($helpCategoryName) {
    return $item->getName() == $helpCategoryName;
}));

// Get articles by category
$helpCategoryArticles = $docsApiClient->getArticles($helpCategory->getId());

// Get available sites
$sites = $docsApiClient->getSites();

// Get certain site
$site = $docsApiClient->getSite('your-site-id');

// Get all available articles
$articles = $docsApiClient->searchArticles();
```

Docs API Client Methods
--------------------

### Collections
* getCollections($page = 1, $siteId = '', $visibility = 'all', $sort = 'order', $order = 'asc')

### Categories
* getCategories($collectionId, $page = 1, $sort = 'order', $order = 'asc')

### Articles
* getArticles($categoryId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc')
* searchArticles($query = '*', $page = 1, $collectionId = '', $status = 'all', $visibility = 'all')

### Sites
* getSites($page = 1)
* getSite($siteId)

