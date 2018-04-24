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

/**
 * Class Flurrybox_EnhancedPrivacy_AccountController.
 */
class Flurrybox_EnhancedPrivacy_AccountController extends Mage_Core_Controller_Front_Action
{
    /**
     * Customer Privacy Configuration.
     *
     * @return void
     */
    public function indexAction()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('customer/account/login');
            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Export customer data.
     *
     * @return void
     */
    public function exportAction()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('customer/account/login');
            return;
        }

        try {
            $export = Mage::getModel('flurrybox_enhancedprivacy/export');
            $export->export();

            $this->getSession()->addSuccess("Data exported successfully.");
        } catch (Exception $exception) {
            $this->getSession()->addException($exception,'Something went wrong, please try again later!');
            Mage::logException($exception);
        }

        $this->getResponse()->setRedirect(Mage::getUrl('*/*/success'));
    }

    /**
     * Account delete confirmation.
     *
     * @return void
     */
    public function confirmAction()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('customer/account/login');
            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Schedule account deletion or anonymization
     *
     * @return void
     */
    public function deleteAction()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('customer/account/login');
            return;
        }

        $customer = $this->getCustomerSession()->getCustomer();
        $params = $this->getRequest()->getParams();
        $helper = Mage::helper('flurrybox_enhancedprivacy');

        try {
            $email = $customer->getEmail();
            $websiteId = Mage::app()->getWebsite()->getId();
            $auth = Mage::getModel('customer/customer')
                ->setWebsiteId($websiteId)
                ->authenticate($email, $params['password']);

            if ($auth) {
                $schedule = Mage::getModel('flurrybox_enhancedprivacy/cleanup');
                $timestamp = Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s',time() + $helper->getDeleteTime());

                $data = [
                    'scheduled_at' => $timestamp,
                    'customer_id' => $customer->getId(),
                    'reason' => $params['reason']
                ];

                $schedule->setData($data);

                switch ($helper->getDeleteSchema()) {
                    case Flurrybox_EnhancedPrivacy_Model_Config_Source_Schema::DELETE:
                        $schedule->setData('type', Flurrybox_EnhancedPrivacy_Helper_Data::SCHEDULE_TYPE_DELETE);
                        break;

                    case Flurrybox_EnhancedPrivacy_Model_Config_Source_Schema::ANONYMIZE:
                        $schedule->setData('type', Flurrybox_EnhancedPrivacy_Helper_Data::SCHEDULE_TYPE_ANONYMIZE);
                        break;

                    case Flurrybox_EnhancedPrivacy_Model_Config_Source_Schema::DELETE_ANONYMIZE:
                        $schedule->setData(
                            'type',
                            $helper->hasOrders($customer->getId()) ?
                                Flurrybox_EnhancedPrivacy_Helper_Data::SCHEDULE_TYPE_ANONYMIZE :
                                Flurrybox_EnhancedPrivacy_Helper_Data::SCHEDULE_TYPE_DELETE
                        );
                        break;
                }

                $schedule->save();
                $this->getSession()->addSuccess($helper->getDeleteSuccess());
            }
        } catch (Exception $exception) {
            $this->getSession()->addException($exception,'Something went wrong, please try again later!');
            Mage::logException($exception);
        }

        $this->getResponse()->setRedirect(Mage::getUrl('*/*/'));
    }

    /**
     * Cancel account delete.
     *
     * @return void
     */
    public function cancelAction()
    {
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->_redirect('customer/account/login');
            return;
        }

        try {
            $customer = $this->getCustomerSession()->getCustomer();
            $cleanupItem = Mage::getModel('flurrybox_enhancedprivacy/cleanup')
                ->load($customer->getId(),'customer_id');
            $cleanupItem->delete();
            $this->getSession()->addSuccess("Account deletion has been canceled.");
        } catch(Exception $exception) {
            $this->getSession()->addException($exception,'Something went wrong, please try again later!');
            Mage::logException($exception);
        }

        $this->getResponse()->setRedirect(Mage::getUrl('*/*/'));
    }

    /**
     * Get session.
     *
     * @return Mage_Core_Model_Abstract|Mage_Core_Model_Session
     */
    protected function getSession()
    {
        return Mage::getSingleton('core/session');
    }

    /**
     * Get customer session.
     *
     * @return Mage_Core_Model_Abstract|Mage_Customer_Model_Session
     */
    protected function getCustomerSession()
    {
        return Mage::getSingleton('customer/session');
    }
}
