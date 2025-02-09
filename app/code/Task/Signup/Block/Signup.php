<?php

namespace Task\Signup\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;

class Signup extends Template
{
    /** @var ResourceConnection */
    private $resourceConnection;

    public function __construct(
        Template\Context   $context,
        ResourceConnection $resourceConnection,
        array              $data = []
    )
    {
        parent::__construct($context, $data);
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Check if the form is enabled
     *
     * @return bool
     */
    public function isFormEnabled(): bool
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $connection->getTableName('form_status');

        $query = $connection->select()->from($tableName, ['status'])->limit(1);
        $status = $connection->fetchOne($query);

        return (bool)$status;
    }
}
