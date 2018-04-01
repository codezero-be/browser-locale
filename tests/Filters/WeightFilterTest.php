<?php

namespace CodeZero\BrowserLocale\Tests\Filters;

use CodeZero\BrowserLocale\Filters\WeightFilter;
use CodeZero\BrowserLocale\Locale;
use PHPUnit\Framework\TestCase;

class WeightFilterTest extends TestCase
{
    /** @test */
    public function it_returns_a_simple_array_of_weight_values()
    {
        $locales = (new WeightFilter)->filter([
            new Locale('en-US', 'en', 'US', 1.0),
            new Locale('en', 'en', '', 0.8),
            new Locale('nl-NL', 'nl', 'NL', 0.6),
            new Locale('nl', 'nl', '', 0.4),
        ]);

        $this->assertEquals([1.0, 0.8, 0.6, 0.4], $locales);
    }

    /** @test */
    public function it_returns_an_empty_array_if_no_locales_exist()
    {
        $locales = (new WeightFilter)->filter([]);

        $this->assertEquals([], $locales);
    }
}
