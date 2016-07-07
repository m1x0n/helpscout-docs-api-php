<?php

namespace HelpScoutDocs\Models;

class UploadArticle extends DocsModel
{
    const UPLOAD_TYPE_HTML = 'html';
    const UPLOAD_TYPE_TEXT = 'text';
    const UPLOAD_TYPE_MARKDOWN = 'markdown';

    /**
     * @var string
     */
    private $collectionId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $categoryId;

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $type;

    /**
     * @return string
     */
    public function getCollectionId()
    {
        return $this->collectionId;
    }

    /**
     * @param string $collectionId
     */
    public function setCollectionId($collectionId)
    {
        $this->collectionId = $collectionId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param string $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}