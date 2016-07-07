<?php

require_once __DIR__ . '/../vendor/autoload.php';

use HelpScoutDocs\DocsApiClient;

// Initialize client
$docsApiClient = new DocsApiClient();
$docsApiClient->setKey('your-api-key');

// Get all collections
$collections = $docsApiClient->getCollections();

// Get all categories by collection ID
$helpCategories = $docsApiClient->getCategories('COLLECTION_ID');

// Get all articles by category ID
$helpCategoryArticles = $docsApiClient->getArticles('CATEGORY_ID');

// Get all sites
$sites = $docsApiClient->getSites();

// Get specific site by ID
$site = $docsApiClient->getSite('your-site-id-here');

// Run default articles search
$articles = $docsApiClient->searchArticles();

