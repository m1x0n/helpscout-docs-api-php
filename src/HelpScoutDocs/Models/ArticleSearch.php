<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

use stdClass;

class ArticleSearch extends DocsModel
{
    private ?string $id = null;
    private ?string $collectionId = null;
    private ?array $categoryIds = null;
    private ?string $slug = null;
    private ?string $name = null;
    private ?string $preview = null;
    private ?string $url;
    private ?string $docsUrl;
    private ?int $number = 0;
    private ?string $status = null;
    private ?string $visibility = null;

    public function __construct(stdClass $data = null)
    {
        if ($data) {
            $this->id           = $data->id ?? null;
            $this->collectionId = $data->collectionId ?? null;
            $this->categoryIds  = $data->categoryIds ?? null;
            $this->slug         = $data->slug ?? null;
            $this->name         = $data->name ?? null;
            $this->preview      = $data->preview ?? null;
            $this->url          = $data->url ?? null;
            $this->docsUrl      = $data->docsUrl ?? null;
            $this->number       = $data->number ?? null;
            $this->status       = $data->status ?? null;
            $this->visibility   = $data->visibility ?? null;
        }
    }

    public function setCategoryIds(array $categoryIds): void
    {
        $this->categoryIds = $categoryIds;
    }

    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }

    public function setCollectionId(string $collectionId): void
    {
        $this->collectionId = $collectionId;
    }

    public function getCollectionId(): ?string
    {
        return $this->collectionId;
    }

    public function setDocsUrl(string $docsUrl): void
    {
        $this->docsUrl = $docsUrl;
    }

    public function getDocsUrl(): ?string
    {
        return $this->docsUrl;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }


    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setPreview(string $preview): void
    {
        $this->preview = $preview;
    }

    public function getPreview(): ?string
    {
        return $this->preview;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }
}
