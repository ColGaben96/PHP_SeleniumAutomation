<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class GoogleSearchChromeTest extends TestCase
{
    protected $webDriver;

    public function build_chrome_capabilities() {
        return DesiredCapabilities::chrome();
    }

    public function setUp(): void
    {
        $capabilities = $this -> build_chrome_capabilities();
        $this -> webDriver = RemoteWebDriver::create('http://localhost:4444', $capabilities);
    }

    public function tearDown(): void
    {
        $this -> webDriver -> quit();
    }

    public function test_searchTextOnGoogle()
    {
        $this->webDriver->get("https://www.google.com/");
        $this->webDriver->manage()->window()->maximize();

        sleep(5);

        $element = $this->webDriver->findElement(WebDriverBy::name("q"));
        if($element) {
            $element->sendKeys("Holis");
            $element->submit();
        }

        print $this->webDriver->getTitle();
        $this->assertEquals('Holis - Buscar con Google', $this->webDriver->getTitle());
    }
}