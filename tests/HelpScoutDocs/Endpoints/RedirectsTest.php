<?php

declare(strict_types=1);

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\Models\Redirect;
use HelpScoutDocs\Models\RedirectedUrl;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class RedirectsTest extends TestCase
{
    public function testShouldReturnRedirectsCollection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirects.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirects = $apiClient->getRedirects(uniqid('', true));
        $this->assertInstanceOf(ResourceCollection::class, $redirects);
    }

    public function testShouldCreateRedirectAndRespondWithNewInstance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid('', true));
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('https://example.com');

        $created = $apiClient->createRedirectAndReturnCreated($redirect);
        $this->assertInstanceOf(Redirect::class, $created);
    }

    public function testShouldCreateRedirect(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid('', true));
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('https://example.com');

        $apiClient->createRedirect($redirect);
    }

    public function testShouldReturnRedirectByProvidedId(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = $apiClient->getRedirect(uniqid('', true));
        $this->assertInstanceOf(Redirect::class, $redirect);
    }

    public function testShouldUpdateExistingRedirectAndRespondWithUpdatedInstance(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid('', true));
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('https://example.com');

        $updated = $apiClient->updateRedirectAndReturnUpdated($redirect);
        $this->assertInstanceOf(Redirect::class, $updated);
    }

    public function testShouldUpdateExistingRedirectAndRespondWithoutInstance(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid('', true));
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('http://example.com');

        $apiClient->updateRedirect($redirect);
    }

    public function testShouldDeleteExistingRedirect(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteRedirect(uniqid('', true));
    }

    public function testShouldFindRedirectedUrlByProvidedUrlAndSiteId(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirected_url.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirectedUrl = $apiClient->findRedirect('https://example.com', uniqid('', true));
        $this->assertInstanceOf(RedirectedUrl::class, $redirectedUrl);
    }
}
