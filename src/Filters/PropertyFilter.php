<?php

namespace CodeZero\BrowserLocale\Filters;

abstract class PropertyFilter
{
    /**
     * Filter by a Locale property.
     *
     * @param array $locales
     * @param string $property
     *
     * @return array
     */
    protected function filterByProperty(array $locales, $property)
    {
        $filtered = [];

        foreach ($locales as $locale) {
            if ( ! empty($locale->$property) && ! in_array($locale->$property, $filtered)) {
                $filtered[] = $locale->$property;
            }
        }

        return $filtered;
    }
}
