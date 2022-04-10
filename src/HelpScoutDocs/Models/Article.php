<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

use stdClass;

class Article extends ArticleRef
{
    public const ARTICLE_STATUS_PUBLISHED = 'published';
    public const ARTICLE_STATUS_NOT_PUBLISHED = 'notpublished';

    private ?string $text = null;
    private ?string $code = null;
    /**
     * @var array|null|string[]
     */
    private ?array $categories = null;
    /**
     * @var array|null|string[]
     */
    private ?array $related = null;

    public function __construct(?stdClass $data = null)
    {
        if ($data) {
            parent::__construct($data);

            $this->text       = $data->text ?? null;
            $this->code       = $data->code ?? null;
            $this->categories = $data->categories ?? null;
            $this->related    = $data->related ?? null;
        }
    }

    /**
     * @param array|string[] $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return array|string[]|null
     */
    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param array|string[] $related
     */
    public function setRelated(array $related): void
    {
        $this->related = $related;
    }

    /**
     * @return array|string[]|null
     */
    public function getRelated(): ?array
    {
        return $this->related;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getText(): ?string
    {
        return $this->text;
    }
}
