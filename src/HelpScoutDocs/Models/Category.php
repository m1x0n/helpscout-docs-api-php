<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

use stdClass;

class Category extends DocsModel
{
    private ?string $id = null;
    private ?int $number = 0;
    private ?string $slug = null;
    private ?string $collectionId = null;
    private ?int $order = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?int $createdBy = null;
    private ?int $updatedBy = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    public function __construct(stdClass $data = null)
    {
        if ($data) {
            $this->id           = $data->id ?? null;
            $this->number       = $data->number ?? null;
            $this->slug         = $data->slug ?? null;
            $this->collectionId = $data->collectionId ?? null;
            $this->order        = $data->order ?? null;
            $this->name         = $data->name ?? null;
            $this->description  = $data->description ?? null;
            $this->createdBy    = $data->createdBy ?? null;
            $this->updatedBy    = $data->updatedBy ?? null;
            $this->createdAt    = $data->createdAt ?? null;
            $this->updatedAt    = $data->updatedAt ?? null;
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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
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
}
