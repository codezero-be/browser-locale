<?php

namespace CodeZero\BrowserLocale;

class BrowserLocale
{
    /**
     * Array of all preferred locales that are
     * configured in a visitor's browser.
     *
     * @var array
     */
    protected $locales = [];

    /**
     * Create a new BrowserLocale instance.
     *
     * @param string $httpAcceptLanguages
     */
    public function __construct($httpAcceptLanguages)
    {
        // $_SERVER["HTTP_ACCEPT_LANGUAGE"] will return a comma separated list of language codes.
        // Each language code MAY have a "relative quality factor" attached ("nl;q=0.8") which
        // determines the order of preference. For example: "nl-NL,nl;q=0.8,en-US;q=0.6,en;q=0.4"
        $this->parseAcceptLanguages($httpAcceptLanguages);
    }

    /**
     * Get the most preferred locale.
     *
     * @return Locale|null
     */
    public function getLocale()
    {
        return isset($this->locales[0]) ? $this->locales[0] : null;
    }

    /**
     * Get an array of Locale objects in descending order of preference.
     *
     * If a property filter is specified, a flattened array of locale information,
     * containing only the requested property values will be returned instead.
     *
     * @param string $propertyFilter full|language|country|weight
     *
     * @return array
     */
    public function getLocales($propertyFilter = null)
    {
        if ($propertyFilter === null) {
            return $this->locales;
        }

        return $this->filterLocaleInfo($propertyFilter);
    }

    /**
     * Parse all HTTP Accept Languages.
     *
     * @param string $httpAcceptLanguages
     *
     * @return void
     */
    protected function parseAcceptLanguages($httpAcceptLanguages)
    {
        if (empty($httpAcceptLanguages)) {
            return;
        }

        foreach ($this->splitAcceptLanguages($httpAcceptLanguages) as $httpAcceptLanguage) {
            if ($locale = $this->parseAcceptLanguage($httpAcceptLanguage)) {
                $this->locales[] = $locale;
            }
        }

        $this->sortLocales();
    }

    /**
     * Extract and save information from a HTTP Accept Language.
     *
     * @param string $httpAcceptLanguage
     *
     * @return Locale|null
     */
    protected function parseAcceptLanguage($httpAcceptLanguage)
    {
        $parts = $this->splitAcceptLanguage($httpAcceptLanguage);

        $locale = isset($parts[0]) ? $parts[0] : null;
        $weight = isset($parts[1]) ? $parts[1] : null;

        $localeInstance = null;

        if ($locale !== null) {
            $localeInstance = new Locale();
            $localeInstance->full = $locale;
            $localeInstance->language = $this->getLanguage($locale);
            $localeInstance->country = $this->getCountry($locale);
            $localeInstance->weight = $this->getWeight($weight);
        }

        return $localeInstance;
    }

    /**
     * Convert a comma separated list to an array.
     *
     * Example: ["en", "en-US;q=0.8"]
     *
     * @param string $httpAcceptLanguages
     *
     * @return array
     */
    protected function splitAcceptLanguages($httpAcceptLanguages)
    {
        return explode(',', $httpAcceptLanguages) ?: [];
    }

    /**
     * Split a language code and the relative quality factor by semicolon.
     *
     * Example: ["en"] or ["en-US"] or ["en-US", "q=0.8"]
     *
     * @param string $httpAcceptLanguage
     *
     * @return array
     */
    protected function splitAcceptLanguage($httpAcceptLanguage)
    {
        return explode(';', trim($httpAcceptLanguage)) ?: [];
    }

    /**
     * Get the 2-letter language code from the locale.
     *
     * Example: "en"
     *
     * @param string $locale
     *
     * @return string
     */
    protected function getLanguage($locale)
    {
        return strtolower(substr($locale, 0, 2));
    }

    /**
     * Get the 2-letter country code from the locale.
     *
     * Example: "US"
     *
     * @param string $locale
     *
     * @return string
     */
    protected function getCountry($locale)
    {
        if (($divider = strpos($locale, '-')) === false){
            return '';
        }

        return strtoupper(substr($locale, $divider + 1, 2));
    }

    /**
     * Parse the relative quality factor and return its value.
     *
     * Example: 1.0 or 0.8
     *
     * @param string $q
     *
     * @return float
     */
    protected function getWeight($q)
    {
        $weight = 1.0;
        $parts = explode('=', $q);

        if (isset($parts[1])) {
            $weight = ((float) $parts[1]);
        }

        return $weight;
    }

    /**
     * Sort the array of locales in descending order of preference.
     *
     * @return void
     */
    protected function sortLocales()
    {
        usort($this->locales, function ($a, $b) {
            if ($a->weight === $b->weight) {
                return 0;
            }

            return ($a->weight > $b->weight) ? -1 : 1;
        });
    }

    /**
     * Get a flattened array of locale information,
     * containing only the requested property values.
     *
     * @param string $property
     *
     * @return array
     */
    protected function filterLocaleInfo($property)
    {
        $filters = ['full', 'language', 'country', 'weight'];
        $locales = $this->locales;

        if ( ! in_array($property, $filters)) {
            return $locales;
        }

        $filtered = [];

        foreach ($locales as $locale) {
            if ($locale->$property && ! in_array($locale->$property, $filtered)) {
                $filtered[] = $locale->$property;
            }
        }

        return $filtered;
    }
}
