<?php declare(strict_types=1);

namespace Task\Weather\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use Task\Weather\Model\History;
use Task\Weather\Model\HistoryFactory;
use Task\Weather\Model\ResourceModel\History as HistoryResource;
use Task\Weather\Model\WeatherApi;
use Task\Weather\Model\WeatherSession;

class Search extends Action implements HttpPostActionInterface
{
    /** @var RedirectFactory */
    protected $resultRedirectFactory;

    /** @var WeatherApi */
    private WeatherApi $weatherApi;

    /** @var WeatherSession */
    private WeatherSession $weatherSession;

    /** @var HistoryFactory */
    private HistoryFactory $historyFactory;

    /** @var HistoryResource */
    private HistoryResource $historyResource;

    /** @var ManagerInterface */
    protected $messageManager;

    public function __construct(
        Context          $context,
        RedirectFactory  $resultRedirectFactory,
        WeatherApi       $weatherApi,
        WeatherSession   $weatherSession,
        HistoryFactory   $historyFactory,
        HistoryResource  $historyResource,
        ManagerInterface $messageManager
    )
    {
        parent::__construct($context);
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->weatherApi = $weatherApi;
        $this->weatherSession = $weatherSession;
        $this->historyFactory = $historyFactory;
        $this->historyResource = $historyResource;
        $this->messageManager = $messageManager;
    }

    public function execute(): Redirect
    {
        $city = $this->getRequest()->getParam('city');
        $redirect = $this->resultRedirectFactory->create();

        if (!$city) {
            $this->messageManager->addErrorMessage(__('City parameter is missing.'));
            return $redirect->setPath('*/*/');
        }

        $weatherData = $this->weatherApi->getWeather($city);
        if (!$weatherData) {
            $this->messageManager->addErrorMessage(__('Unable to retrieve weather data.'));
            return $redirect->setPath('*/*/');
        }

        $this->weatherSession->setWeatherData($weatherData);

        try {
            /** @var History $history */
            $history = $this->historyFactory->create();
            $this->historyResource->load($history, $city, 'city');

            if (!$history->getId()) {
                $history->setCity($weatherData['city'] ?? $city);
            }

            $history->setCountry($weatherData['country'] ?? 'Unknown');
            $history->setDescription($weatherData['description'] ?? 'No description');
            $history->setTemperature($weatherData['temperature'] ?? 0);
            $history->setFeelsLike($weatherData['feels_like'] ?? 0);
            $history->setPressure($weatherData['pressure'] ?? 0);
            $history->setHumidity($weatherData['humidity'] ?? 0);
            $history->setWindSpeed($weatherData['wind_speed'] ?? 0);
            $history->setSunrise(date('Y-m-d H:i:s', is_numeric($weatherData['sunrise']) ? (int)$weatherData['sunrise'] : time()));
            $history->setSunset(date('Y-m-d H:i:s', is_numeric($weatherData['sunset']) ? (int)$weatherData['sunset'] : time()));
            $history->setCheckedOn(date('Y-m-d H:i:s'));

            $this->historyResource->save($history);

            $this->messageManager->addSuccessMessage(__('Weather data saved successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Failed to save weather data: %1', $e->getMessage()));
        }

        return $redirect->setPath('weather/index/index');
    }
}
