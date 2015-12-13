<?php

namespace CodeZero\BrowserLocale;

class Locale
{
    /**
     * Full locale with language and country code.
     *
     * @var string
     */
    public $locale;

    /**
     * Language code of the locale.
     *
     * @var string
     */
    public $language;

    /**
     * Country code of the locale, if available.
     *
     * @var string
     */
    public $country;

    /**
     * An indicator of importance, where 1.0 is most
     * important and 0.0 is least important.
     *
     * @var float
     */
    public $weight;
}
