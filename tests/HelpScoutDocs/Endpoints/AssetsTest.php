<?php

declare(strict_types=1);

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models\ArticleAsset;
use HelpScoutDocs\Models\SettingsAsset;
use HelpScoutDocs\Tests\TestCase;
use RuntimeException;

class AssetsTest extends TestCase
{
    public function testShouldCreateArticleAsset(): void
    {
        $articleAsset = new ArticleAsset();
        $articleAsset->setArticleId(uniqid('', true));
        $articleAsset->setAssetType(ArticleAsset::ARTICLE_ASSET_IMAGE);
        $articleAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(201, __DIR__ . '/../../fixtures/assets/assets.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $created = $apiClient->createArticleAsset($articleAsset);

        $this->assertInstanceOf(ArticleAsset::class, $created);
        $this->assertNotEmpty($created->getFileLink());
    }

    public function testShouldThrowAnExceptionAboutNullArticleAssetFile(): void
    {
        $this->expectException(RuntimeException::class);

        $articleAsset = new ArticleAsset();

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createArticleAsset($articleAsset);
    }

    public function testShouldThrowAnExceptionAboutArticleAssetFile(): void
    {
        $this->expectException(ApiException::class);

        $articleAsset = new ArticleAsset();
        $articleAsset->setFile('');

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createArticleAsset($articleAsset);
    }

    public function testShouldThrowAnExceptionAboutMissingArticleId(): void
    {
        $this->expectException(ApiException::class);

        $articleAsset = new ArticleAsset();
        $articleAsset->setAssetType(ArticleAsset::ARTICLE_ASSET_IMAGE);
        $articleAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createArticleAsset($articleAsset);
    }

    public function testShouldThrowAnExceptionAboutMissingArticleAssetType(): void
    {
        $this->expectException(ApiException::class);

        $articleAsset = new ArticleAsset();
        $articleAsset->setArticleId(uniqid('', true));
        $articleAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createArticleAsset($articleAsset);
    }

    public function testShouldCreateSettingsAsset(): void
    {
        $settingsAsset = new SettingsAsset();
        $settingsAsset->setSiteId(uniqid('', true));
        $settingsAsset->setAssetType(SettingsAsset::SETTINGS_ASSET_LOGO);
        $settingsAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(201, __DIR__ . '/../../fixtures/assets/assets.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $created = $apiClient->createSettingsAsset($settingsAsset);

        $this->assertInstanceOf(SettingsAsset::class, $created);
        $this->assertNotEmpty($created->getFileLink());
    }

    public function testShouldThrowAnExceptionAboutNullSettingsAssetFile(): void
    {
        $this->expectException(RuntimeException::class);

        $settingsAsset = new SettingsAsset();

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createSettingsAsset($settingsAsset);
    }

    public function testShouldThrowAnExceptionAboutSettingsAssetFile(): void
    {
        $this->expectException(ApiException::class);

        $settingsAsset = new SettingsAsset();
        $settingsAsset->setFile('');

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createSettingsAsset($settingsAsset);
    }

    public function testShouldThrowAnExceptionAboutMissingSettingsAssetType(): void
    {
        $this->expectException(ApiException::class);

        $settingsAsset = new SettingsAsset();
        $settingsAsset->setSiteId(uniqid('', true));
        $settingsAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(201, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createSettingsAsset($settingsAsset);
    }

    public function testShouldThrowAnExceptionAboutMissingSiteId(): void
    {
        $this->expectException(ApiException::class);

        $settingsAsset = new SettingsAsset();
        $settingsAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');
        $settingsAsset->setAssetType(SettingsAsset::SETTINGS_ASSET_LOGO);

        $responseMock = $this->createResponseMock(201, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createSettingsAsset($settingsAsset);
    }

    public function testShouldThrowAnExceptionIfMalformedAssetProvided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        $articleAsset = new ArticleAsset();
        $articleAsset->setArticleId(uniqid('', true));
        $articleAsset->setAssetType(ArticleAsset::ARTICLE_ASSET_IMAGE);
        $articleAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(400, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createArticleAsset($articleAsset);
    }

    public function testShouldThrowAnExceptioniIfApiKeyIsInvalid(): void
    {
        $this->expectException(ApiException::class);

        $articleAsset = new ArticleAsset();
        $articleAsset->setArticleId(uniqid('', true));
        $articleAsset->setAssetType(ArticleAsset::ARTICLE_ASSET_IMAGE);
        $articleAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(201, __DIR__ . '/../../fixtures/assets/assets.json');
        $apiClient = $this->createTestApiClient($responseMock);
        $apiClient->setApiKey('');

        $apiClient->createArticleAsset($articleAsset);
    }
}
