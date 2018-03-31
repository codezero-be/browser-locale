<?php

namespace CodeZero\BrowserLocale\Tests\Filters;

use CodeZero\BrowserLocale\BrowserLocale;
use CodeZero\BrowserLocale\Filters\CombinedFilter;
use PHPUnit\Framework\TestCase;

class CombinedFilterTest extends TestCase
{
    /** @test */
    public function it_returns_a_combined_array_of_locales_and_languages()
    {
        $browser = new BrowserLocale('en-US,nl-NL;q=0.8,nl;q=0.6');

        $locales = $browser->filter(new CombinedFilter);

        $this->assertEquals(['en-US', 'en', 'nl-NL', 'nl'], $locales);
    }

    /** @test */
    public function it_returns_an_empty_array_if_no_locales_exist()
    {
        $browser = new BrowserLocale('');

        $locales = $browser->filter(new CombinedFilter);

        $this->assertEquals([], $locales);
    }
}
