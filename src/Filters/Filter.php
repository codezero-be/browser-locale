<?php

namespace CodeZero\BrowserLocale\Filters;

interface Filter
{
    /**
     * Filter the locales.
     *
     * @param array $locales
     *
     * @return array
     */
    public function filter(array $locales);
}
