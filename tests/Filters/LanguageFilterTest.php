<?php

namespace CodeZero\BrowserLocale\Tests\Filters;

use CodeZero\BrowserLocale\Filters\LanguageFilter;
use CodeZero\BrowserLocale\Locale;
use PHPUnit\Framework\TestCase;

class LanguageFilterTest extends TestCase
{
    /** @test */
    public function it_returns_a_simple_array_of_language_codes()
    {
        $locales = (new LanguageFilter)->filter([
            new Locale('en-US', 'en', 'US', 1.0),
            new Locale('en', 'en', '', 0.8),
            new Locale('nl-NL', 'nl', 'NL', 0.6),
        ]);

        $this->assertEquals(['en', 'nl'], $locales);
    }

    /** @test */
    public function it_returns_an_empty_array_if_no_locales_exist()
    {
        $locales = (new LanguageFilter)->filter([]);

        $this->assertEquals([], $locales);
    }
}
