# Parse, build and manipulate URL's

A simple package to deal with URL's in your applications, based on spatie/url

Retrieve parts of the URL:

```php
use ReactrIO\Url\Url;

$url = Url::fromString('https://spatie.be/opensource');

echo $url->getScheme(); // 'https'
echo $url->getHost(); // 'spatie.be'
echo $url->getPath(); // '/opensource'
```

Transform any part of the URL (the `Url` class is immutable):

```php
$url = Url::fromString('https://spatie.be/opensource');

echo $url->withHost('github.com')->withPath('spatie');
// 'https://github.com/spatie'
```

Retrieve and transform query parameters:

```php
$url = Url::fromString('https://spatie.be/opensource?utm_source=github&utm_campaign=packages');

echo $url->getQuery(); // 'utm_source=github&utm_campaign=packages'
echo $url->getQueryParameter('utm_source'); // 'github'
echo $url->withoutQueryParameter('utm_campaign'); // 'https://spatie.be/opensource?utm_source=github'
```

## Installation

You can install the package via composer:

``` bash
composer require reactr-io/url
```

## Usage

Usage is pretty straightforward. Check out the code examples at the top of this readme.

``` bash
vendor/bin/phpunit tests
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.