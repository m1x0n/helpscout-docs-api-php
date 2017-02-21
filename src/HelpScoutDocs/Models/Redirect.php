<?php

namespace HelpScoutDocs\Models;

class Redirect extends DocsModel
{
    const REDIRECT_TYPE_ARTICLE = 'article';
    const REDIRECT_TYPE_CATEGORY = 'category';
    const REDIRECT_TYPE_COLLECTION = 'collection';
    const REDIRECT_TYPE_CUSTOM = 'custom';

    private $id;
    private $siteId;
    private $urlMapping;
    private $type;
    private $documentId;
    private $anchor;
    private $redirect;
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id = isset($data->id) ? $data->id : null;
            $this->siteId = isset($data->siteId) ? $data->siteId : null;
            $this->urlMapping = isset($data->urlMapping) ? $data->urlMapping : null;
            $this->type = isset($data->type) ? $data->type : null;
            $this->documentId = isset($data->documentId) ? $data->documentId : null;
            $this->anchor = isset($data->anchor) ? $data->anchor : null;
            $this->redirect = isset($data->redirect) ? $data->redirect : null;
            $this->createdBy = isset($data->createdBy) ? $data->createdBy : null;
            $this->updatedBy = isset($data->updatedBy) ? $data->updatedBy : null;
            $this->createdAt = isset($data->createdAt) ? $data->createdAt : null;
            $this->createdBy = isset($data->updatedAt) ? $data->updatedAt : null;
        }
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSiteId()
    {
        return $this->siteId;
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
    public function getUrlMapping()
    {
        return $this->urlMapping;
    }

    /**
     * @param mixed $urlMapping
     */
    public function setUrlMapping($urlMapping)
    {
        $this->urlMapping = $urlMapping;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * @param mixed $documentId
     */
    public function setDocumentId($documentId)
    {
        $this->documentId = $documentId;
    }

    /**
     * @return mixed
     */
    public function getAnchor()
    {
        return $this->anchor;
    }

    /**
     * @param mixed $anchor
     */
    public function setAnchor($anchor)
    {
        $this->anchor = $anchor;
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param mixed $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
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
    public function getUpdatedBy()
    {
        return $this->updatedBy;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
