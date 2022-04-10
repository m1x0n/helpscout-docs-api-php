Docs API Client Endpoints Methods
--------------------

### Collections
* getCollections($page = 1, $siteId = '', $visibility = 'all', $sort = 'order', $order = 'asc')
* getCollection($collectionIdOrNumber)
* createCollection(Collection $collection, $reload = false)
* updateCollection(Collection $collection, $reload = false)
* deleteCollection($collectionId)

### Categories
* getCategories($collectionId, $page = 1, $sort = 'order', $order = 'asc')
* getCategory($categoryIdOrNumber)
* createCategory(Category $category, $reload = false)
* updateCategory(Category $category, $reload = false)
* updateCategoryOrder($collectionId, array $categories)
* deleteCategory($categoryId)

### Articles
* ~~getArticles($categoryId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc', $pageSize = 50)~~ Deprecated. Will be removed soon.
* getArticlesForCategory($categoryId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc', $pageSize = 50)
* getArticlesForCollection($collectionId, $page = 1, $status = 'all', $sort = 'order', $order = 'asc', $pageSize = 50)
* searchArticles($query = '*', $page = 1, $collectionId = '', $status = 'all', $visibility = 'all')
* getRelatedArticles($articleId, $page = 1, $status = 'all', $sort = 'order', $order = 'desc')
* getRevisions($articleId, $page = 1)
* getArticle($articleIdOrNumber, $draft = false)
* getRevision($revisionId)
* createArticle(Article $article, $reload = false)
* updateArticle(Article $article, $reload = false)
* uploadArticle(UploadArticle $uploadArticle, $reload = false)
* updateViewCount($articleId, $count = 1)
* deleteArticle($articleId)
* saveArticleDraft($articleId, $text)
* deleteArticleDraft($articleId)

### Sites
* getSites($page = 1)
* getSite($siteId)
* createSite(Site $site, $reload = false)
* updateSite(Site $site, $reload = false)
* deleteSite($siteId)

### Assets
* createArticleAsset(ArticleAsset $articleAsset)
* createSettingsAsset(SettingsAsset $settingsAsset)

### Redirects
* getRedirects($siteId)
* getRedirect($redirectId)
* findRedirect($url, $siteId)
* createRedirect(Redirect $redirect, $reload = false)
* updateRedirect(Redirect $redirect, $reload = false)
* deleteRedirect($redirectId)
