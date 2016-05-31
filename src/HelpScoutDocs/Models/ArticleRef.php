<?php

namespace HelpScoutDocs\Models;

class ArticleRef extends DocsModel {

    private $id;
    private $number;
    private $collectionId;
    private $slug;
    private $status;
    private $hasDraft;
    private $name;
    private $publicUrl;
    private $popularity;
    private $viewCount;
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;
    private $lastPublishedAt;

    function __construct($data = null) {
        if ($data) {
            $this->id              = isset($data->id)              ? $data->id              : null;
            $this->number          = isset($data->number)          ? $data->number          : null;
            $this->getCollectionId = isset($data->collectionId)    ? $data->collectionId    : null;
            $this->slug            = isset($data->slug)            ? $data->slug            : null;
            $this->status          = isset($data->status)          ? $data->status          : null;
            $this->hasDraft        = isset($data->hasDraft)        ? $data->hasDraft        : null;
            $this->name            = isset($data->name)            ? $data->name            : null;
            $this->publicUrl       = isset($data->publicUrl)       ? $data->publicUrl       : null;
            $this->popularity      = isset($data->popularity)      ? $data->popularity      : null;
            $this->viewCount       = isset($data->viewCount)       ? $data->viewCount       : null;
            $this->createdBy       = isset($data->createdBy)       ? $data->createdBy       : null;
            $this->updatedBy       = isset($data->updatedBy)       ? $data->updatedBy       : null;
            $this->createdAt       = isset($data->createdAt)       ? $data->createdAt       : null;
            $this->createdBy       = isset($data->updatedAt)       ? $data->updatedAt       : null;
            $this->lastPublishedAt = isset($data->lastPublishedAt) ? $data->lastPublishedAt : null;
        }
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
     * @param mixed $hasDraft
     */
    public function setHasDraft($hasDraft)
    {
        $this->hasDraft = $hasDraft;
    }

    /**
     * @return mixed
     */
    public function getHasDraft()
    {
        return $this->hasDraft;
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
     * @param mixed $lastPublishedAt
     */
    public function setLastPublishedAt($lastPublishedAt)
    {
        $this->lastPublishedAt = $lastPublishedAt;
    }

    /**
     * @return mixed
     */
    public function getLastPublishedAt()
    {
        return $this->lastPublishedAt;
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
     * @param mixed $popularity
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;
    }

    /**
     * @return mixed
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * @param mixed $publicUrl
     */
    public function setPublicUrl($publicUrl)
    {
        $this->publicUrl = $publicUrl;
    }

    /**
     * @return mixed
     */
    public function getPublicUrl()
    {
        return $this->publicUrl;
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
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $viewCount
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
    }

    /**
     * @return mixed
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }


}