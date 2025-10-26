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
     * @var array {'time': string, 'temperature_2m': string}
     */
    public array $hourlyUnits;
    /**
     * @var array {'time' : array {int: string}, 'temperature_2m': array{int: float} }
     */
    public array $hourly;

    public function __construct(
        float $latitude,
        float $longitude,
        string $timezone,
        float $elevation,
        array $hourlyUnits,
        array $hourly
    )
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timezone = $timezone;
        $this->elevation = $elevation;
        $this->hourlyUnits = $hourlyUnits;
        $this->hourly = $hourly;
    }

    /**
     * @throws UnexpectedValueException
     */
    public static function fromJson(string $json): WeatherDto
    {
        $data = json_decode($json, true);
        if (
            !isset($data['latitude']) ||
            !isset($data['longitude']) ||
            !isset($data['timezone']) ||
            !isset($data['elevation']) ||
            !isset($data['hourly']) ||
            !isset($data['hourly_units'])
        ) {
            throw new UnexpectedValueException(
                'Missing weather data. Aborting.'
            );
        }

        return new self(
            $data['latitude'],
            $data['longitude'],
            $data['timezone'],
            $data['elevation'],
            $data['hourly'],
            $data['hourly_units']
        );
    }

}