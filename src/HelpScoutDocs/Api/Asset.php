<?php

namespace HelpScoutDocs\Api;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models;

class Asset extends AbstractApi
{
    public function createArticleAsset(Models\ArticleAsset $articleAsset)
    {
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
                'contents' => fopen($articleAsset->getFile(), 'r')
            ]
        ];

        $uploadedAsset = $this->postMultipart('assets/article', $multipart);

        $articleAsset->setFileLink($uploadedAsset->filelink);

        return $articleAsset;
    }

    public function createSettingsAsset(Models\SettingsAsset $settingsAsset)
    {
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
                'contents' => fopen($settingsAsset->getFile(), 'r')
            ]
        ];

        $uploadedAsset = $this->postMultipart('assets/settings', $multipart);

        $settingsAsset->setFileLink($uploadedAsset->filelink);

        return $settingsAsset;
    }
}
