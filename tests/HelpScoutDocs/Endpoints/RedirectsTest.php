<?php
declare(strict_types=1);

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\Models\Redirect;
use HelpScoutDocs\Models\RedirectedUrl;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class RedirectsTest extends TestCase
{
    public function test_should_return_redirects_collection(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirects.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirects = $apiClient->getRedirects(uniqid());
        $this->assertInstanceOf(ResourceCollection::class, $redirects);
    }

    public function test_should_create_redirect_and_respond_with_new_instance(): void
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

    public function test_should_create_redirect(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid('', true));
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('https://example.com');

        $apiClient->createRedirect($redirect);
    }

    public function test_should_return_redirect_by_provided_id(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = $apiClient->getRedirect(uniqid('', true));
        $this->assertInstanceOf(Redirect::class, $redirect);
    }

    public function test_should_update_existing_redirect_and_respond_with_updated_instance(): void
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

    public function test_should_update_existing_redirect_and_respond_without_instance(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid('', true));
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('http://example.com');

        $apiClient->updateRedirect($redirect);
    }

    public function test_should_delete_existing_redirect(): void
    {
        $responseMock = $this->createResponseMock(200);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteRedirect(uniqid('', true));
    }

    public function test_should_find_redirected_url_by_provided_url_and_siteId(): void
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirected_url.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirectedUrl = $apiClient->findRedirect('https://example.com', uniqid('', true));
        $this->assertInstanceOf(RedirectedUrl::class, $redirectedUrl);
    }
}
