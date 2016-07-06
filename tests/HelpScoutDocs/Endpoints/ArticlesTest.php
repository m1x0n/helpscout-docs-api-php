<?php

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\Models\Article;
use HelpScoutDocs\Models\UploadArticle;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class ArticlesTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_articles_collection()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/articles/articles.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $articles = $apiClient->getArticles(uniqid());

        $this->assertInstanceOf(ResourceCollection::class, $articles);
    }

    /**
     * @test
     * @expectedException \HelpScoutDocs\ApiException
     */
    public function should_throw_an_exception_on_invalid_file()
    {
        $responseMock = $this->createResponseMock(201, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $article = new UploadArticle();

        $apiClient->uploadArticle($article);
    }

    /**
     *
     */
    public function should_upload_an_article()
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
    public function should_upload_an_article_and_respond_with_article_instance()
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
}