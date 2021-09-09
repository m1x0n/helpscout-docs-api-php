<?php
declare(strict_types=1);

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models\Article;
use HelpScoutDocs\Models\ArticleRevision;
use HelpScoutDocs\Models\UploadArticle;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class ArticlesTest extends TestCase
{
    public function test_should_return_articles_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticles(uniqid("", true));

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }

    public function test_should_throw_an_exception_on_invalid_file(): void
    {
        $this->expectException(ApiException::class);

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();
        $article->setFile('testf');

        $apiClient->uploadArticle($article);
    }

    public function test_should_throw_an_exception_when_no_file_provided(): void
    {
        $this->expectException(\RuntimeException::class);

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();

        $apiClient->uploadArticle($article);
    }

    public function test_should_upload_an_article(): void
    {
        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();
        $article->setCollectionId(uniqid('', true));
        $article->setName(uniqid('Uploaded Article ', true));
        $article->setFile(__DIR__ . '/../../fixtures/articles/article.html');

        $apiClient->uploadArticle($article);
    }

    public function test_should_upload_an_article_and_respond_with_article_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/uploaded.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();
        $article->setCollectionId(uniqid('', true));
        $article->setName(uniqid('Uploaded Article ', true));
        $article->setFile(__DIR__ . '/../../fixtures/articles/article.html');

        $uploaded = $apiClient->uploadArticleAndReturnUploaded($article);

        $this->assertInstanceOf(Article::class, $uploaded);
    }
    
    public function test_should_return_an_article_by_provided_id_or_number(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/article.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $article = $apiClient->getArticle(uniqid('', true));

        $this->assertInstanceOf(Article::class, $article);
    }
    
    public function test_should_throw_an_exception_if_invalid_article_id_or_number_provided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        $responseMock = $this->createResponseMock(404, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getArticle(uniqid('', true));
    }

    public function test_should_search_for_articles_by_given_query_and_return_not_empty_result(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->searchArticles("test");

        $this->assertInstanceOf(ResourceCollection::class, $articles);
        $this->assertCount(1, $articles);
    }

    public function test_should_return_related_articles_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $related = $apiClient->getRelatedArticles(uniqid('', true));

        $this->assertInstanceOf(ResourceCollection::class, $related);
    }

    public function test_should_return_article_revisions_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/revisions.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $revisions = $apiClient->getRevisions(uniqid('', true));

        $this->assertInstanceOf(ResourceCollection::class, $revisions);
    }

    public function test_should_return_article_revision_by_given_id(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/revision.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $revision = $apiClient->getRevision(uniqid('', true));

        $this->assertInstanceOf(ArticleRevision::class, $revision);
    }

    public function test_should_throw_an_exception_if_invalid_revision_id_provided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        $responseMock = $this->createResponseMock(404, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getRevision(uniqid('', true));
    }

    public function test_should_create_article_and_response_with_new_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/article.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();
        $article->setCollectionId(uniqid('', true));
        $article->setName(uniqid("Article Name ", true));
        $article->setText("Article text");

        $created = $apiClient->createArticleAndReturnCreated($article);

        $this->assertInstanceOf(Article::class, $created);
    }

    public function test_should_create_article(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();
        $article->setCollectionId(uniqid('', true));
        $article->setName(uniqid("Article Name ", true));
        $article->setText("Article text");

        $apiClient->createArticle($article);
    }

    public function test_should_throw_an_exception_if_malformed_article_provided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        $responseMock = $this->createResponseMock(400, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();

        $apiClient->createArticle($article, true);
    }

    public function test_should_update_existing_article_and_respond_with_updated_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/article.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();
        $article->setId(uniqid('', true));
        $article->setCollectionId(uniqid('', true));
        $article->setName(uniqid("New Article Name ", true));
        $article->setText("New Article text");

        $updated = $apiClient->updateArticleAndReturnUpdated($article);

        $this->assertInstanceOf(Article::class, $updated);
    }

    public function test_should_update_existing_article_and_respond_without_instance(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();
        $article->setId(uniqid('', true));
        $article->setCollectionId(uniqid('', true));
        $article->setName(uniqid("New Article Name ", true));
        $article->setText("New Article text");

        $apiClient->updateArticle($article);
    }

    public function test_should_update_existing_article_view_count(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->updateViewCount(uniqid('', true), 1);
    }

    public function test_should_delete_existing_article(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteArticle(uniqid('', true));
    }

    public function test_should_save_existing_article_draft(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->saveArticleDraft(uniqid('', true), "Draft text");
    }

    public function test_should_delete_existing_article_draft(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteArticleDraft(uniqid('', true));
    }

    public function test_should_return_articles_for_category(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticlesForCategory(uniqid('', true));

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }

    public function test_should_return_articles_for_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticlesForCollection(uniqid('', true));

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }
}
