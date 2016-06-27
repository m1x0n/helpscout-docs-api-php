<?php

namespace HelpScoutDocs\Models;

class ArticleAsset
{
    const ARTICLE_ASSET_IMAGE = 'image';
    const ARTICLE_ASSET_ATTACHMENT = 'attachment';

    /**
     * @var string
     */
    private $articleId;

    /**
     * @var string
     */
    private $assetType;

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $fileLink;

    /**
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->articleId;
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
    public function getAssetType()
    {
        return $this->assetType;
    }

    /**
     * @param mixed $assetType
     */
    public function setAssetType($assetType)
    {
        $this->assetType = $assetType;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
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
    public function getFileLink()
    {
        return $this->fileLink;
    }

    /**
     * @param string $fileLink
     */
    public function setFileLink($fileLink)
    {
        $this->fileLink = $fileLink;
    }
}