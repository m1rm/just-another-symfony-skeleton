<?php

namespace App\Dto;

use http\Exception\UnexpectedValueException;

class WeatherDto
{
    public float $latitude;
    public float $longitude;
    public string $timezone;
    public float $elevation;
    /**
     * @var array<string, string>
     */
    public array $hourly_units;
    /**
     * @var array<string, array<int, mixed>>
     */
    public array $hourly;
}
