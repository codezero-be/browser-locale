<?php

namespace CodeZero\BrowserLocale;

class Locale
{
    /**
     * Full locale with language and optional country code.
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

    /**
     * Create a new Locale instance.
     *
     * @param string $locale
     * @param string $language
     * @param string $country
     * @param float $weight
     */
    public function __construct($locale, $language, $country, $weight)
    {
        $this->locale = $locale;
        $this->language = $language;
        $this->country = $country;
        $this->weight = $weight;
    }
}
