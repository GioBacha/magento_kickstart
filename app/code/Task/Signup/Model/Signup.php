<?php declare(strict_types=1);

namespace Task\Signup\Model;

use Magento\Framework\Model\AbstractModel;

class Signup extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel\Signup::class);
    }
}
