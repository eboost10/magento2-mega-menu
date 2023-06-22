<?php

declare(strict_types=1);

namespace EBoost\Menu\Controller\Adminhtml\Menu;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\ValidatorException;
use Psr\Log\LoggerInterface;
use EBoost\Menu\Model\ImportExport\File\Upload as FileUpload;
use EBoost\Menu\Model\ImportExport\Processor\Import as ImportProcessor;
use EBoost\Menu\Model\ImportExport\Processor\Import\Validator\ValidationAggregateError;

class ImportPost extends Action implements HttpPostActionInterface
{
    /**
     * @inheritDoc
     */
    const ADMIN_RESOURCE = 'EBoost_Menu::menus';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ImportProcessor
     */
    private $importProcessor;

    /**
     * @var FileUpload
     */
    private $fileUpload;

    public function __construct(
        Context $context,
        LoggerInterface $logger,
        FileUpload $fileUpload,
        ImportProcessor $importProcessor
    ) {
        $this->logger = $logger;
        $this->fileUpload = $fileUpload;
        $this->importProcessor = $importProcessor;

        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $importData = $this->fileUpload->uploadFileAndGetData();
            $menu = $this->importProcessor->importData($importData);

            $this->messageManager->addSuccessMessage(__('Menu "%1" has been successfully imported.', $menu));

            return $resultRedirect->setPath('*/*');
        } catch (ValidationAggregateError $exception) {
            $exception->flush();
        } catch (ValidatorException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        } catch (Exception $exception) {
            $this->logger->critical($exception);
            $this->messageManager->addErrorMessage(__('An error occurred while importing menu.'));
        }

        return $resultRedirect->setPath('*/*/import');
    }
}
