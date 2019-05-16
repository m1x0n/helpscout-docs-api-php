<?php

namespace HelpScoutDocs\Api;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models;
use HelpScoutDocs\ResourceCollection;

class Article extends AbstractApi
{
    const DEFAULT_PAGE_SIZE = 50;

    /**
     * @param $categoryId
     * @param int $page
     * @param string $status
     * @param string $sort
     * @param string $order
     * @param int $pageSize
     * @return bool|ResourceCollection
     * @throws ApiException
     */
    public function all(
        $categoryId,
        $page = 1,
        $status = 'all',
        $sort = 'order',
        $order = 'asc',
        $pageSize = self::DEFAULT_PAGE_SIZE
    ) {
        $params = [
            'page'   => $page,
            'status' => $status,
            'sort'   => $sort,
            'order'  => $order,
            'pageSize' => $pageSize
        ];

        return $this->getResourceCollection(
            sprintf("categories/%s/articles", $categoryId),
            $this->getParams($params),
            Models\ArticleRef::class
        );
    }

    /**
     * @param string $query
     * @param int $page
     * @param string $collectionId
     * @param string $status
     * @param string $visibility
     * @return bool|ResourceCollection
     */
    public function search($query = '*', $page = 1, $collectionId = '', $status = 'all', $visibility = 'all')
    {
        $params = [
            'query'        => $query,
            'page'         => $page,
            'collectionId' => $collectionId,
            'status'       => $status,
            'visibility'   => $visibility
        ];

        return $this->getResourceCollection(
            "search/articles",
            $this->getParams($params),
            Models\ArticleSearch::class
        );
    }

    /**
     * @param $articleId
     * @param int $page
     * @param string $status
     * @param string $sort
     * @param string $order
     * @return bool|ResourceCollection
     */
    public function relatedArticles($articleId, $page = 1, $status = 'all', $sort = 'order', $order = 'desc')
    {
        $params = [
            'page'   => $page,
            'status' => $status,
            'sort'   => $sort,
            'order'  => $order
        ];

        return $this->getResourceCollection(
            sprintf("articles/%s/related", $articleId),
            $this->getParams($params),
            Models\ArticleRef::class
        );
    }

    /**
     * @param $articleId
     * @param int $page
     * @return bool|ResourceCollection
     */
    public function revisions($articleId, $page = 1)
    {
        $params = ['page' => $page];

        return $this->getResourceCollection(
            sprintf("articles/%s/revisions", $articleId),
            $this->getParams($params),
            Models\ArticleRevisionRef::class
        );
    }

    /**
     * @param $articleIdOrNumber
     * @param bool $draft
     * @return bool|Models\Article
     */
    public function show($articleIdOrNumber, $draft = false)
    {
        $params = ['draft' => $draft];

        return $this->getItem(
            sprintf("articles/%s", $articleIdOrNumber),
            $this->getParams($params),
            Models\Article::class
        );
    }

    /**
     * @param $revisionId
     * @return bool|Models\ArticleRevision
     */
    public function revision($revisionId)
    {
        return $this->getItem(
            sprintf("revisions/%s", $revisionId),
            array(),
            Models\ArticleRevision::class
        );
    }

    /**
     * @param Models\Article $article
     * @param bool $reload
     * @return bool|Models\Article
     * @throws ApiException
     */
    public function create(Models\Article $article, $reload = true)
    {
        $url = "articles";

        $requestBody = $article->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        list($id, $response) = $this->post($url, $requestBody);

        if ($reload) {
            $articleData = (array)$response;
            $articleData = reset($articleData);
            return new Models\Article($articleData);
        } else {
            $article->setId($id);
            return $article;
        }
    }

    /**
     * @param Models\Article $article
     * @param bool $reload
     * @return Models\Article
     * @throws ApiException
     */
    public function update(Models\Article $article, $reload = false)
    {
        $url = sprintf("articles/%s", $article->getId());

        $requestBody = $article->toArray();

        if ($reload) {
            $requestBody['reload'] = true;
        }

        $response = $this->put($url, $requestBody);

        if ($reload) {
            $articleData = (array)$response;
            $articleData = reset($articleData);
            return new Models\Article($articleData);
        } else {
            return $article;
        }
    }

    /**
     * @param Models\UploadArticle $uploadArticle
     * @param bool $reload
     * @return bool|Models\Article
     * @throws ApiException
     */
    public function upload(Models\UploadArticle $uploadArticle, $reload = false)
    {
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
                'contents' => fopen($uploadArticle->getFile(), 'r')
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
                'name' => 'reload',
                'contents' => $reload
            ]
        ];

        $response = $this->postMultipart("articles/upload", $multipart);

        $articleData = (array)$response;

        return $reload ? new Models\Article(reset($articleData)) : true;
    }

    /**
     * @param $articleId
     * @param int $count
     */
    public function updateViewCount($articleId, $count = 1)
    {
        $this->put(
            sprintf("articles/%s/views", $articleId),
            ['count' => $count]
        );
    }

    /**
     * @param $articleId
     */
    public function remove($articleId)
    {
        $this->delete(sprintf("articles/%s", $articleId));
    }

    /**
     * @param $articleId
     * @param $text
     */
    public function saveDraft($articleId, $text)
    {
        $this->put(
            sprintf("articles/%s/drafts", $articleId),
            ['text' => $text]
        );
    }

    /**
     * @param $articleId
     */
    public function removeDraft($articleId)
    {
        $this->delete(sprintf("articles/%s/drafts", $articleId));
    }
}
