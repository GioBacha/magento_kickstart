<?php declare(strict_types=1);

namespace Task\Signup\Controller\Adminhtml\History;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\Page;
use Task\Signup\Model\FormStatus;
use Task\Signup\Model\ResourceModel\FormStatus as FormStatusResource;
use Task\Signup\Model\FormStatusFactory;

class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Task_Signup::history_change';

    /** @var RedirectFactory */
    protected $resultRedirectFactory;

    /** @var FormStatusFactory\ */
    private FormStatusFactory $formStatusFactory;

    /** @var FormStatusResource */
    private FormStatusResource $formStatusResource;

    /** @var ManagerInterface */
    protected $messageManager;


    public function __construct(
        Context            $context,
        RedirectFactory    $resultRedirectFactory,
        FormStatusFactory  $formStatusFactory,
        FormStatusResource $formStatusResource,
        ManagerInterface   $messageManager
    )
    {
        parent::__construct($context);
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->formStatusFactory = $formStatusFactory;
        $this->formStatusResource = $formStatusResource;
        $this->messageManager = $messageManager;
    }

    /**
     * @return Page
     */
    public function execute(): Redirect
    {
        $status = (int)$this->getRequest()->getParam('status'); // Ensure it's an integer (1 or 0)

        try {
            /** @var FormStatus $formStatus */
            $connection = $this->formStatusResource->getConnection();
            $tableName = $connection->getTableName('form_status');

            $query = $connection->select()->from($tableName, ['status'])->limit(1);
            $existingStatus = $connection->fetchOne($query);

            if ($existingStatus !== false) {
                $connection->update($tableName, ['status' => $status]);
            } else {
                $connection->insert($tableName, ['status' => $status]);
            }

            $this->messageManager->addSuccessMessage(__('Form status updated successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Failed to update form status: %1', $e->getMessage()));
        }

        $redirect = $this->resultRedirectFactory->create();
        return $redirect->setPath('*/*/');
    }

}
