<?php
//java -jar selenium-server-standalone-3.141.59.jar
//mitmdump -p 8080 -s "proxy-server.py"

namespace Facebook\WebDriver;

use Facebook\WebDriver\Chrome\ChromeDevToolsDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

$host = 'http://localhost:4444/wd/hub';
$url = 'https://arh.antoinevastel.com/bots/areyouheadless';
$proxyUrl = 'http://127.0.0.1:8080';

$chromeOptions = new ChromeOptions();
$chromeOptions->addArguments(['--headless']);

$capabilities = new DesiredCapabilities(
    [
        WebDriverCapabilityType::BROWSER_NAME => 'chrome',
        WebDriverCapabilityType::PROXY => [
            'proxyType' => 'manual',
            'httpProxy' => $proxyUrl,
            'sslProxy' => $proxyUrl,
        ],
    ]);
$capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);
$driver = RemoteWebDriver::create($host, $capabilities);

$devTools = new ChromeDevToolsDriver($driver);
$devTools->execute('Network.setUserAgentOverride',
    ['userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36']);


//даем команду открыть URL
$driver->navigate()->to($url);
$element = $driver->findElement(WebDriverBy::tagName('html'));
echo $element->getDomProperty('innerHTML');
sleep(5);
//$driver->close();