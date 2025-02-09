<?php declare(strict_types=1);

namespace Task\Weather\Model\ResourceModel\History;

use Task\Weather\Model\History;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(History::class, \Task\Weather\Model\ResourceModel\History::class);
    }
}
