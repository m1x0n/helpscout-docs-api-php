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
    public function test_should_create_article_asset(): void
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

    public function test_should_throw_an_exception_about_null_article_asset_file(): void
    {
        $this->expectException(RuntimeException::class);

        $articleAsset = new ArticleAsset();

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createArticleAsset($articleAsset);
    }

    public function test_should_throw_an_exception_about_article_asset_file(): void
    {
        $this->expectException(ApiException::class);

        $articleAsset = new ArticleAsset();
        $articleAsset->setFile('');

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createArticleAsset($articleAsset);
    }

    public function test_should_throw_an_exception_about_missing_article_id(): void
    {
        $this->expectException(ApiException::class);

        $articleAsset = new ArticleAsset();
        $articleAsset->setAssetType(ArticleAsset::ARTICLE_ASSET_IMAGE);
        $articleAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(201, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createArticleAsset($articleAsset);
    }

    public function test_should_throw_an_exception_about_missing_article_asset_type(): void
    {
        $this->expectException(ApiException::class);

        $articleAsset = new ArticleAsset();
        $articleAsset->setArticleId(uniqid('', true));
        $articleAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createArticleAsset($articleAsset);
    }

    public function test_should_create_settings_asset(): void
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

    public function test_should_throw_an_exception_about_null_settings_asset_file(): void
    {
        $this->expectException(RuntimeException::class);

        $settingsAsset = new SettingsAsset();

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createSettingsAsset($settingsAsset);
    }

    public function test_should_throw_an_exception_about_settings_asset_file(): void
    {
        $this->expectException(ApiException::class);

        $settingsAsset = new SettingsAsset();
        $settingsAsset->setFile('');

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createSettingsAsset($settingsAsset);
    }

    public function test_should_throw_an_exception_about_missing_settings_asset_type(): void
    {
        $this->expectException(ApiException::class);

        $settingsAsset = new SettingsAsset();
        $settingsAsset->setSiteId(uniqid('', true));
        $settingsAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');

        $responseMock = $this->createResponseMock(201, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createSettingsAsset($settingsAsset);
    }

    public function test_should_throw_an_exception_about_missing_site_id(): void
    {
        $this->expectException(ApiException::class);

        $settingsAsset = new SettingsAsset();
        $settingsAsset->setFile(__DIR__ . '/../../fixtures/assets/octocat.png');
        $settingsAsset->setAssetType(SettingsAsset::SETTINGS_ASSET_LOGO);

        $responseMock = $this->createResponseMock(201, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->createSettingsAsset($settingsAsset);
    }

    public function test_should_throw_an_exception_if_malformed_asset_provided(): void
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

    public function test_should_throw_an_exception_if_api_key_is_invalid(): void
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
