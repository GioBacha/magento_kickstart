<?php declare(strict_types=1);

namespace Task\Weather\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Task\Weather\Model\HistoryFactory;
use Task\Weather\Model\ResourceModel\History as HistoryResource;
use Task\Weather\Model\WeatherSession;

class History extends Action implements HttpGetActionInterface
{
    /** @var RedirectFactory */
    protected $resultRedirectFactory;

    /** @var HistoryFactory */
    private HistoryFactory $historyFactory;

    /** @var HistoryResource */
    private HistoryResource $historyResource;

    /** @var WeatherSession */
    private WeatherSession $weatherSession;

    public function __construct(
        Context         $context,
        RedirectFactory $resultRedirectFactory,
        HistoryFactory  $historyFactory,
        HistoryResource $historyResource,
        WeatherSession  $weatherSession
    )
    {
        parent::__construct($context);
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->historyFactory = $historyFactory;
        $this->historyResource = $historyResource;
        $this->weatherSession = $weatherSession;
    }

    public function execute(): Redirect
    {
        $redirect = $this->resultRedirectFactory->create();

        try {
            $historyCollection = $this->historyFactory->create()->getCollection();
            $historyData = [];

            foreach ($historyCollection as $history) {
                $historyData[] = [
                    'city' => $history->getCity(),
                    'country' => $history->getCountry(),
                    'description' => $history->getDescription(),
                    'temperature' => $history->getTemperature(),
                    'feels_like' => $history->getFeelsLike(),
                    'pressure' => $history->getPressure(),
                    'humidity' => $history->getHumidity(),
                    'wind_speed' => $history->getWindSpeed(),
                    'sunrise' => $history->getSunrise(),
                    'sunset' => $history->getSunset(),
                    'checked_on' => $history->getCheckedOn()
                ];
            }

            $this->weatherSession->getWholeData($historyData);

            return $redirect->setPath('weather/index/index');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Failed to fetch weather history: %1', $e->getMessage()));
            return $redirect->setPath('*/*/');
        }
    }
}
