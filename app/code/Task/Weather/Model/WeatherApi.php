<?php

namespace Task\Weather\Model;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Exception\LocalizedException;

class WeatherApi
{
    protected $curl;
    protected $apiKey = 'e96a163aed599dc15f486402041fa07a';

    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    public function getWeather($city)
    {
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$this->apiKey}&units=metric";

        try {
            $this->curl->get($url);

            $responseBody = $this->curl->getBody();
            if (empty($responseBody)) {
                throw new LocalizedException(__('No response received from the weather API.'));
            }

            $response = json_decode($responseBody, true);

            if (isset($response['cod']) && $response['cod'] !== 200) {
                throw new LocalizedException(__('Error from weather API: ' . ($response['message'] ?? 'Unknown error')));
            }

            return [
                'city' => $response['name'],
                'country' => $response['sys']['country'],
                'temperature' => $response['main']['temp'],
                'feels_like' => $response['main']['feels_like'],
                'pressure' => $response['main']['pressure'],
                'humidity' => $response['main']['humidity'],
                'wind_speed' => $response['wind']['speed'],
                'description' => $response['weather'][0]['description'],
                'sunrise' => date('Y-m-d H:i:s', $response['sys']['sunrise']),
                'sunset' => date('Y-m-d H:i:s', $response['sys']['sunset']),
                'checked_on' => date('Y-m-d H:i:s', time()),
            ];
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new LocalizedException(__('An error occurred while retrieving weather data: ' . $e->getMessage()));
        }
    }
}
