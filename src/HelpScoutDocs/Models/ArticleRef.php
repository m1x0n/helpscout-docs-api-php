<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

use stdClass;

class ArticleRef extends DocsModel
{
    private ?string $id = null;
    private int $number = 0;
    private ?string $collectionId = null;
    private ?string $slug = null;
    private ?string $status = null;
    private bool $hasDraft = false;
    private ?string $name = null;
    private ?string $publicUrl = null;
    private float $popularity = 0;
    private int $viewCount = 0;
    private ?int $createdBy = null;
    private ?int $updatedBy = null;
    private ?string $createdAt = null;
    private ?string $updatedAt= null;
    private ?string $lastPublishedAt = null;

    public function __construct(stdClass $data = null)
    {
        if ($data) {
            $this->id = $data->id ?? null;
            $this->number = $data->number ?? 0;
            $this->collectionId = $data->collectionId ?? null;
            $this->slug = $data->slug ?? null;
            $this->status = $data->status ?? null;
            $this->hasDraft = $data->hasDraft ?? false;
            $this->name = $data->name ?? null;
            $this->publicUrl = $data->publicUrl ?? null;
            $this->popularity = $data->popularity ?? 0;
            $this->viewCount = $data->viewCount ?? 0;
            $this->createdBy = $data->createdBy ?? null;
            $this->updatedBy = $data->updatedBy ?? null;
            $this->createdAt = $data->createdAt ?? null;
            $this->createdBy = $data->updatedAt ?? null;
            $this->lastPublishedAt = $data->lastPublishedAt ?? null;
        }
    }

    public function setCollectionId(string $collectionId): void
    {
        $this->collectionId = $collectionId;
    }

    public function getCollectionId(): ?string
    {
        return $this->collectionId;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedBy(int $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setHasDraft(bool $hasDraft): void
    {
        $this->hasDraft = $hasDraft;
    }

    public function getHasDraft(): bool
    {
        return $this->hasDraft;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setLastPublishedAt(string $lastPublishedAt): void
    {
        $this->lastPublishedAt = $lastPublishedAt;
    }

    public function getLastPublishedAt(): ?string
    {
        return $this->lastPublishedAt;
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

    public function setPopularity(float $popularity): void
    {
        $this->popularity = $popularity;
    }

    public function getPopularity(): float
    {
        return $this->popularity;
    }

    public function setPublicUrl(string $publicUrl): void
    {
        $this->publicUrl = $publicUrl;
    }


    public function getPublicUrl(): ?string
    {
        return $this->publicUrl;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): ?string
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

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedBy(int $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function setViewCount(int $viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    public function getViewCount(): ?int
    {
        return $this->viewCount;
    }
}
