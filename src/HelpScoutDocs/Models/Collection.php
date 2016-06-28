<?php

namespace HelpScoutDocs\Models;

class Collection extends DocsModel {

    const COLLECTION_VISIBILITY_PUBLIC = 'public';
    const COLLECTION_VISIBILITY_PRIVATE = 'private';
    
    private $id;
    private $number;
    private $siteId;
    private $slug;
    private $visibility;
    private $order;
    private $name;
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    function __construct($data = null) {
        if ($data) {
            $this->id         = isset($data->id)         ? $data->id         : null;
            $this->number     = isset($data->number)     ? $data->number     : null;
            $this->siteId     = isset($data->siteId)     ? $data->siteId     : null;
            $this->slug       = isset($data->slug)       ? $data->slug       : null;
            $this->visibility = isset($data->visibility) ? $data->visibility : null;
            $this->order      = isset($data->order)      ? $data->order      : null;
            $this->name       = isset($data->name)       ? $data->name       : null;
            $this->createdBy  = isset($data->createdBy)  ? $data->createdBy  : null;
            $this->updatedBy  = isset($data->updatedBy)  ? $data->updatedBy  : null;
            $this->createdAt  = isset($data->createdAt)  ? $data->createdAt  : null;
            $this->createdBy  = isset($data->updatedAt)  ? $data->updatedAt  : null;
        }
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
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $siteId
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }

    /**
     * @return mixed
     */
    public function getSiteId()
    {
        return $this->siteId;
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