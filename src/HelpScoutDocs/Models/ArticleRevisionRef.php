<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

class ArticleRevisionRef extends DocsModel
{
    private ?string $id = null;
    private ?string $articleId = null;
    private ?Person $createdBy = null;
    private ?string $createdAt = null;

    public function __construct($data = null)
    {
        if ($data) {
            $this->id        = $data->id ?? null;
            $this->articleId = $data->articleId ?? null;
            $this->createdBy = property_exists($data, 'createdBy') && $data->createdBy !== null
                ? new Person($data->createdBy)
                : null;
            $this->createdAt = $data->createdAt ?? null;
        }
    }

    public function setArticleId(string $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function getArticleId(): ?string
    {
        return $this->articleId;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedBy(Person $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getCreatedBy(): ?Person
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
}
