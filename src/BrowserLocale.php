<?php

namespace CodeZero\BrowserLocale;

class BrowserLocale
{
    /**
     * Array of \CodeZero\BrowserLocale\Locale instances.
     *
     * @var array
     */
    protected $locales = [];

    /**
     * Supported filters for getLocales().
     *
     * @var array
     */
    protected $filters = ['locale', 'language', 'country', 'weight'];

    /**
     * Create a new BrowserLocale instance.
     *
     * @param string $httpAcceptLanguages
     */
    public function __construct($httpAcceptLanguages)
    {
        $this->parseHttpAcceptLanguages($httpAcceptLanguages);
    }

    /**
     * Get the most preferred locale.
     *
     * @return \CodeZero\BrowserLocale\Locale|null
     */
    public function getLocale()
    {
        return $this->locales[0] ?? null;
    }

    /**
     * Get an array of Locale objects in descending order of preference.
     * Specify a Locale property to get a flattened array of values of that property.
     *
     * @param string $property
     *
     * @return array
     */
    public function getLocales($property = null)
    {
        if ( ! in_array($property, $this->filters)) {
            return $this->locales;
        }

        return $this->filterLocaleInfo($property);
    }

    /**
     * Parse all HTTP Accept Languages.
     *
     * @param string $httpAcceptLanguages
     *
     * @return void
     */
    protected function parseHttpAcceptLanguages($httpAcceptLanguages)
    {
        $locales = $this->split($httpAcceptLanguages, ',');

        foreach ($locales as $httpAcceptLanguage) {
            $this->makeLocale($httpAcceptLanguage);
        }

        $this->sortLocales();
    }

    /**
     * Convert the given HTTP Accept Language to a Locale object.
     *
     * @param string $httpAcceptLanguage
     *
     * @return void
     */
    protected function makeLocale($httpAcceptLanguage)
    {
        $parts = $this->split($httpAcceptLanguage, ';');

        $locale = $parts[0];
        $weight = $parts[1] ?? null;

        if (empty($locale)) {
            return;
        }

        $this->locales[] = new Locale(
            $locale,
            $this->getLanguage($locale),
            $this->getCountry($locale),
            $this->getWeight($weight)
        );
    }

    /**
     * Split the given string by the delimiter.
     *
     * @param string $string
     * @param string $delimiter
     *
     * @return array
     */
    protected function split($string, $delimiter)
    {
        return explode($delimiter, trim($string)) ?: [];
    }

    /**
     * Get the 2-letter language code from the locale.
     *
     * @param string $locale
     *
     * @return string
     */
    protected function getLanguage($locale)
    {
        return substr($locale, 0, 2) ?: '';
    }

    /**
     * Get the 2-letter country code from the locale.
     *
     * @param string $locale
     *
     * @return string
     */
    protected function getCountry($locale)
    {
        return substr($locale, 3, 2) ?: '';
    }

    /**
     * Parse the relative quality factor and return its value.
     *
     * @param string $q
     *
     * @return float
     */
    protected function getWeight($q)
    {
        $parts = $this->split($q, '=');

        $weight = $parts[1] ?? 1.0;

        return (float) $weight;
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
        $filtered = [];

        foreach ($this->locales as $locale) {
            if ($locale->$property && ! in_array($locale->$property, $filtered)) {
                $filtered[] = $locale->$property;
            }
        }

        return $filtered;
    }
}
