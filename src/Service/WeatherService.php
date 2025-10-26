<?php

namespace App\Service;

use App\Dto\WeatherDto;
use http\Client\Response;
use http\Exception\UnexpectedValueException;
use HttpRequestException;
use HttpResponseException;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Exception\RedirectionException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class WeatherService
{
    public function __construct(
        private HttpClientInterface $httpClient
    )
    {}

    /**
     * @throws UnexpectedValueException
     * @throws BadRequestHttpException
     * @throws HttpResponseException
     * @throws HttpRequestException
     * @throws RedirectionException
     */
    public function getWeather(): WeatherDto
    {
        try {
            $response = $this->httpClient->request('GET', 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m');
            return WeatherDto::fromJson($response->getContent());
        } catch (TransportExceptionInterface $e) {
            throw new TransportException(
                'Transport error: ' . $e->getMessage() . ' (code: ' . $e->getCode() . ')');
        } catch (ClientExceptionInterface $e) {
            throw new HttpRequestException(
                'Client error: ' . $e->getMessage() . ' (code: ' . $e->getCode() . ')'
            );
        } catch (RedirectionExceptionInterface $e) {
            throw new HttpRequestException(
                'Redirection error: ' . $e->getMessage() . ' (code: ' . $e->getCode() . ')'
            );
        } catch (ServerExceptionInterface $e) {
            throw new HttpResponseException(
                'Server error: ' . $e->getMessage() . ' (code: ' . $e->getCode() . ')'
            );
        }
    }
}
