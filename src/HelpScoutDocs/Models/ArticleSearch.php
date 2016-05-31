<?php

namespace HelpScoutDocs\Models;

class ArticleSearch extends DocsModel {

    private $id;
    private $collectionId;
    private $categoryIds;
    private $slug;
    private $name;
    private $preview;
    private $url;
    private $docsUrl;
    private $number;
    private $status;
    private $visibility;

    function __construct($data = null) {
        if ($data) {
            $this->id           = isset($data->id)           ? $data->id           : null;
            $this->collectionId = isset($data->collectionId) ? $data->collectionId : null;
            $this->categoryIds  = isset($data->categoryIds)  ? $data->categoryIds  : null;
            $this->slug         = isset($data->slug)         ? $data->slug         : null;
            $this->name         = isset($data->name)         ? $data->name         : null;
            $this->preview      = isset($data->preview)      ? $data->preview      : null;
            $this->url          = isset($data->url)          ? $data->url          : null;
            $this->docsUrl      = isset($data->docsUrl)      ? $data->docsUrl      : null;
            $this->number       = isset($data->number)       ? $data->number       : null;
            $this->status       = isset($data->status)       ? $data->status       : null;
            $this->visibility   = isset($data->visibility)   ? $data->visibility   : null;
        }
    }

    /**
     * @param mixed $categoryIds
     */
    public function setCategoryIds($categoryIds)
    {
        $this->categoryIds = $categoryIds;
    }

    /**
     * @return mixed
     */
    public function getCategoryIds()
    {
        return $this->categoryIds;
    }

    /**
     * @param mixed $collectionId
     */
    public function setCollectionId($collectionId)
    {
        $this->collectionId = $collectionId;
    }

    /**
     * @return mixed
     */
    public function getCollectionId()
    {
        return $this->collectionId;
    }

    /**
     * @param mixed $docsUrl
     */
    public function setDocsUrl($docsUrl)
    {
        $this->docsUrl = $docsUrl;
    }

    /**
     * @return mixed
     */
    public function getDocsUrl()
    {
        return $this->docsUrl;
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

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $preview
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;
    }

    /**
     * @return mixed
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }
}