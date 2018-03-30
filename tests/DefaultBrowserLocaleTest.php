<?php

namespace CodeZero\BrowserLocale\Tests;

use CodeZero\BrowserLocale\DefaultBrowserLocale;
use PHPUnit\Framework\TestCase;

class DefaultBrowserLocaleTest extends TestCase
{
    /** @test */
    public function it_returns_the_most_preferred_locale()
    {
        $browser = new DefaultBrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');
        $locale = $browser->getLocale();

        $this->assertEquals('en-US', $locale->locale);
        $this->assertEquals('en', $locale->language);
        $this->assertEquals('US', $locale->country);
        $this->assertEquals(1.0, $locale->weight);
    }

    /** @test */
    public function it_returns_the_first_locale_if_two_have_the_same_weight()
    {
        $browser = new DefaultBrowserLocale('nl-NL,en-US,nl;q=0.4');
        $locale = $browser->getLocale();

        $this->assertEquals('nl-NL', $locale->locale);
        $this->assertEquals('nl', $locale->language);
        $this->assertEquals('NL', $locale->country);
        $this->assertEquals(1.0, $locale->weight);
    }

    /** @test */
    public function it_returns_an_array_of_all_preferred_locales()
    {
        $browser = new DefaultBrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');
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
    public function it_returns_a_simple_array_of_locales()
    {
        $browser = new DefaultBrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');

        $locales = $browser->getLocales('locale');

        $this->assertEquals(['en-US', 'en', 'nl-NL', 'nl'], $locales);
    }

    /** @test */
    public function it_returns_a_simple_array_of_language_codes()
    {
        $browser = new DefaultBrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');

        $locales = $browser->getLocales('language');

        $this->assertEquals(['en', 'nl'], $locales);
    }

    /** @test */
    public function it_returns_a_simple_array_of_country_codes()
    {
        $browser = new DefaultBrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');

        $locales = $browser->getLocales('country');

        $this->assertEquals(['US', 'NL'], $locales);
    }

    /** @test */
    public function it_returns_a_simple_array_of_weight_values()
    {
        $browser = new DefaultBrowserLocale('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');

        $locales = $browser->getLocales('weight');

        $this->assertEquals([1.0, 0.8, 0.6, 0.4], $locales);
    }

    /** @test */
    public function it_returns_null_or_an_empty_array_if_no_locale_exists()
    {
        $browser = new DefaultBrowserLocale('');

        $this->assertEquals(null, $browser->getLocale());
        $this->assertEquals([], $browser->getLocales());
        $this->assertEquals([], $browser->getLocales('locales'));
        $this->assertEquals([], $browser->getLocales('language'));
        $this->assertEquals([], $browser->getLocales('country'));
        $this->assertEquals([], $browser->getLocales('weight'));
    }
}
