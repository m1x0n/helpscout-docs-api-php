<?php

declare(strict_types=1);

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\ApiException;
use HelpScoutDocs\Models\Site;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class SitesTest extends TestCase
{
    public function testShouldReturnSitesCollection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/sites/sites.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $sites = $apiClient->getSites();

        $this->assertInstanceOf(ResourceCollection::class, $sites);
    }

    public function testShouldCreateSiteAndRespondWithNewInstance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/sites/site.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $site->setSubDomain(uniqid("Subdomain", true));
        $site->setTitle(uniqid("Site Title ", true));

        $created = $apiClient->createSiteAndReturnCreated($site);

        $this->assertInstanceOf(Site::class, $created);
    }

    public function testShouldCreateSite(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $site->setSubDomain(uniqid("Subdomain", true));
        $site->setTitle(uniqid("Site Title ", true));

        $apiClient->createSite($site);
    }

    public function testShouldThrowAnExceptionIfMalformedSiteProvided(): void
    {
        $this->expectException(ApiException::class);

        $responseMock = $this->createResponseMock(400);
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $apiClient->createSite($site);
    }

    public function testShouldReturnSiteByProvidedId(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/sites/site.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $site = $apiClient->getSite(1337);

        $this->assertInstanceOf(Site::class, $site);
    }

    public function testShouldThrowAnExceptionIfInvalidSiteIdProvided(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionCode(404);

        $responseMock = $this->createResponseMock(404, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->getSite(7777);
    }

    public function testShouldUpdateExistingSiteAndRespondWithUpdatedInstance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/sites/site.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $site->setId(1990);
        $site->setTitle(uniqid("New Site Title ", true));

        $updated = $apiClient->updateSiteAndReturnUpdated($site);

        $this->assertInstanceOf(Site::class, $updated);
    }

    public function testShouldUpdateExistingSiteAndRespondWithoutInstance(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $site = new Site();
        $site->setId(1337);
        $site->setTitle(uniqid("New Site Title ", true));

        $apiClient->updateSite($site, false);
    }

    public function testShouldDeleteExistingSite(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteSite(1337);
    }
}
