<?php

use \Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    type: ComponentRegistrar::MODULE,
    componentName: 'Macademy_CheckoutMessages',
    path: __DIR__,
);
