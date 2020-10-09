<?php

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\Models\Site;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class SitesTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_sites_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/sites/sites.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $sites = $apiClient->getSites();

        $this->assertInstanceOf(ResourceCollection::class, $sites);
    }

    /**
     * @test
     */
    public function should_create_site_and_respond_with_new_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/sites/site.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $site->setSubDomain(uniqid("Subdomain"));
        $site->setTitle(uniqid("Site Title "));

        $created = $apiClient->createSite($site, true);

        $this->assertInstanceOf(Site::class, $created);
    }

    /**
     * @test
     */
    public function should_create_site_and_assign_id(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $site->setSubDomain(uniqid("Subdomain"));
        $site->setTitle(uniqid("Site Title "));

        $created = $apiClient->createSite($site, false);

        $this->assertInstanceOf(Site::class, $created);
        $this->assertNotEmpty($created->getId());
    }

    /**
     * @test
     */
    public function should_throw_an_exception_if_malformed_site_provided(): void
    {
        $this->expectException(\HelpScoutDocs\ApiException::class);

        $responseMock = $this->createResponseMock(400, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $apiClient->createSite($site, true);
    }

    /**
     * @test
     */
    public function should_return_site_by_provided_id(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/sites/site.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $site = $apiClient->getSite(uniqid());

        $this->assertInstanceOf(Site::class, $site);
    }

    /**
     * @test
     */
    public function should_throw_an_exception_if_invalid_site_id_provided(): void
    {
        $this->expectException(\HelpScoutDocs\ApiException::class);
        $this->expectExceptionCode(404);

        $responseMock = $this->createResponseMock(404, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getSite(uniqid());
    }

    /**
     * @test
     */
    public function should_update_existing_site_and_respond_with_updated_instance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/sites/site.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $site->setId(uniqid());
        $site->setTitle(uniqid("New Site Title "));

        $updated = $apiClient->updateSite($site, true);

        $this->assertInstanceOf(Site::class, $updated);
    }

    /**
     * @test
     */
    public function should_update_existing_site_and_respond_without_instance(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $site->setId(uniqid());
        $site->setTitle(uniqid("New Site Title "));

        $updated = $apiClient->updateSite($site, false);

        $this->assertInstanceOf(Site::class, $updated);
        $this->assertSame($site, $updated);
    }

    /**
     * @test
     */
    public function should_delete_existing_site(): void
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteSite(uniqid());
    }
}
