<?php declare(strict_types=1);

namespace Task\Signup\Model\ResourceModel\FormStatus;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Task\Signup\Model\FormStatus;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(FormStatus::class, \Task\Signup\Model\ResourceModel\FormStatus::class);
    }
}
