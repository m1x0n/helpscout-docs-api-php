<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

use stdClass;

class Collection extends DocsModel
{
    public const COLLECTION_VISIBILITY_PUBLIC = 'public';
    public const COLLECTION_VISIBILITY_PRIVATE = 'private';

    private ?string $id = null;
    private int $number = 0;
    private ?string $siteId = null;
    private ?string $slug = null;
    private ?string $visibility = null;
    private ?int $order = null;
    private ?string $name = null;
    private ?int $createdBy = null;
    private ?int $updatedBy = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    public function __construct(stdClass $data = null)
    {
        if ($data) {
            $this->id         = $data->id ?? null;
            $this->number     = $data->number ?? 0;
            $this->siteId     = $data->siteId ?? null;
            $this->slug       = $data->slug ?? null;
            $this->visibility = $data->visibility ?? null;
            $this->order      = $data->order ?? null;
            $this->name       = $data->name ?? null;
            $this->createdBy  = $data->createdBy ?? null;
            $this->updatedBy  = $data->updatedBy ?? null;
            $this->createdAt  = $data->createdAt ?? null;
            $this->updatedAt  = $data->updatedAt ?? null;
        }
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

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setSiteId(string $siteId): void
    {
        $this->siteId = $siteId;
    }

    public function getSiteId(): ?string
    {
        return $this->siteId;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
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

    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }
}
