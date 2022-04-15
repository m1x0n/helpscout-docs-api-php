<?php

declare(strict_types=1);

namespace HelpScoutDocs\Tests\Models;

use HelpScoutDocs\Models\Article;
use HelpScoutDocs\Models\ArticleRef;
use HelpScoutDocs\Models\ArticleRevision;
use HelpScoutDocs\Models\ArticleRevisionRef;
use HelpScoutDocs\Models\ArticleSearch;
use HelpScoutDocs\Models\Category;
use HelpScoutDocs\Models\Collection;
use HelpScoutDocs\Models\Person;
use HelpScoutDocs\Models\Redirect;
use HelpScoutDocs\Models\Site;
use HelpScoutDocs\Tests\FixtureLoader;
use PHPUnit\Framework\TestCase;
use stdClass;

class ModelDeserializationTest extends TestCase
{
    use FixtureLoader;

    private const FIXTURE_PATH = __DIR__ . '/fixtures/';

    /**
     * @param string $className
     * @param stdClass $fixture
     * @return void
     * @dataProvider dataProvider
     */
    public function testShouldDeserializeModels(string $className, stdClass $fixture): void
    {
        new $className($fixture);
    }

    public function dataProvider(): array
    {
        return [
            'Article' => [Article::class, $this->loadFixture('article')],
            'ArticleRef' => [ArticleRef::class, $this->loadFixture('article_ref')],
            'ArticleRevision' => [ArticleRevision::class, $this->loadFixture('article_revision')],
            'ArticleRevisionRef' => [ArticleRevisionRef::class, $this->loadFixture('article_revision_Ref')],
            'ArticleSearch' => [ArticleSearch::class, $this->loadFixture('article_search')],
            'Category' => [Category::class, $this->loadFixture('category')],
            'Collection' => [Collection::class, $this->loadFixture('collection')],
            'Person' => [Person::class, $this->loadFixture('person')],
            'Redirect' => [Redirect::class, $this->loadFixture('redirect')],
            'Site' => [Site::class, $this->loadFixture('site')],
        ];
    }

    private function loadFixture(string $name): stdClass
    {
        return $this->loadFixtureAsStdClass(self::FIXTURE_PATH . $name . '.json');
    }
}
