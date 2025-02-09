<?php declare(strict_types=1);

namespace Task\Signup\Ui\DataProvider;

use Task\Signup\Model\ResourceModel\Signup\Collection;
use Task\Signup\Model\ResourceModel\Signup\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class History extends AbstractDataProvider
{
    /** @var Collection $collection */
    protected $collection;
    /** @var array */
    private array $loadedData;

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (!isset($this->loadedData)) {
            $this->loadedData = [];
            foreach ($this->collection->getItems() as $item) {
                $this->loadedData[$item->getData('id')] = $item->getData();
            }
        }
        return $this->loadedData;
    }
}
