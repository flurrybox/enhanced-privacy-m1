<?php
/**
 * This file is part of the Flurrybox EnhancedPrivacy package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Flurrybox EnhancedPrivacy
 * to newer versions in the future.
 *
 * @copyright Copyright (c) 2018 Flurrybox, Ltd. (https://flurrybox.com/)
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Flurrybox_EnhancedPrivacy_Helper_Data as Data;

/**
 * Class Flurrybox_EnhancedPrivacy_Model_Cron.
 */
class Flurrybox_EnhancedPrivacy_Model_Cron
{
    /**
     * @var Flurrybox_EnhancedPrivacy_Helper_Data|Mage_Core_Helper_Abstract
     */
    protected $helper;

    /**
     * Flurrybox_EnhancedPrivacy_Model_Cron constructor.
     */
    public function __construct()
    {
        $this->helper = Mage::helper('flurrybox_enhancedprivacy');
    }

    /**
     * Execute customer account cleanup.
     *
     * @return void
     */
    public function cleanup()
    {
        if (!$this->helper->isModuleEnabled() || !$this->helper->isDeleteEnabled()) {
            return;
        }

        Mage::register('isSecureArea', true);

        $cleanupSchedule = Mage::getModel('flurrybox_enhancedprivacy/cleanup')
            ->getCollection()
            ->addFieldToFilter('scheduled_at', array('lteq' => Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s')));

        foreach ($cleanupSchedule as $item) {
            try {
                $customer = Mage::getModel('customer/customer')->load($item->getData('customer_id'));

                $this->process($customer,$item->getType());
                $this->saveReason($item->getData('reason'));

                $item->delete();
            } catch (Exception $exception) {
                Mage::logException($exception);
            }
        }

        Mage::unregister('isSecureArea');
    }

    /**
     * Define processor classes.
     *
     * @return array
     */
    protected function getProcessors()
    {
        return [
            'flurrybox_enhancedprivacy/privacy_delete_customerAddress',
            'flurrybox_enhancedprivacy/privacy_delete_customerCompare',
            'flurrybox_enhancedprivacy/privacy_delete_customerData',
            'flurrybox_enhancedprivacy/privacy_delete_customerQuote',
            'flurrybox_enhancedprivacy/privacy_delete_customerReviews',
            'flurrybox_enhancedprivacy/privacy_delete_customerWishlist'
        ];
    }

    /**
     * Trigger customer data processors
     *
     * @param $customer
     * @param $type
     *
     * @return void
     */
    protected function process($customer, $type)
    {
        foreach ($this->mapProcessors($this->getProcessors()) as $processor) {
            if (!$processor instanceof Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_Abstract) {
                continue;
            }

            switch ($type) {
                case Data::SCHEDULE_TYPE_DELETE:
                    $processor->delete($customer);
                    break;

                case Data::SCHEDULE_TYPE_ANONYMIZE:
                    $processor->anonymize($customer);
                    break;
            }
        }
    }

    /**
     * Save delete reason
     *
     * @param $reason
     *
     * @return void
     */
    protected function saveReason($reason)
    {
        $model = Mage::getModel('flurrybox_enhancedprivacy/reason');
        $model->setData('reason',$reason);
        $model->save();
    }

    /**
     * Instantiate processor models.
     *
     * @param $processorClasses
     *
     * @return array
     */
    protected function mapProcessors($processorClasses)
    {
        $processors = [];

        foreach ($processorClasses as $class) {
            $processors[] = Mage::getModel($class);
        }

        return $processors;
    }
}
