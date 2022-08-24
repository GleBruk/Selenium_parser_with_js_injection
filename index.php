<?php

namespace Facebook\WebDriver;

use Facebook\WebDriver\Chrome\ChromeDevToolsDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

//указываем хост, url который нам нужен и прокси через который будем делать инъекцию
$host = 'http://localhost:4444/wd/hub';
$url = 'https://bot.incolumitas.com';
$proxyUrl = 'http://127.0.0.1:8080';

//Делаем selenium headless
$chromeOptions = new ChromeOptions();
$chromeOptions->addArguments(['--headless']);

//Указываем прокси
$capabilities = new DesiredCapabilities(
    [
        WebDriverCapabilityType::BROWSER_NAME => 'chrome',
        WebDriverCapabilityType::PROXY => [
            'proxyType' => 'manual',
            'httpProxy' => $proxyUrl,
            'sslProxy' => $proxyUrl,
        ],
    ]);
//Устанавливаем настройки selenium и указываем хост
$capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);
$driver = RemoteWebDriver::create($host, $capabilities);

//Указываем usergent
$devTools = new ChromeDevToolsDriver($driver);
$devTools->execute('Network.setUserAgentOverride',
    ['userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36']);


//Делаем запрос по указанному url
$driver->navigate()->to($url);
/*
 * Далее запрос перехватывает прокси-сервер и обрабатывает ответ на него, добавив туда инъекцию
 * Код работы с прокси-сервером находится в файле proxy-server.py
 * Инъекция находится в файле js-injection.js
*/

//Получаем html и выводим его на страницу
$element = $driver->findElement(WebDriverBy::tagName('html'));
echo $element->getDomProperty('innerHTML');
$driver->close();