<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\Exception\TransportException;

class WeatherControllerTest extends WebTestCase
{
    public function testWeatherDataShown(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->request('GET', '/weather');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Welcome to weather!');
        // in the happy-path, we expect the table to be shown
        $this->assertSelectorTextContains('table', '1');
    }

    public function testWeatherErrorIsLogged(): void
    {
        $client = static::createClient();
        $weatherServiceMock = $this->createMock(WeatherService::class);
        $weatherServiceMock->method('getWeather')->willThrowException(new TransportException('test exception'));

        $client->getContainer()->set(WeatherService::class, $weatherServiceMock);

        $client->request('GET', '/weather');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert-danger', 'test exception');

        $logFile = __DIR__ . '/../../var/log/weather.log';
        $this->assertFileExists($logFile);
        $this->assertStringContainsString('test exception', file_get_contents($logFile));

        // Clean up the log file
        unlink($logFile);
    }
}
