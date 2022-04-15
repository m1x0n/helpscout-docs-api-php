<?php

declare(strict_types=1);

namespace HelpScoutDocs\Tests;

use JsonException;
use RuntimeException;
use stdClass;

trait FixtureLoader
{
    /**
     * @throws JsonException
     * @throws RuntimeException
     */
    public function loadFixtureAsStdClass(string $path): stdClass
    {
        $data = file_get_contents($path);
        if ($data === false) {
            throw new RuntimeException("Failed to read fixture context of $path");
        }
        return json_decode($data, false, 512, JSON_THROW_ON_ERROR);
    }
}
