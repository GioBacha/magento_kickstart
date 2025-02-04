<?php declare(strict_types=1);

namespace Macademy\CommandProxyTest\Model;

use Magento\Framework\Model\AbstractModel;

class Fast extends AbstractModel
{
    public function getSomeData(): string
    {
        return 'some fast data';
    }
}
