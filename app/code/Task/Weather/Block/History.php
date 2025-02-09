<?php

namespace Task\Weather\Block;

use Magento\Framework\View\Element\Template;
use Task\Weather\Model\WeatherSession;
use Magento\Framework\View\Element\UiComponentFactory;


class History extends Template
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

    public function patchData()
    {
        $data = $this->weatherSession->patchData();
        return $data ?? [];
    }
}
