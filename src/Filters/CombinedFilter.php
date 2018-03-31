<?php

namespace CodeZero\BrowserLocale\Filters;

use CodeZero\BrowserLocale\Locale;

class CombinedFilter implements Filter
{
    /**
     * The filtered results.
     *
     * @var array
     */
    protected $filtered;

    /**
     * Filter the locales.
     *
     * @param array $locales
     *
     * @return array
     */
    public function filter(array $locales)
    {
        $this->filtered = [];

        foreach ($locales as $locale) {
            $this->filterLocale($locale);
        }

        return $this->filtered;
    }

    /**
     * Filter the given Locale.
     *
     * @param \CodeZero\BrowserLocale\Locale $locale
     *
     * @return void
     */
    protected function filterLocale(Locale $locale)
    {
        $language = substr($locale->locale, 0, 2);

        $this->addLocale($locale->locale);
        $this->addLocale($language);
    }

    /**
     * Add a locale to the results array.
     *
     * @param string $locale
     *
     * @return void
     */
    protected function addLocale($locale)
    {
        if ( ! in_array($locale, $this->filtered)) {
            $this->filtered[] = $locale;
        }
    }
}
