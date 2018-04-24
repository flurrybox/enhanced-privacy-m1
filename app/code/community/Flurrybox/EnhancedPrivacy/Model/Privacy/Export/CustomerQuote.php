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
 * Class Flurrybox_EnhancedPrivacy_Model_Privacy_Export_CustomerQuote.
 */
class Flurrybox_EnhancedPrivacy_Model_Privacy_Export_CustomerQuote extends
    Flurrybox_EnhancedPrivacy_Model_Privacy_Export_Abstract
{
    /**
     * Executed upon customer data export.
     *
     * Expected return structure:
     *      array(
     *          array('HEADER1', 'HEADER2', 'HEADER3', ...),
     *          array('VALUE1', 'VALUE2', 'VALUE3', ...),
     *          ...
     *      )
     *
     * @param $customer
     *
     * @return array
     */
    function export($customer)
    {
        $storeIds = Mage::app()->getWebsite($this->getWebsiteId())->getStoreIds();

        $quote = Mage::getModel('sales/quote')
            ->setSharedStoreIds($storeIds)
            ->loadByCustomer($customer);

        if ($quote) {
            $quoteCollection = $quote->getItemsCollection(false);
        } else {
            $quoteCollection = new Varien_Data_Collection();
        }

        $quoteCollection->addFieldToFilter('parent_item_id', array('null' => true));

        $data[] = ['PRODUCT NAME', 'SKU', 'QUANTITY', 'PRICE'];

        foreach ($quoteCollection as $item) {
            $data[] = [
                $item->getName(),
                $item->getSku(),
                $item->getQty(),
                $item->getPrice()
            ];
        }

        return $data;
    }
}
