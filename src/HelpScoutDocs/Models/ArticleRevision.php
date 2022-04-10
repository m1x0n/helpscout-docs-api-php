<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

class ArticleRevision extends ArticleRevisionRef
{
    private ?string $text = null;

    public function __construct(\stdClass $data = null)
    {
        if ($data) {
            parent::__construct($data);
            $this->text = $data->text ?? null;
        }
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
