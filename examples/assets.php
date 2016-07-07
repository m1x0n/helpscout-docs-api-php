<?php

use HelpScoutDocs\DocsApiClient;
use HelpScoutDocs\Models\ArticleAsset;
use HelpScoutDocs\Models\SettingsAsset;

require_once __DIR__ . '/../vendor/autoload.php';

$docsClient = new DocsApiClient();
$docsClient->setKey('API_KEY');

// Create article asset
$articleAsset = new ArticleAsset();
$articleAsset->setArticleId('ARTICLE_ID');
$articleAsset->setAssetType(ArticleAsset::ARTICLE_ASSET_IMAGE);
$articleAsset->setFile('REAL_PATH_TO_FILE');
$result = $docsClient->createArticleAsset($articleAsset);

// Create settings asset
$settingsAsset = new SettingsAsset();
$settingsAsset->setSiteId('SITE_ID');
$settingsAsset->setAssetType(SettingsAsset::SETTINGS_ASSET_LOGO);
$settingsAsset->setFile('REAL_PATH_TO_FILE');
$result = $docsClient->createSettingsAsset($settingsAsset);