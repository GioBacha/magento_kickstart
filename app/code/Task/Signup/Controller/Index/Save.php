<?php declare(strict_types=1);

namespace Task\Signup\Controller\Index;

use Magento\Framework\Message\ManagerInterface;
use Task\Signup\Model\Signup;
use Task\Signup\Model\SignupFactory;
use Task\Signup\Model\ResourceModel\Signup as SignupResource;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\View\Result\Page;

class Save extends Action implements HttpPostActionInterface
{
    /** @var RedirectFactory */
    protected $resultRedirectFactory;

    /** @var SignupFactory\ */
    private SignupFactory $signupFactory;

    /** @var SignupResource */
    private SignupResource $signupResource;

    /** @var ManagerInterface */
    protected $messageManager;

    public function __construct(
        Context          $context,
        RedirectFactory  $resultRedirectFactory,
        SignupFactory    $signupFactory,
        SignupResource   $signupResource,
        ManagerInterface $messageManager
    )
    {
        parent::__construct($context);
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->signupFactory = $signupFactory;
        $this->signupResource = $signupResource;
        $this->messageManager = $messageManager;
    }

    /**
     * @return Page
     */
    public function execute(): Redirect
    {
        $name = $this->getRequest()->getParam('name');
        $date = $this->getRequest()->getParam('date');
        $redirect = $this->resultRedirectFactory->create();

        if (!$name || !$date) {
            $this->messageManager->addErrorMessage(__('City parameter is missing.'));
            return $redirect->setPath('*/*/');
        }

//        $data = ['name' => $name, 'date' => $date];
//        $this->signupSession->setNewData($data);

        try {
            /** @var Signup $signup */
            $signup = $this->signupFactory->create();
            $this->signupResource->load($signup, $name, 'name');

            if (!$signup->getId()) {
                $signup->setName($name);
                $signup->setDate($date);
            }

            $this->signupResource->save($signup);

            $this->messageManager->addSuccessMessage(__('Signup data saved successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Failed to save signup data: %1', $e->getMessage()));
        }


        return $redirect->setPath('*/*/');
    }
}
