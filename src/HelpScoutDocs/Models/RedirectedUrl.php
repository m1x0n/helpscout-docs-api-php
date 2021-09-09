<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

use stdClass;

class RedirectedUrl extends DocsModel
{
    private ?string $type = null;
    private ?string $redirect = null;
    private ?string $slug = null;
    private ?int $number;
    private ?string $anchor = null;

    public function __construct(stdClass $data = null)
    {
        if ($data) {
            $this->type = $data->type ?? null;
            $this->redirect = $data->redirect ?? null;
            $this->slug = $data->slug ?? null;
            $this->number = $data->number ?? null;
            $this->anchor = $data->anchor ?? null;
        }
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getRedirect(): ?string
    {
        return $this->redirect;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getAnchor(): ?string
    {
        return $this->anchor;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }
}
