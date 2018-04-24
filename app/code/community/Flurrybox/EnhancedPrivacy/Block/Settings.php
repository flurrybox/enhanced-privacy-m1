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
 * Class Flurrybox_EnhancedPrivacy_Block_Settings.
 */
class Flurrybox_EnhancedPrivacy_Block_Settings extends Flurrybox_EnhancedPrivacy_Block_Privacy
{
    /**
     * Check if account has to be deleted.
     *
     * @return bool
     */
    public function isAccountToBeDeleted()
    {
        if (!($customerId = Mage::getSingleton('customer/session')->getCustomerId())) {
            return false;
        }

        $scheduled = Mage::getModel('flurrybox_enhancedprivacy/cleanup')
            ->load($customerId, 'customer_id');

        if ($scheduled->getId()) {
            return true;
        }

        return false;
    }

    /**
     * Get export url.
     *
     * @return string
     */
    public function getExportUrl()
    {
        return Mage::getUrl('privacy/account/export', array('_secure' => true));
    }

    /**
     * Get delete url.
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        if ($this->isAccountToBeDeleted()) {
            return Mage::getUrl('privacy/account/cancel', array('_secure' => true));
        }

        return Mage::getUrl('privacy/account/confirm', array('_secure' => true));
    }

    /**
     * Check if account should be anonymized instead of deleted.
     *
     * @return bool
     */
    public function shouldAnonymize()
    {
        return ($this->helper->getDeleteSchema() === Flurrybox_EnhancedPrivacy_Model_Config_Source_Schema::ANONYMIZE ||
                $this->hasOrders()) &&
            $this->helper->isAnonymizationEnabled();
    }

    /**
     * Check if customer has orders.
     *
     * @return bool
     */
    public function hasOrders()
    {
        if (!($customerId = Mage::getSingleton('customer/session')->getCustomerId())) {
            return false;
        }

        $collection = Mage::getModel('sales/order')->getCollection()
            ->addFieldToFilter('customer_id',$customerId);

        return $collection->getSize();
    }
}
