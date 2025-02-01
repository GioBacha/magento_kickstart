<?php

declare(strict_types=1);

namespace Macademy\ProductCompare\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Product implements ArgumentInterface
{
    /** @var array */
    private array $products = [];

    /** @var array */
    private array $invalidSkus = [];

    /**
     * @param RequestInterface $request
     * @param ProductRepository $productRepository
     * @param FilterBuilder $filterBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        private readonly RequestInterface      $request,
        private readonly ProductRepository     $productRepository,
        private readonly FilterBuilder         $filterBuilder,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
    )
    {
        $skus = (array)$this->request->getParam('skus');

        $this->setProductsFromSku($skus);
    }

    /**
     * Set products and invalidSkus properties from the skus request param.
     *
     * @param array $skus
     * @return void
     */
    private function setProductsFromSku(array $skus): void
    {
        $skuFilter = $this->filterBuilder
            ->setField('sku')
            ->setValue($skus)
            ->setConditionType('in')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters([$skuFilter])
            ->create();

        $this->products = $this->productRepository->getList($searchCriteria)->getItems();
    }


    /**
     * Get product data from SKUs URL params.
     *
     * @return ProductInterface[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * Get invalid SKUS from URL params.
     *
     * @return string[]
     */
    public function getInvalidSkus(): array
    {
        return $this->invalidSkus;
    }
}
