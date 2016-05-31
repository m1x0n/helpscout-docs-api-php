<?php

namespace HelpScoutDocs\Models;

class Category extends DocsModel {

    private $id;
    private $number;
    private $slug;
    private $collectionId;
    private $order;
    private $name;
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    function __construct($data = null) {
        if ($data) {
            $this->id           = isset($data->id)           ? $data->id           : null;
            $this->number       = isset($data->number)       ? $data->number       : null;
            $this->slug         = isset($data->slug)         ? $data->slug         : null;
            $this->collectionId = isset($data->collectionId) ? $data->collectionId : null;
            $this->order        = isset($data->order)        ? $data->order        : null;
            $this->name         = isset($data->name)         ? $data->name         : null;
            $this->createdBy    = isset($data->createdBy)    ? $data->createdBy    : null;
            $this->updatedBy    = isset($data->updatedBy)    ? $data->updatedBy    : null;
            $this->createdAt    = isset($data->createdAt)    ? $data->createdAt    : null;
            $this->createdBy    = isset($data->updatedAt)    ? $data->updatedAt    : null;
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
}