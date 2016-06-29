<?php

namespace HelpScoutDocs\Tests;

use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    /**
     * @test
     */
    public function check_if_universe_exists()
    {
        $this->assertEquals(1, 1);
    }
}