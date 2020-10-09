<?php

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\Models\Article;
use HelpScoutDocs\Models\ArticleRevision;
use HelpScoutDocs\Models\UploadArticle;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class ArticlesTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_articles_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticles(uniqid());

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }

    /**
     * @test
     */
    public function should_throw_an_exception_on_invalid_file(): void
    {
        $this->expectException(\HelpScoutDocs\ApiException::class);

        $responseMock = $this->createResponseMock(201, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();

        $apiClient->uploadArticle($article);
    }

    /**
     * @test
     */
    public function should_upload_an_article(): void
    {
        $responseMock = $this->createResponseMock(201, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();
        $article->setCollectionId(uniqid());
        $article->setName(uniqid('Uploaded Article '));
        $article->setFile(__DIR__ . '/../../fixtures/articles/article.html');

        $uploaded = $apiClient->uploadArticle($article);
        $this->assertTrue($uploaded);
    }

    /**
     * @test
     */
    public function should_upload_an_article_and_respond_with_article_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/uploaded.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();
        $article->setCollectionId(uniqid());
        $article->setName(uniqid('Uploaded Article '));
        $article->setFile(__DIR__ . '/../../fixtures/articles/article.html');

        $uploaded = $apiClient->uploadArticle($article, true);

        $this->assertInstanceOf(Article::class, $uploaded);
    }

    /**
     * @test
     */
    public function should_return_an_article_by_provided_id_or_number(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/article.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $article = $apiClient->getArticle(uniqid());

        $this->assertInstanceOf(Article::class, $article);
    }

    /**
     * @test
     */
    public function should_throw_an_exception_if_invalid_article_id_or_number_provided(): void
    {
        $this->expectException(\HelpScoutDocs\ApiException::class);
        $this->expectExceptionCode(404);

        $responseMock = $this->createResponseMock(404, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getArticle(uniqid());
    }

    /**
     * @test
     */
    public function should_search_for_articles_by_given_query_and_return_not_empty_result(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->searchArticles("test");

        $this->assertInstanceOf(ResourceCollection::class, $articles);
        $this->assertCount(1, $articles);
    }

    /**
     * @test
     */
    public function should_return_related_articles_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $related = $apiClient->getRelatedArticles(uniqid());

        $this->assertInstanceOf(ResourceCollection::class, $related);
    }

    /**
     * @test
     */
    public function should_return_article_revisions_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/revisions.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $revisions = $apiClient->getRevisions(uniqid());

        $this->assertInstanceOf(ResourceCollection::class, $revisions);
    }

    /**
     * @test
     */
    public function should_return_article_revision_by_given_id(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/revision.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $revision = $apiClient->getRevision(uniqid());

        $this->assertInstanceOf(ArticleRevision::class, $revision);
    }

    /**
     * @test
     */
    public function should_throw_an_exception_if_invalid_revision_id_provided(): void
    {
        $this->expectException(\HelpScoutDocs\ApiException::class);
        $this->expectExceptionCode(404);

        $responseMock = $this->createResponseMock(404, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getRevision(uniqid());
    }

    /**
     * @test
     */
    public function should_create_article_and_response_with_new_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/article.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();
        $article->setCollectionId(uniqid());
        $article->setName(uniqid("Article Name "));
        $article->setText("Article text");

        $created = $apiClient->createArticle($article, true);

        $this->assertInstanceOf(Article::class, $created);
    }

    /**
     * @test
     */
    public function should_create_article_and_assign_id(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();
        $article->setCollectionId(uniqid());
        $article->setName(uniqid("Article Name "));
        $article->setText("Article text");

        $created = $apiClient->createArticle($article, false);

        $this->assertInstanceOf(Article::class, $created);
        $this->assertNotEmpty($created->getId());
    }

    /**
     * @test
     */
    public function should_throw_an_exception_if_malformed_article_provided(): void
    {
        $this->expectException(\HelpScoutDocs\ApiException::class);
        $this->expectExceptionCode(400);

        $responseMock = $this->createResponseMock(400, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();

        $apiClient->createArticle($article, true);
    }

    /**
     * @test
     */
    public function should_update_existing_article_and_respond_with_updated_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/article.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();
        $article->setId(uniqid());
        $article->setCollectionId(uniqid());
        $article->setName(uniqid("New Article Name "));
        $article->setText("New Article text");

        $updated = $apiClient->updateArticle($article, true);

        $this->assertInstanceOf(Article::class, $updated);
    }

    /**
     * @test
     */
    public function should_update_existing_article_and_respond_without_instance(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();
        $article->setId(uniqid());
        $article->setCollectionId(uniqid());
        $article->setName(uniqid("New Article Name "));
        $article->setText("New Article text");

        $updated = $apiClient->updateArticle($article, false);

        $this->assertSame($article, $updated);
    }

    /**
     * @test
     */
    public function should_update_existing_article_view_count(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->updateViewCount(uniqid(), 1);
    }

    /**
     * @test
     */
    public function should_delete_existing_article(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteArticle(uniqid());
    }

    /**
     * @test
     */
    public function should_save_existing_article_draft(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->saveArticleDraft(uniqid(), "Draft text");
    }

    /**
     * @test
     */
    public function should_delete_existing_article_draft(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteArticleDraft(uniqid());
    }

    /**
     * @test
     */
    public function should_return_articles_for_category(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticlesForCategory(uniqid());

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }

    /**
     * @test
     */
    public function should_return_articles_for_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticlesForCollection(uniqid());

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }
}
