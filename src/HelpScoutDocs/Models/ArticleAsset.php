<?php
declare(strict_types=1);

namespace HelpScoutDocs\Models;

class ArticleAsset
{
    public const ARTICLE_ASSET_IMAGE = 'image';
    public const ARTICLE_ASSET_ATTACHMENT = 'attachment';

    private ?string $articleId = null;
    private ?string $assetType = null;
    private ?string $file = null;
    private ?string $fileName = null;
    private ?string $fileLink = null;

    public function getArticleId(): ?string
    {
        return $this->articleId;
    }

    public function setArticleId(string $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function getAssetType(): ?string
    {
        return $this->assetType;
    }

    public function setAssetType(string $assetType): void
    {
        $this->assetType = $assetType;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    public function getFileLink(): ?string
    {
        return $this->fileLink;
    }

    public function setFileLink(string $fileLink): void
    {
        $this->fileLink = $fileLink;
    }
}
