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
    public function testShouldReturnArticlesCollection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticles(uniqid("", true));

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }

    public function testShouldThrowAnExceptionOnInvalidFile(): void
    {
        $this->expectException(ApiException::class);

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();
        $article->setFile('testf');

        $apiClient->uploadArticle($article);
    }

    public function testShouldThrowAnExceptionWhenNoFileProvided(): void
    {
        $this->expectException(\RuntimeException::class);

        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();

        $apiClient->uploadArticle($article);
    }

    public function testShouldUploadAnArticle(): void
    {
        $responseMock = $this->createResponseMock(201);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();
        $article->setCollectionId(uniqid('', true));
        $article->setName(uniqid('Uploaded Article ', true));
        $article->setFile(__DIR__ . '/../../fixtures/articles/article.html');

        $apiClient->uploadArticle($article);
    }

    public function testShouldUploadAnArticleAndRespondWithArticleInstance(): void
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

    public function testShouldReturnAnArticleByProvidedIdOrNumber(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/article.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $article = $apiClient->getArticle(uniqid('', true));

        $this->assertInstanceOf(Article::class, $article);
    }

    public function testShouldThrowAnExceptionIfInvalidArticleIdOrNumberProvided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        $responseMock = $this->createResponseMock(404);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getArticle(uniqid('', true));
    }

    public function testShouldSearchForArticlesByGivenQueryAndReturnNotEmptyResult(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->searchArticles("test");

        $this->assertInstanceOf(ResourceCollection::class, $articles);
        $this->assertCount(1, $articles);
    }

    public function testShouldReturnRelatedArticlesCollection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $related = $apiClient->getRelatedArticles(uniqid('', true));

        $this->assertInstanceOf(ResourceCollection::class, $related);
    }

    public function testShouldReturnArticleRevisionsCollection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/revisions.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $revisions = $apiClient->getRevisions(uniqid('', true));

        $this->assertInstanceOf(ResourceCollection::class, $revisions);
    }

    public function testShouldReturnArticleRevisionByGivenId(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/revision.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $revision = $apiClient->getRevision(uniqid('', true));

        $this->assertInstanceOf(ArticleRevision::class, $revision);
    }

    public function testShouldThrowAnExceptionIfInvalidRevisionIdProvided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        $responseMock = $this->createResponseMock(404);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getRevision(uniqid('', true));
    }

    public function testShouldCreateArticleAndResponseWithNewInstance(): void
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

    public function testShouldCreateArticle(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();
        $article->setCollectionId(uniqid('', true));
        $article->setName(uniqid("Article Name ", true));
        $article->setText("Article text");

        $apiClient->createArticle($article);
    }

    public function testShouldThrowAnExceptionIfMalformedArticleProvided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(400);

        $responseMock = $this->createResponseMock(400);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new Article();

        $apiClient->createArticle($article);
    }

    public function testShouldUpdateExistingArticleAndRespondWithUpdatedInstance(): void
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

    public function testShouldUpdateExistingArticleAndRespondWithoutInstance(): void
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

    public function testShouldUpdateExistingArticleViewCount(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->updateViewCount(uniqid('', true));
    }

    public function testShouldDeleteExistingArticle(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteArticle(uniqid('', true));
    }

    public function testShouldSaveExistingArticleDraft(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->saveArticleDraft(uniqid('', true), "Draft text");
    }

    public function testShouldDeleteExistingArticleDraft(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteArticleDraft(uniqid('', true));
    }

    public function testShouldReturnArticlesForCategory(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticlesForCategory(uniqid('', true));

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }

    public function testShouldReturnArticlesForCollection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticlesForCollection(uniqid('', true));

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }
}
