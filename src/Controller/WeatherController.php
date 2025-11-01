<?php

namespace App\Controller;

use App\Service\WeatherService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class WeatherController extends AbstractController
{
    public function __construct(
        private readonly WeatherService $weatherService,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route('/weather', name: 'weather', methods: ['GET'])]
    public function showWeather(): Response
    {
        try {
            $weather = $this->weatherService->getWeather();
        } catch (
            TransportExceptionInterface
            | ClientExceptionInterface
            | RedirectionExceptionInterface
            | ServerExceptionInterface
            | HttpException $exception
        ) {
            $this->logger->error($exception->getMessage());
            return $this->render('weather/index.html.twig', [
                'weatherInfo' => null,
                'weatherGraph' => null,
                'error' => $exception->getMessage()
            ]);
        }

        // todo: generate graph from graph data -> Symfony UX & Chart.js
        return $this->render('weather/index.html.twig', [
            'weatherInfo' => $weather,
            'weatherGraph' => null,
            'error' => null,
        ]);
    }
}
