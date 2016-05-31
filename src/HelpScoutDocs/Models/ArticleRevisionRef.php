<?php

namespace HelpScoutDocs\Models;

class ArticleRevisionRef extends DocsModel {

    private $id;
    private $articleId;
    private $createdBy;
    private $createdAt;

    function __construct($data = null) {
        if ($data) {
            $this->id        = isset($data->id)        ? $data->id                    : null;
            $this->articleId = isset($data->articleId) ? $data->articleId             : null;
            $this->createdBy = isset($data->createdBy) ? new Person($data->createdBy) : null;
            $this->createdAt = isset($data->createdAt) ? $data->createdAt             : null;
        }
    }

    /**
     * @param mixed $articleId
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    }

    /**
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}