<?php

namespace HelpScoutDocs\Tests;

use HelpScoutDocs\DocsApiClient;

class DocsApiClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DocsApiClient
     */
    private $apiClient;

    public function setUp()
    {
        parent::setUp();

        $this->apiClient = new DocsApiClient();
    }
    
    /**
     * @test
     * @expectedException \HelpScoutDocs\ApiException
     * @expectedExceptionMessage Invalid API Key
     */
    public function should_throw_an_exception_if_no_api_key_provided()
    {
        $this->apiClient->getSites();
    }
}