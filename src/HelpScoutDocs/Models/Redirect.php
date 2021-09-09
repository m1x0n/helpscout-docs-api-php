<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

use stdClass;

class Redirect extends DocsModel
{
    public const REDIRECT_TYPE_ARTICLE = 'article';
    public const REDIRECT_TYPE_CATEGORY = 'category';
    public const REDIRECT_TYPE_COLLECTION = 'collection';
    public const REDIRECT_TYPE_CUSTOM = 'custom';

    private ?string $id = null;
    private ?string $siteId = null;
    private ?string $urlMapping = null;
    private ?string $type = null;
    private ?string $documentId = null;
    private ?string $anchor = null;
    private ?string $redirect = null;
    private ?int $createdBy = null;
    private ?int $updatedBy = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    public function __construct(stdClass $data = null)
    {
        if ($data) {
            $this->id = $data->id ?? null;
            $this->siteId = $data->siteId ?? null;
            $this->urlMapping = $data->urlMapping ?? null;
            $this->type = $data->type ?? null;
            $this->documentId = $data->documentId ?? null;
            $this->anchor = $data->anchor ?? null;
            $this->redirect = $data->redirect ?? null;
            $this->createdBy = $data->createdBy ?? null;
            $this->updatedBy = $data->updatedBy ?? null;
            $this->createdAt = $data->createdAt ?? null;
            $this->createdBy = $data->updatedAt ?? null;
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getSiteId(): ?string
    {
        return $this->siteId;
    }

    public function setSiteId(string $siteId): void
    {
        $this->siteId = $siteId;
    }

    public function getUrlMapping(): ?string
    {
        return $this->urlMapping;
    }

    public function setUrlMapping(string $urlMapping): void
    {
        $this->urlMapping = $urlMapping;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getDocumentId(): ?string
    {
        return $this->documentId;
    }

    public function setDocumentId(string $documentId): void
    {
        $this->documentId = $documentId;
    }

    public function getAnchor(): ?string
    {
        return $this->anchor;
    }

    public function setAnchor(string $anchor): void
    {
        $this->anchor = $anchor;
    }

    public function getRedirect(): ?string
    {
        return $this->redirect;
    }

    public function setRedirect(string $redirect): void
    {
        $this->redirect = $redirect;
    }

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(int $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(int $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
