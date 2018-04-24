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

class Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_CustomerQuote extends
    Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_Abstract
{
    /**
     * Executed upon customer data deletion.
     *
     * @param $customer
     *
     * @return void
     */
    function delete($customer)
    {
        $this->processQuote($customer->getId());
    }

    /**
     * Executed upon customer data anonymization.
     *
     * @param $customer
     *
     * @return void
     */
    function anonymize($customer)
    {
        $this->processQuote($customer->getId());
    }

    /**
     * Process quote deletion.
     *
     * @param $customerId
     *
     * @return void
     */
    protected function processQuote($customerId)
    {
        Mage::getModel('sales/quote')
            ->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('customer_id',$customerId)
            ->walk('delete');
    }
}
