# BrowserLocale

[![GitHub release](https://img.shields.io/github/release/codezero-be/browser-locale.svg)]() [![License](https://img.shields.io/packagist/l/codezero/browser-locale.svg)]() [![Build Status](https://img.shields.io/travis/codezero-be/browser-locale.svg?branch=master)](https://travis-ci.org/codezero-be/browser-locale) [![Scrutinizer](https://img.shields.io/scrutinizer/g/codezero-be/browser-locale.svg)](https://scrutinizer-ci.com/g/codezero-be/browser-locale) [![Total Downloads](https://img.shields.io/packagist/dt/codezero/browser-locale.svg)](https://packagist.org/packages/codezero/browser-locale)

#### Get the most preferred locales from your visitor's browser.

Every browser has a setting for preferred website locales.

This can be read by PHP, usually with the `$_SERVER["HTTP_ACCEPT_LANGUAGE"]` variable. Its value is a string that looks like this: `nl-NL,nl;q=0.8,en-US;q=0.6,en;q=0.4`.

`BrowserLocale` parses this string and lets you access the preferred locales quickly and easily.

## Instantiate

``` 
use CodeZero\BrowserLocale\BrowserLocale;
$browser = new BrowserLocale();
```

By default the class will look for `$_SERVER["HTTP_ACCEPT_LANGUAGE"]`. If you want to override this, you can pass a string to the constructor. That string should be formatted in the same way as described above.

## Get primary locale

To fetch the primary browser locale, you can call `getLocale()`. This will return an instance of `CodeZero\BrowserLocale\Locale` or `null` if no locale exists.

``` 
$instance = $browser->getLocale();
```

If a locale is returned, you get access to a few properties:

``` 
if ($instance !== null) {
    $locale   = $instance->locale;   // Example: "en-US"
    $language = $instance->language; // Example: "en"
    $country  = $instance->country;  // Example: "US"
    $weight   = $instance->weight;   // Example: 1.0
}
```

## Get all locales

To fetch all locales that are configured in a visitor's browser, you can call `getLocales()`. This will return an array of `Locale` instances, sorted by weight. So the first array item is the most preferred locale. If no locales exist, an empty array will be returned.

``` 
$locales = $browser->getLocales();

foreach ($locales as $instance) {
    $locale   = $instance->locale;   // Example: "en-US"
    $language = $instance->language; // Example: "en"
    $country  = $instance->country;  // Example: "US"
    $weight   = $instance->weight;   // Example: 1.0  
}
```

## Get flattened array

Maybe you want to fetch a simple array with only the 2-letter language codes. Or maybe only the country codes. The `getLocales()` method accepts a property filter to allow for this. The filter can be the name of one of the following properties:

``` 
$locales = $browser->getLocales('locales');
//=> Example: ['en-US', 'en', 'nl-BE', 'nl']

$languages = $browser->getLocales('language');
//=> Example: ['en', 'nl']

$countries = $browser->getLocales('country');
//=> Example: ['US', 'BE']

$weights = $browser->getLocales('weight');
//=> Example: [1.0, 0.8, 0.6, 0.4]
```

These arrays will always be sorted by preference (most preferred first).

There will be no duplicate values! (e.g. `en` and `en-US` are both the language `en`)

## Testing

``` 
$ vendor/bin/phpspec run
```

## Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

[![Analytics](https://ga-beacon.appspot.com/UA-58876018-1/codezero-be/browser-locale)](https://github.com/igrigorik/ga-beacon)
