<?php

namespace HelpScoutDocs\Tests\Endpoints;

use HelpScoutDocs\Models\Redirect;
use HelpScoutDocs\Models\RedirectedUrl;
use HelpScoutDocs\ResourceCollection;
use HelpScoutDocs\Tests\TestCase;

class RedirectsTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_redirects_collection()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirects.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirects = $apiClient->getRedirects(uniqid());
        $this->assertInstanceOf(ResourceCollection::class, $redirects);
    }

    /**
     * @test
     */
    public function should_create_redirect_and_respond_with_new_instance()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid());
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('http://example.com');

        $created = $apiClient->createRedirect($redirect, true);
        $this->assertInstanceOf(Redirect::class, $created);
    }

    /**
     * @test
     */
    public function should_create_redirect_and_assign_id()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid());
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('http://example.com');

        $created = $apiClient->createRedirect($redirect);
        $this->assertInstanceOf(Redirect::class, $created);
        $this->assertNotEmpty($created->getId());
    }

    /**
     * @test
     */
    public function should_return_redirect_by_provided_id()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = $apiClient->getRedirect(uniqid());
        $this->assertInstanceOf(Redirect::class, $redirect);
    }

    /**
     * @test
     */
    public function should_update_existing_redirect_and_respond_with_updated_instance()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirect.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid());
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('http://example.com');

        $updated = $apiClient->updateRedirect($redirect, true);
        $this->assertInstanceOf(Redirect::class, $updated);
    }

    /**
     * @test
     */
    public function should_update_existing_redirect_and_respond_without_instance()
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $redirect = new Redirect();
        $redirect->setSiteId(uniqid());
        $redirect->setUrlMapping('/test/1');
        $redirect->setRedirect('http://example.com');

        $updated = $apiClient->updateRedirect($redirect);
        $this->assertInstanceOf(Redirect::class, $updated);
        $this->assertSame($redirect, $updated);
    }

    /**
     * @test
     */
    public function should_delete_existing_redirect()
    {
        $responseMock = $this->createResponseMock(200, null);
        $apiClient = $this->createTestApiClient($responseMock);

        $apiClient->deleteRedirect(uniqid());
    }

    /**
     * @test
     */
    public function should_find_redirected_url_by_provided_url_and_siteId()
    {
        $responseMock = $this->createResponseMock(200, __DIR__ . '/../../fixtures/redirects/redirected_url.json');
        $apiClient = $this->createTestApiClient($responseMock);

        $redirectedUrl = $apiClient->findRedirect('http://example.com', uniqid());
        $this->assertInstanceOf(RedirectedUrl::class, $redirectedUrl);
    }
}
