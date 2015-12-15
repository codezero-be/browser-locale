<?php

namespace CodeZero\BrowserLocale;

interface BrowserLocale
{
    /**
     * Get the most preferred locale.
     *
     * @return Locale|null
     */
    public function getLocale();

    /**
     * Get an array of Locale objects in descending order of preference.
     *
     * If a property filter is specified, a flattened array of locale information,
     * containing only the requested property values will be returned instead.
     *
     * @param string $propertyFilter locale|language|country|weight
     *
     * @return array
     */
    public function getLocales($propertyFilter = null);
}
