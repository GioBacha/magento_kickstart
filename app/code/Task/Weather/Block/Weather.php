<?php

namespace Task\Weather\Block;

use Magento\Framework\View\Element\Template;
use Task\Weather\Model\WeatherSession;
use Magento\Framework\View\Element\UiComponentFactory;


class Weather extends Template
{
    protected $weatherSession;
    protected $uiComponentFactory;

    public function __construct(
        Template\Context   $context,
        WeatherSession     $weatherSession,
        UiComponentFactory $uiComponentFactory,
        array              $data = [],

    )
    {
        $this->weatherSession = $weatherSession;
        $this->uiComponentFactory = $uiComponentFactory;
        parent::__construct($context, $data);
    }

    public function getWeatherData()
    {
        $data = $this->weatherSession->getWeatherData();
        return $data;
    }

    public function getCity()
    {
        return $this->getWeatherData()['city'] ?? '';
    }

    public function getCheckOn()
    {
        return $this->getWeatherData()['checked_on'] ?? '';
    }

    public function getCountry()
    {
        return $this->getWeatherData()['country'] ?? '';
    }

    public function getTemperature()
    {
        return $this->getWeatherData()['temperature'] ?? '';
    }

    public function getFeelsLike()
    {
        return $this->getWeatherData()['feels_like'] ?? '';
    }

    public function getPressure()
    {
        return $this->getWeatherData()['pressure'] ?? '';
    }

    public function getHumidity()
    {
        return $this->getWeatherData()['humidity'] ?? '';
    }

    public function getWindSpeed()
    {
        return $this->getWeatherData()['wind_speed'] ?? '';
    }

    public function getDescription()
    {
        return $this->getWeatherData()['description'] ?? '';
    }

    public function getSunrise()
    {
        return $this->getWeatherData()['sunrise'] ?? '';
    }

    public function getSunset()
    {
        return $this->getWeatherData()['sunset'] ?? '';
    }

    public function hasWeatherData()
    {
        return !empty($this->getWeatherData());
    }
}
