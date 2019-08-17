<?php

namespace Laravel\Dusk;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Testing\TestCase as FoundationTestCase;
use Laravel\Dusk\Chrome\SupportsChrome;

abstract class TestCase extends FoundationTestCase
{
    use Concerns\ProvidesBrowser,
        SupportsChrome;

    /**
     * Register the base URL with Dusk.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Browser::$baseUrl = $this->baseUrl();

        Browser::$storeScreenshotsAt = base_path('tests/Browser/screenshots');

        Browser::$storeConsoleLogAt = base_path('tests/Browser/console');
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }

    /**
     * Determine the application's base URL.
     *
     * @return string
     */
    protected function baseUrl()
    {
        return config('app.url');
    }
}
