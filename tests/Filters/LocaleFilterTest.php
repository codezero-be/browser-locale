<?php

namespace CodeZero\BrowserLocale\Tests\Filters;

use CodeZero\BrowserLocale\Filters\LocaleFilter;
use CodeZero\BrowserLocale\Locale;
use PHPUnit\Framework\TestCase;

class LocaleFilterTest extends TestCase
{
    /** @test */
    public function it_filters_a_simple_array_of_locales()
    {
        $locales = (new LocaleFilter)->filter([
            new Locale('en-US', 'en', 'US', 1.0),
            new Locale('en', 'en', '', 0.8),
            new Locale('nl-NL', 'nl', 'NL', 0.6),
        ]);

        $this->assertEquals(['en-US', 'en', 'nl-NL'], $locales);
    }

    /** @test */
    public function it_returns_an_empty_array_if_no_locales_exist()
    {
        $locales = (new LocaleFilter)->filter([]);

        $this->assertEquals([], $locales);
    }
}
