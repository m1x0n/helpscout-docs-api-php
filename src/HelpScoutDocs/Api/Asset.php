<?php
declare(strict_types=1);

namespace HelpScoutDocs\Api;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models\ArticleAsset;
use HelpScoutDocs\Models\SettingsAsset;
use RuntimeException;

class Asset extends AbstractApi
{
    public function createArticleAsset(ArticleAsset $articleAsset): ArticleAsset
    {
        if ($articleAsset->getFile() === null) {
            throw new RuntimeException('No file path provided for Asset::createArticleAsset');
        }

        if (!file_exists($articleAsset->getFile())) {
            throw new ApiException(sprintf("Unable to locate file: %s", $articleAsset->getFile()));
        }

        if (empty($articleAsset->getArticleId())) {
            throw new ApiException("articleId is empty or not provided");
        }

        if (empty($articleAsset->getAssetType())) {
            throw new ApiException("assetType is empty or not provided");
        }

        $multipart = [
            [
                'name' => 'key',
                'contents' => $this->client->getApiKey()
            ],
            [
                'name' => 'articleId',
                'contents' => $articleAsset->getArticleId()
            ],
            [
                'name' => 'assetType',
                'contents' => $articleAsset->getAssetType()
            ],
            [
                'name' => 'file',
                'contents' => fopen($articleAsset->getFile(), 'rb')
            ]
        ];

        $uploadedAsset = $this->postMultipart('assets/article', $multipart);

        if ($uploadedAsset && $uploadedAsset->filelink) {
            $articleAsset->setFileLink($uploadedAsset->filelink);
        }

        return $articleAsset;
    }

    public function createSettingsAsset(SettingsAsset $settingsAsset): SettingsAsset
    {
        if ($settingsAsset->getFile() === null) {
            throw new RuntimeException('No file path provided for Asset::createSettingsAsset');
        }

        if (!file_exists($settingsAsset->getFile())) {
            throw new ApiException(sprintf("Unable to locate file: %s", $settingsAsset->getFile()));
        }

        if (empty($settingsAsset->getAssetType())) {
            throw new ApiException("assetType is empty or not provided");
        }

        if (empty($settingsAsset->getSiteId())) {
            throw new ApiException("siteId is empty or not provided");
        }

        $multipart = [
            [
                'name' => 'key',
                'contents' => $this->client->getApiKey()
            ],
            [
                'name' => 'assetType',
                'contents' => $settingsAsset->getAssetType()
            ],
            [
                'name' => 'siteId',
                'contents' => $settingsAsset->getSiteId()
            ],
            [
                'name' => 'file',
                'contents' => fopen($settingsAsset->getFile(), 'rb')
            ]
        ];

        $uploadedAsset = $this->postMultipart('assets/settings', $multipart);

        if ($uploadedAsset && $uploadedAsset->filelink) {
            $settingsAsset->setFileLink($uploadedAsset->filelink);
        }

        return $settingsAsset;
    }
}
