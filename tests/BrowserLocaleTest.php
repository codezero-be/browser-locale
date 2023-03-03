<?php

namespace CodeZero\BrowserLocale\Tests;

use CodeZero\BrowserLocale\BrowserLocale;
use CodeZero\BrowserLocale\Filters\Filter;
use Mockery;
use PHPUnit\Framework\TestCase;

class BrowserLocaleTest extends TestCase
{
    /** @test */
    public function it_returns_the_most_preferred_locale()
    {
        $browser = new BrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');
        $locale = $browser->getLocale();

        $this->assertEquals('en-US', $locale->locale);
        $this->assertEquals('en', $locale->language);
        $this->assertEquals('US', $locale->country);
        $this->assertEquals(1.0, $locale->weight);
    }

    /** @test */
    public function it_returns_the_first_locale_if_two_have_the_same_weight()
    {
        $browser = new BrowserLocale('nl-NL,en-US,nl;q=0.4');
        $locale = $browser->getLocale();

        $this->assertEquals('nl-NL', $locale->locale);
        $this->assertEquals('nl', $locale->language);
        $this->assertEquals('NL', $locale->country);
        $this->assertEquals(1.0, $locale->weight);
    }

    /** @test */
    public function it_returns_an_array_of_all_preferred_locales()
    {
        $browser = new BrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');
        $locales = $browser->getLocales();

        $this->assertEquals('en-US', $locales[0]->locale);
        $this->assertEquals('en', $locales[0]->language);
        $this->assertEquals('US', $locales[0]->country);
        $this->assertEquals(1.0, $locales[0]->weight);

        $this->assertEquals('en', $locales[1]->locale);
        $this->assertEquals('en', $locales[1]->language);
        $this->assertEquals('', $locales[1]->country);
        $this->assertEquals(0.8, $locales[1]->weight);

        $this->assertEquals('nl-NL', $locales[2]->locale);
        $this->assertEquals('nl', $locales[2]->language);
        $this->assertEquals('NL', $locales[2]->country);
        $this->assertEquals(0.6, $locales[2]->weight);

        $this->assertEquals('nl', $locales[3]->locale);
        $this->assertEquals('nl', $locales[3]->language);
        $this->assertEquals('', $locales[3]->country);
        $this->assertEquals(0.4, $locales[3]->weight);
    }

    /** @test */
    public function it_returns_null_or_an_empty_array_if_no_locale_exists()
    {
        $browser = new BrowserLocale('');

        $this->assertNull($browser->getLocale());
        $this->assertEquals([], $browser->getLocales());
    }

    /** @test */
    public function it_returns_null_or_an_empty_array_if_null_is_passed_in()
    {
        $browser = new BrowserLocale(null);

        $this->assertNull($browser->getLocale());
        $this->assertEquals([], $browser->getLocales());
    }

    /** @test */
    public function it_applies_a_filters_to_the_locales()
    {
        $browser = new BrowserLocale('');

        $filter = Mockery::mock(Filter::class)
            ->expects()
            ->filter([])
            ->once()
            ->andReturns(['result'])
            ->getMock();

        $locales = $browser->filter($filter);

        $this->assertEquals(['result'], $locales);
    }
}
