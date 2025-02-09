<?php

namespace Task\Weather\Model;

use Magento\Framework\Session\SessionManagerInterface;

class WeatherSession
{
    protected $sessionManager;

    public function __construct(SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function setWeatherData($data)
    {
        $this->sessionManager->setData('weather_data', $data);
    }

    public function getWeatherData()
    {
        return $this->sessionManager->getData('weather_data');
    }

    public function getWholeData($data)
    {
        $this->sessionManager->setData('whole_data', $data);
    }

    public function patchData()
    {
        return $this->sessionManager->getData('whole_data');
    }
}
