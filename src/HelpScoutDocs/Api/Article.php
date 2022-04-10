<?php

declare(strict_types=1);

namespace HelpScoutDocs\Api;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;
use RuntimeException;

class Article extends AbstractApi
{
    public const DEFAULT_PAGE_SIZE = 50;

    public function all(
        string $categoryId,
        int $page = 1,
        string $status = 'all',
        string $sort = 'order',
        string $order = 'asc',
        int $pageSize = self::DEFAULT_PAGE_SIZE
    ): ResourceCollection {
        return $this->allForCategory(
            $categoryId,
            $page,
            $status,
            $sort,
            $order,
            $pageSize
        );
    }

    public function allForCategory(
        string $categoryId,
        int $page = 1,
        string $status = 'all',
        string $sort = 'order',
        string $order = 'asc',
        int $pageSize = self::DEFAULT_PAGE_SIZE
    ): ResourceCollection {
        $params = [
            'page'   => $page,
            'sort'   => $sort,
            'order'  => $order,
            'pageSize' => $pageSize
        ];

        if ($status !== 'all') {
            $params['status'] = $status;
        }

        return $this->getResourceCollection(
            sprintf("categories/%s/articles", $categoryId),
            $this->getParams($params),
            Models\ArticleRef::class
        );
    }

    public function allForCollection(
        string $collectionId,
        int $page = 1,
        string $status = 'all',
        string $sort = 'order',
        string $order = 'asc',
        int $pageSize = self::DEFAULT_PAGE_SIZE
    ): ResourceCollection {
        $params = [
            'page'   => $page,
            'sort'   => $sort,
            'order'  => $order,
            'pageSize' => $pageSize
        ];

        if ($status !== 'all') {
            $params['status'] = $status;
        }

        return $this->getResourceCollection(
            sprintf("collections/%s/articles", $collectionId),
            $this->getParams($params),
            Models\ArticleRef::class
        );
    }

    public function search(
        string $query = '*',
        int $page = 1,
        string $collectionId = '',
        string $status = 'all',
        string $visibility = 'all'
    ): ResourceCollection {
        $params = [
            'query'        => $query,
            'page'         => $page,
            'collectionId' => $collectionId,
            'visibility'   => $visibility
        ];

        if ($status !== 'all') {
            $params['status'] = $status;
        }

        return $this->getResourceCollection(
            "search/articles",
            $this->getParams($params),
            Models\ArticleSearch::class
        );
    }

    public function relatedArticles(
        string $articleId,
        int $page = 1,
        string $status = 'all',
        string $sort = 'order',
        string $order = 'desc'
    ): ResourceCollection {
        $params = [
            'page'   => $page,
            'sort'   => $sort,
            'order'  => $order
        ];

        if ($status !== 'all') {
            $params['status'] = $status;
        }

        return $this->getResourceCollection(
            sprintf("articles/%s/related", $articleId),
            $this->getParams($params),
            Models\ArticleRef::class
        );
    }

    public function revisions(string $articleId, int $page = 1): ResourceCollection
    {
        $params = ['page' => $page];

        return $this->getResourceCollection(
            sprintf("articles/%s/revisions", $articleId),
            $this->getParams($params),
            Models\ArticleRevisionRef::class
        );
    }

    public function show(string $articleIdOrNumber, bool $draft = false): Models\Article
    {
        $params = ['draft' => $draft];

        /** @var Models\Article $item */
        $item = $this->getItem(
            sprintf("articles/%s", $articleIdOrNumber),
            $this->getParams($params),
            Models\Article::class
        );

        return $item;
    }

    public function revision(string $revisionId): Models\ArticleRevision
    {
        /** @var Models\ArticleRevision $item */
        $item = $this->getItem(
            sprintf("revisions/%s", $revisionId),
            array(),
            Models\ArticleRevision::class
        );

        return $item;
    }

    public function create(Models\Article $article, bool $reload = true): Models\Article
    {
        $url = "articles";

        $requestBody = $article->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        [$id, $response] = $this->post($url, $requestBody);

        if ($reload) {
            $articleData = (array)$response;
            $articleData = reset($articleData);
            return new Models\Article($articleData);
        }
        $article->setId($id);
        return $article;
    }

