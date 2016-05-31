<?php

require_once __DIR__ . '/../vendor/autoload.php';

use HelpScoutDocs\DocsApiClient;

$docsApiClient = new DocsApiClient();
$docsApiClient->setKey('your-api-key');

$collections = $docsApiClient->getCollections();

$helpCollectionName = "Your Existing Collection Name Here";

$helpCollection = array_filter($collections->getItems(), function($item) use ($helpCollectionName) {
    return $item->getName() == $helpCollectionName;
});

$helpCollection = reset($helpCollection);

$helpCategories = $docsApiClient->getCategories($helpCollection->getId());

$helpCategoryName = 'Your existing category here';

$helpCategory = array_filter($helpCategories->getItems(), function($item) use ($helpCategoryName) {
    return $item->getName() == $helpCategoryName;
});

$helpCategory = reset($helpCategory);

$helpCategoryArticles = $docsApiClient->getArticles($helpCategory->getId());

$sites = $docsApiClient->getSites();

$site = $docsApiClient->getSite('your-site-id-here');

$articles = $docsApiClient->searchArticles();

