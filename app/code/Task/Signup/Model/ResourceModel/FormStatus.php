<?php declare(strict_types=1);

namespace Task\Signup\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FormStatus extends AbstractDb
{
    /** @var string Main table name */
    const MAIN_TABLE = 'form_status';
    /** @var string Main table primary key field name */
    const FIELD_NAME = 'status';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::FIELD_NAME);
    }
}
