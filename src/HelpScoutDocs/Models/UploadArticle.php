<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

class UploadArticle extends DocsModel
{
    public const UPLOAD_TYPE_HTML = 'html';
    public const UPLOAD_TYPE_TEXT = 'text';
    public const UPLOAD_TYPE_MARKDOWN = 'markdown';

    private ?string $collectionId = null;
    private ?string $name = null;
    private ?string $slug = null;
    private ?string $categoryId = null;
    private ?string $file = null;
    private ?string $type = null;

    public function getCollectionId(): ?string
    {
        return $this->collectionId;
    }

    public function setCollectionId(string $collectionId): void
    {
        $this->collectionId = $collectionId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
