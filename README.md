helpscout-docs-api-php
======================

PHP Wrapper for the Help Scout Docs API.
More information about Docs API our: [http://developer.helpscout.net/docs-api/](http://developer.helpscout.net/docs-api/).

Inspired and followed by original [https://github.com/helpscout/helpscout-api-php](helpscout/helpscout-api-php) repository.

Requirements
---------------------
* PHP 5.3.x
* curl

Example Usage: API
---------------------
<pre><code><?php
include_once "../src/HelpScoutDocs/DocsApiClient.php";

use HelpScoutDocs\DocsApiClient;

$docsApiClient = DocsApiClient::getInstance();
$docsApiClient->setKey('my-api-key');

$collections = $docsApiClient->getCollections();

$helpCollectionName = "Existing Collection Name";

$helpCollection = reset(array_filter($collections->getItems(), function($item) use ($helpCollectionName) {
   return $item->getName() == $helpCollectionName;
}));

$helpCategories = $docsApiClient->getCategories($helpCollection->getId());

$helpCategoryName = 'Existing Category Name';

$helpCategory = reset(array_filter($helpCategories->getItems(), function($item) use ($helpCategoryName) {
   return $item->getName() == $helpCategoryName;
}));

$helpCategoryArticles = $docsApiClient->getArticles($helpCategory->getId());

$sites = $docsApiClient->getSites();
</pre></code>

Docs API Client Methods
--------------------

### Collections
* getCollections($page = 1, $siteId = '', $visibility = 'all', $sort = 'order', $order = 'asc')

### Categories
* getCategories($collectionId, $page = 1, $sort = 'order', $order = 'asc')

### Articles
* getArticles($categoryId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc')

### Sites
* getSites($page = 1)