    public function createArticle(Models\Article $article): void
    {
        $requestBody = $article->toArray();

        $this->post("articles", $requestBody);
    }

    public function createArticleAndReturnCreated(Models\Article $article): Models\Article
    {
        $requestBody = $article->toArray();
        $requestBody['reload'] = true;

        [, $response] = $this->post("articles", $requestBody);

        $articleData = (array)$response;
        $articleData = reset($articleData);

        return new Models\Article($articleData);
    }

    public function updateArticle(Models\Article $article): void
    {
        $url = sprintf("articles/%s", $article->getId());

        $requestBody = $article->toArray();

        $this->put($url, $requestBody);
    }

    public function updateArticleAndReturnUpdated(Models\Article $article): Models\Article
    {
        $url = sprintf("articles/%s", $article->getId());

        $requestBody = $article->toArray();
        $requestBody['reload'] = true;

        $response = $this->put($url, $requestBody);

        $articleData = (array)$response;
        $articleData = reset($articleData);
        return new Models\Article($articleData);
    }

    public function uploadArticle(Models\UploadArticle $uploadArticle): void
    {
        if ($uploadArticle->getFile() === null) {
            throw new RuntimeException('No file path provided for Article::uploadArticle()');
        }

        if (!file_exists($uploadArticle->getFile())) {
            throw new ApiException(sprintf("Unable to locate file: %s", $uploadArticle->getFile()));
        }

        $multipart = [
            [
                'name' => 'key',
                'contents' => $this->client->getApiKey()
            ],
            [
                'name' => 'collectionId',
                'contents' => $uploadArticle->getCollectionId()
            ],
            [
                'name' => 'file',
                'contents' => fopen($uploadArticle->getFile(), 'rb')
            ],
            [
                'name' => 'categoryId',
                'contents' => $uploadArticle->getCategoryId()
            ],
            [
                'name' => 'slug',
                'contents' => $uploadArticle->getSlug()
            ],
            [
                'name' => 'type',
                'contents' => $uploadArticle->getType()
            ],
            [
                'name' => 'name',
                'contents' => $uploadArticle->getName()
            ],
            [
                'name' => 'reload',
                'contents' => false
            ]
        ];

        $this->postMultipart("articles/upload", $multipart);
    }

    public function uploadArticleAndReturnUploaded(Models\UploadArticle $uploadArticle): Models\Article
    {
        if ($uploadArticle->getFile() === null) {
            throw new RuntimeException('No file path provided for Article::uploadArticleAndReturnUploaded()');
        }

        if (!file_exists($uploadArticle->getFile())) {
            throw new ApiException(sprintf("Unable to locate file: %s", $uploadArticle->getFile()));
        }

        $multipart = [
            [
                'name' => 'key',
                'contents' => $this->client->getApiKey()
            ],
            [
                'name' => 'collectionId',
                'contents' => $uploadArticle->getCollectionId()
            ],
            [
                'name' => 'file',
                'contents' => fopen($uploadArticle->getFile(), 'rb')
            ],
            [
                'name' => 'categoryId',
                'contents' => $uploadArticle->getCategoryId()
            ],
            [
                'name' => 'name',
                'contents' => $uploadArticle->getName()
            ],
            [
                'name' => 'slug',
                'contents' => $uploadArticle->getSlug()
            ],
            [
                'name' => 'type',
                'contents' => $uploadArticle->getType()
            ],
            [
                'name' => 'name',
                'contents' => $uploadArticle->getName()
            ],
            [
                'name' => 'reload',
                'contents' => true
            ]
        ];

        $response = $this->postMultipart("articles/upload", $multipart);

        $articleData = (array)$response;

        return new Models\Article(reset($articleData));
    }

    public function updateViewCount(string $articleId, int $count = 1): void
    {
        $this->put(
            sprintf("articles/%s/views", $articleId),
            ['count' => $count]
        );
    }

    public function remove(string $articleId): void
    {
        $this->delete(sprintf("articles/%s", $articleId));
    }

    public function saveDraft(string $articleId, string $text): void
    {
        $this->put(
            sprintf("articles/%s/drafts", $articleId),
            ['text' => $text]
        );
    }

    public function removeDraft(string $articleId): void
    {
        $this->delete(sprintf("articles/%s/drafts", $articleId));
    }
}
