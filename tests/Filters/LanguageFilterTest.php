<?php

namespace CodeZero\BrowserLocale\Tests\Filters;

use CodeZero\BrowserLocale\BrowserLocale;
use CodeZero\BrowserLocale\Filters\LanguageFilter;
use PHPUnit\Framework\TestCase;

class LanguageFilterTest extends TestCase
{
    /** @test */
    public function it_returns_a_simple_array_of_language_codes()
    {
        $browser = new BrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6');

        $locales = $browser->filter(new LanguageFilter);

        $this->assertEquals(['en', 'nl'], $locales);
    }

    /** @test */
    public function it_returns_an_empty_array_if_no_locales_exist()
    {
        $browser = new BrowserLocale('');

        $locales = $browser->filter(new LanguageFilter);

        $this->assertEquals([], $locales);
    }
}
