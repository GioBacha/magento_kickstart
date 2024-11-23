<?php declare(strict_types=1);

namespace Macademy\Blog\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\Forward;

class Index implements HttpGetActionInterface
{
    public function __construct(private ForwardFactory $redirectFactory)
    {

    }

    public function execute(): Forward
    {
        $forward = $this->redirectFactory->create();
        return $forward->setController('post')->forward('list');
    }
}
