<?php

namespace McCaulay\Duskless;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use McCaulay\Duskless\Chrome\SupportsChrome;

class Duskless
{
    use Concerns\ProvidesBrowser,
        SupportsChrome;

    private $arguments;

    /**
     * Initialises the dusk browser and starts the chrome driver.
     *
     * @return void
     */
    public function __construct()
    {
        $this->arguments = collect();
    }

    /**
     * Start the browser.
     *
     * @return $this
     */
    public function start()
    {
        static::startChromeDriver();
        return $this;
    }

    /**
     * Stop the browser.
     *
     * @return $this
     */
    public function stop()
    {
        $this->closeAll();
        static::stopChromeDriver();
        return $this;
    }

    /**
     * Run the browser in headless mode.
     *
     * @return $this
     */
    public function headless()
    {
        return $this->addArgument('--headless');
    }

    /**
     * Disable the browser using gpu.
     *
     * @return $this
     */
    public function disableGpu()
    {
        return $this->addArgument('--disable-gpu');
    }

    /**
     * Set the initial browser window size.
     *
     * @param $width The browser width in pixels.
     * @param $height The browser height in pixels.
     * @return $this
     */
    public function windowSize(int $width, int $height)
    {
        return $this->addArgument('--window-size=' . $width . ',' . $height);
    }

    /**
     * Set the user agent.
     *
     * @param $useragent The user agent to use.
     * @return $this
     */
    public function userAgent(string $useragent)
    {
        return $this->addArgument('--user-agent=' . $useragent);
    }

    /**
     * Add a browser option.
     *
     * @return $this
     */
    private function addArgument($argument)
    {
        if ($this->arguments->contains($argument)) {
            return;
        }
        $this->arguments->push($argument);
        return $this;
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments($this->arguments->toArray());

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }
}
