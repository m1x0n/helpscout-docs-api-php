<?php

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