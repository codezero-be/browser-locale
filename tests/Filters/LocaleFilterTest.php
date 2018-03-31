<?php

namespace CodeZero\BrowserLocale\Tests\Filters;

use CodeZero\BrowserLocale\BrowserLocale;
use CodeZero\BrowserLocale\Filters\LocaleFilter;
use PHPUnit\Framework\TestCase;

class BrowserLocaleTest extends TestCase
{
    /** @test */
    public function it_filters_a_simple_array_of_locales()
    {
        $browser = new BrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6');

        $locales = $browser->filter(new LocaleFilter);

        $this->assertEquals(['en-US', 'en', 'nl-NL'], $locales);
    }

    /** @test */
    public function it_returns_an_empty_array_if_no_locales_exist()
    {
        $browser = new BrowserLocale('');

        $locales = $browser->filter(new LocaleFilter);

        $this->assertEquals([], $locales);
    }
}
