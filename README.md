helpscout-docs-api-php ![example workflow](https://github.com/m1x0n/helpscout-docs-api-php/actions/workflows/main.yaml/badge.svg)
======================

PHP Wrapper for the Help Scout Docs API.
More information about Docs API: [http://developer.helpscout.net/docs-api/](http://developer.helpscout.net/docs-api/).

Inspired and followed by original [https://github.com/helpscout/helpscout-api-php](https://github.com/helpscout/helpscout-api-php) repository.

Requirements
---------------------
* PHP >= 7.4.0

Installation
--------------------
This will install latest `3.*` version:
```
composer require m1x0n/helpscout-docs-api-php
```

Package version | PHP version
------------- | -------------
`1.*`  | `>= 5.5`
`2.*`  | `>= 7.3`
`3.*`  | `>= 7.4`


Previous versions are also available and could be installed in following way:
```
composer require m1x0n/helpscout-docs-api-php:^2
```

Example Usage:
---------------------
```php
require_once __DIR__ . '/../vendor/autoload.php';

use HelpScoutDocs\DocsApiClient;

// Initialize client
$docsApiClient = new DocsApiClient('your-api-key');

// Get all collections
$collections = $docsApiClient->getCollections();
```

[More examples](https://github.com/m1x0n/helpscout-docs-api-php/tree/master/examples)
--------------------
[Changelog](https://github.com/m1x0n/helpscout-docs-api-php/tree/master/CHANGELOG.md)
--------------------
[Covered Docs API methods](https://github.com/m1x0n/helpscout-docs-api-php/tree/master/REFERENCE.md)
--------------------

Contributions
---------------------
Contributions are highly appreciated.

Feel free to file an issue, send a PR, make a suggestion etc.
