# BrowserLocale

[![GitHub release](https://img.shields.io/github/release/codezero-be/browser-locale.svg)]()
[![License](https://img.shields.io/packagist/l/codezero/browser-locale.svg)]()
[![Build Status](https://scrutinizer-ci.com/g/codezero-be/browser-locale/badges/build.png?b=master)](https://scrutinizer-ci.com/g/codezero-be/browser-locale/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/codezero-be/browser-locale/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/codezero-be/browser-locale/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/codezero-be/browser-locale/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/codezero-be/browser-locale/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/codezero/browser-locale.svg)](https://packagist.org/packages/codezero/browser-locale)

#### Get the most preferred locales from your visitor's browser.

Every browser has a setting for preferred website locales.

This can be read by PHP, usually with the `$_SERVER["HTTP_ACCEPT_LANGUAGE"]` variable. Its value is a string that looks like this: `nl-NL,nl;q=0.8,en-US;q=0.6,en;q=0.4`.

`BrowserLocale` parses this string and lets you access the preferred locales quickly and easily.

##  Requirements

- PHP >= 7.0

## Install

```
composer require codezero/browser-locale
```

## Instantiate

#### For vanilla PHP:

``` php
$browser = new \CodeZero\BrowserLocale\BrowserLocale($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
```

#### For Laravel:

Laravel >= 5.5 will automatically register the ServiceProvider so you can get `BrowserLocale` from the IOC container.

```php
$browser = \App::make(\CodeZero\BrowserLocale\BrowserLocale::class);
```

## Get Primary Locale

``` php
$locale = $browser->getLocale();
```

This will return an instance of `\CodeZero\BrowserLocale\Locale` or `null` if no locale exists.

``` php
if ($locale !== null) {
    $full     = $locale->full;     // Example: "en-US"
    $language = $locale->language; // Example: "en"
    $country  = $locale->country;  // Example: "US"
    $weight   = $locale->weight;   // Example: 1.0
}
```

## Get All Locales

```php
$locales = $browser->getLocales();
```

This will return an array of `\CodeZero\BrowserLocale\Locale` instances, sorted by weight in descending order. So the first array item is the most preferred locale.

If no locales exist, an empty array will be returned.

``` php
foreach ($locales as $locale) {
    $full     = $locale->full;     // Example: "en-US"
    $language = $locale->language; // Example: "en"
    $country  = $locale->country;  // Example: "US"
    $weight   = $locale->weight;   // Example: 1.0  
}
```

## Get Flattened Array

You can get a flattened array, containing only specific locale info. These arrays will always be sorted by weight in descending order. There will be no duplicate values! (e.g. `en` and `en-US` are both the language `en`)

``` php
$locales = $browser->getLocales('full');
//=> Result: ['en-US', 'en', 'nl-BE', 'nl']

$languages = $browser->getLocales('language');
//=> Result: ['en', 'nl']

$countries = $browser->getLocales('country');
//=> Result: ['US', 'BE']

$weights = $browser->getLocales('weight');
//=> Result: [1.0, 0.8, 0.6, 0.4]
```

## Testing

``` 
composer test
```

## Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## Changelog

See a list of important changes in the [changelog](CHANGELOG.md).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
