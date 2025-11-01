<?php

namespace App\Service;

use App\Dto\WeatherDto;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class WeatherService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private SerializerInterface $serializer
    ) {
    }

    /**
     * @return WeatherDto
     * @throws ExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getWeather(): WeatherDto
    {
        $response = $this->httpClient->request(
            'GET',
            'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m'
        );
        return $this->serializer->deserialize($response->getContent(), WeatherDto::class, 'json');
    }
}
