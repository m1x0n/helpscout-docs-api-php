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
        $redirect = null;

        if ($data && property_exists($data, 'redirect')) {
            $redirect = $data->redirect;
        }
        
        if ($redirect) {
            $this->id = $redirect->id ?? null;
            $this->siteId = $redirect->siteId ?? null;
            $this->urlMapping = $redirect->urlMapping ?? null;
            $this->type = $redirect->type ?? null;
            $this->documentId = $redirect->documentId ?? null;
            $this->anchor = $redirect->anchor ?? null;
            $this->redirect = $redirect->redirect ?? null;
            $this->createdBy = $redirect->createdBy ?? null;
            $this->updatedBy = $redirect->updatedBy ?? null;
            $this->createdAt = $redirect->createdAt ?? null;
            $this->updatedAt = $redirect->updatedAt ?? null;
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
