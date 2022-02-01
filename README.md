# BrowserLocale

[![GitHub release](https://img.shields.io/github/release/codezero-be/browser-locale.svg?style=flat-square)](CHANGELOG.md)
[![License](https://img.shields.io/packagist/l/codezero/browser-locale.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/workflow/status/codezero-be/browser-locale/Tests/master?style=flat-square&logo=github&logoColor=white&label=tests)](https://github.com/codezero-be/browser-locale/actions)
[![Code Coverage](https://img.shields.io/codacy/coverage/7948f1eaee514e47b4a07f268afc630f/master?style=flat-square)](https://app.codacy.com/gh/codezero-be/browser-locale)
[![Code Quality](https://img.shields.io/codacy/grade/7948f1eaee514e47b4a07f268afc630f/master?style=flat-square)](https://app.codacy.com/gh/codezero-be/browser-locale)
[![Total Downloads](https://img.shields.io/packagist/dt/codezero/browser-locale.svg?style=flat-square)](https://packagist.org/packages/codezero/browser-locale)

[![ko-fi](https://www.ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/R6R3UQ8V)

#### Get the most preferred locales from your visitor's browser.

Every browser has a setting for preferred website locales.

This can be read by PHP, usually with the `$_SERVER["HTTP_ACCEPT_LANGUAGE"]` variable.

> `$_SERVER["HTTP_ACCEPT_LANGUAGE"]` will return a comma separated list of language codes. Each language code MAY have a "relative quality factor" attached ("nl;q=0.8") which determines the order of preference. For example: `nl-NL,nl;q=0.8,en-US;q=0.6,en;q=0.4`. If no relative quality factor is present, the value is by default `1.0`.

**BrowserLocale** parses this string and lets you access the preferred locales quickly and easily.


##  Requirements

- PHP >= 7.0

## Install

```php
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
    $full     = $locale->locale;   // Example: "en-US"
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
    $full     = $locale->locale;   // Example: "en-US"
    $language = $locale->language; // Example: "en"
    $country  = $locale->country;  // Example: "US"
    $weight   = $locale->weight;   // Example: 1.0  
}
```

## Filter Locale Info

You can get a flattened array with only specific Locale information. These arrays will always be sorted by weight in descending order. There will be no duplicate values! (e.g. `en` and `en-US` are both the language `en`)

#### LocaleFilter

Returns an array of every locale found in the input string.

``` php
$browser = new \CodeZero\BrowserLocale\BrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6');
$filter = \CodeZero\BrowserLocale\Filters\LocaleFilter;
$locales = $browser->filter($filter);
//=> Result: ['en-US', 'en', 'nl-BE']
```

#### CombinedFilter

Returns an array of every locale found in the input string, while making sure the 2-letter language version of the locale is always present.

``` php
$browser = new \CodeZero\BrowserLocale\BrowserLocale('en-US,nl;q=0.8');
$filter = \CodeZero\BrowserLocale\Filters\CombinedFilter;
$locales = $browser->filter($filter);
//=> Result: ['en-US', 'en', 'nl']
```

#### LanguageFilter

Returns an array of only the 2-letter language codes found in the input string. Language codes are also extracted from full locales and added to the results array.

``` php
$browser = new \CodeZero\BrowserLocale\BrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6');
$filter = \CodeZero\BrowserLocale\Filters\LanguageFilter;
$languages = $browser->filter($filter);
//=> Result: ['en', 'nl']
```

#### CountryFilter

Returns an array of only the 2-letter country codes found in the input string. Locales that only contain a 2-letter language code will be skipped.

``` php
$browser = new \CodeZero\BrowserLocale\BrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');
$filter = \CodeZero\BrowserLocale\Filters\CountryFilter;
$countries = $browser->filter($filter);
//=> Result: ['US', 'BE']
```

#### WeightFilter

Returns an array of all relative quality factors found in the input string. The default of `1.0` is also included.

``` php
$browser = new \CodeZero\BrowserLocale\BrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');
$filter = \CodeZero\BrowserLocale\Filters\WeightFilter;
$weights = $browser->filter($filter);
//=> Result: [1.0, 0.8, 0.6, 0.4]
```

You can create your own filters by implementing the `\CodeZero\BrowserLocale\Filters\Filter` interface.

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
