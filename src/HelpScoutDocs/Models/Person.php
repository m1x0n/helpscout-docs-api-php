<?php
declare(strict_types=1);

namespace HelpScoutDocs\Models;

use stdClass;

class Person extends DocsModel
{
    private ?int $id = null;
    private ?string $firstName = null;
    private ?string $lastName = null;

    public function __construct(stdClass $data = null)
    {
        if ($data) {
            $this->id        = $data->id ?? null;
            $this->firstName = $data->firstName ?? null;
            $this->lastName  = $data->lastName ?? null;
        }
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }
}
