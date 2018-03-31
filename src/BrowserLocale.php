<?php

namespace CodeZero\BrowserLocale;

use CodeZero\BrowserLocale\Filters\Filter;

class BrowserLocale
{
    /**
     * Array of \CodeZero\BrowserLocale\Locale instances.
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
     *
     * @return array
     */
    public function getLocales()
    {
        return $this->locales;
    }

    /**
     * Filter the locales using the given Filter.
     *
     * @param \CodeZero\BrowserLocale\Filters\Filter $filter
     *
     * @return array
     */
    public function filter(Filter $filter)
    {
        return $filter->filter($this->locales);
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
}
