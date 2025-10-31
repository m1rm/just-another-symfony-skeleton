<?php

namespace App\Service;

use App\Dto\WeatherDto;
use http\Exception\UnexpectedValueException;
use Symfony\Component\HttpClient\Exception\RedirectionException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
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
    )
    {}

    /**
     * @throws UnexpectedValueException
     * @throws BadRequestHttpException
     * @throws ServiceUnavailableHttpException
     * @throws RedirectionException
     */
    public function getWeather(): WeatherDto
    {
        try {
            $response = $this->httpClient->request('GET', 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&hourly=temperature_2m');
            $this->serializer->deserialize($response->getContent(), WeatherDto::class, 'json');
        } catch (TransportExceptionInterface $e) {
            throw new TransportException(
                'Transport error: ' . $e->getMessage() . ' (code: ' . $e->getCode() . ')');
        } catch (ClientExceptionInterface $e) {
            throw new BadRequestHttpException(
                'Client error: ' . $e->getMessage() . ' (code: ' . $e->getCode() . ')'
            );
        } catch (RedirectionExceptionInterface $e) {
            throw new RedirectionException(
                'Redirection error: ' . $e->getMessage() . ' (code: ' . $e->getCode() . ')'
            );
        } catch (ServerExceptionInterface|ExceptionInterface $e) {
            throw new ServiceUnavailableHttpException(
                'Server error: ' . $e->getMessage() . ' (code: ' . $e->getCode() . ')'
            );
        }
    }
}
