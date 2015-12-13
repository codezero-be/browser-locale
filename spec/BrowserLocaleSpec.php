<?php

namespace spec\CodeZero\BrowserLocale;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BrowserLocaleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('en-US,en;q=0.8,nl-NL;q=0.6,nl;q=0.4');
    }

    function it_returns_the_most_preferred_locale()
    {
        $locale = $this->getLocale();

        $locale->locale->shouldBe('en-US');
        $locale->language->shouldBe('en');
        $locale->country->shouldBe('US');
        $locale->weight->shouldBe(1.0);
    }

    function it_returns_the_first_locale_if_two_have_the_same_weight()
    {
        $this->beConstructedWith('nl-NL,en-US,nl;q=0.4');
        $locale = $this->getLocale();

        $locale->locale->shouldBe('nl-NL');
        $locale->language->shouldBe('nl');
        $locale->country->shouldBe('NL');
        $locale->weight->shouldBe(1.0);
    }

    function it_returns_an_array_of_all_preferred_locales()
    {
        $locales = $this->getLocales();

        $locales[0]->locale->shouldBe('en-US');
        $locales[0]->language->shouldBe('en');
        $locales[0]->country->shouldBe('US');
        $locales[0]->weight->shouldBe(1.0);

        $locales[1]->locale->shouldBe('en');
        $locales[1]->language->shouldBe('en');
        $locales[1]->country->shouldBe('');
        $locales[1]->weight->shouldBe(0.8);

        $locales[2]->locale->shouldBe('nl-NL');
        $locales[2]->language->shouldBe('nl');
        $locales[2]->country->shouldBe('NL');
        $locales[2]->weight->shouldBe(0.6);

        $locales[3]->locale->shouldBe('nl');
        $locales[3]->language->shouldBe('nl');
        $locales[3]->country->shouldBe('');
        $locales[3]->weight->shouldBe(0.4);
    }

    function it_returns_a_simple_array_of_locales()
    {
        $output = ['en-US', 'en', 'nl-NL', 'nl'];
        $this->getLocales('locale')->shouldReturn($output);
    }

    function it_returns_a_simple_array_of_language_codes()
    {
        $output = ['en', 'nl'];
        $this->getLocales('language')->shouldReturn($output);
    }

    function it_returns_a_simple_array_of_country_codes()
    {
        $output = ['US', 'NL'];
        $this->getLocales('country')->shouldReturn($output);
    }

    function it_returns_a_simple_array_of_weight_values()
    {
        $output = [1.0, 0.8, 0.6, 0.4];
        $this->getLocales('weight')->shouldReturn($output);
    }

    function it_returns_null_or_an_empty_array_if_no_locale_exists()
    {
        $this->beConstructedWith('');

        $this->getLocale()->shouldReturn(null);
        $this->getLocales()->shouldReturn([]);

        $this->getLocales('locales')->shouldReturn([]);
        $this->getLocales('language')->shouldReturn([]);
        $this->getLocales('country')->shouldReturn([]);
        $this->getLocales('weight')->shouldReturn([]);
    }
}
