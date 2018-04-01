<?php

namespace CodeZero\BrowserLocale\Tests\Filters;

use CodeZero\BrowserLocale\Filters\CombinedFilter;
use CodeZero\BrowserLocale\Locale;
use PHPUnit\Framework\TestCase;

class CombinedFilterTest extends TestCase
{
    /** @test */
    public function it_returns_a_combined_array_of_locales_and_languages()
    {
        $locales = (new CombinedFilter)->filter([
            new Locale('en-US', 'en', 'US', 1.0),
            new Locale('nl', 'nl', '', 0.8),
        ]);

        $this->assertEquals(['en-US', 'en', 'nl'], $locales);
    }

    /** @test */
    public function it_returns_an_empty_array_if_no_locales_exist()
    {
        $locales = (new CombinedFilter)->filter([]);

        $this->assertEquals([], $locales);
    }
}
