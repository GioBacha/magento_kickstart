<?php declare(strict_types=1);

namespace Task\Signup\Model\ResourceModel\Signup;

use Task\Signup\Model\Signup;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Signup::class, \Task\Signup\Model\ResourceModel\Signup::class);
    }
}
