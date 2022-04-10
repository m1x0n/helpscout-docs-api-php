<?php

use HelpScoutDocs\DocsApiClient;
use HelpScoutDocs\Models\UploadArticle;

require_once __DIR__ . '/../vendor/autoload.php';

$docsClient = new DocsApiClient('your-api-key');
$docsClient->setApiKey('API_KEY');

$upload = new UploadArticle();
$upload->setCollectionId('COLLECTION_ID');
$upload->setName(uniqid('Uploaded Article ', true));
$upload->setFile('REAL_PATH_TO_FILE');

$article = $docsClient->uploadArticleAndReturnUploaded($upload);
