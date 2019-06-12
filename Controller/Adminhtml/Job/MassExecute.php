<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_CronSchedule
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\CronSchedule\Controller\Adminhtml\Job;

use Magento\Framework\App\ResponseInterface;
use Mageplaza\CronSchedule\Controller\Adminhtml\AbstractJob;

/**
 * Class MassExecute
 * @package Mageplaza\CronSchedule\Controller\Adminhtml\Job
 */
class MassExecute extends AbstractJob
{
    /**
     * @return ResponseInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();

        $success = 0;
        $failure = 0;

        foreach ($this->getSelectedRecords($data) as $name) {
            $this->executeJob($this->helper->getJobs($name), $success, $failure);
        }

        if ($success) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been executed.', $success));
        }

        if ($failure) {
            $this->messageManager->addErrorMessage(__(
                'A total of %1 record(s) can not execute. Please check the Cron Jobs Log for more details.',
                $failure
            ));
        }

        return $this->_redirect('*/*/');
    }
}