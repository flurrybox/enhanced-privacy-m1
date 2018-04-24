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
 * Class Flurrybox_EnhancedPrivacy_Model_Privacy_Export_CustomerWishlist.
 */
class Flurrybox_EnhancedPrivacy_Model_Privacy_Export_CustomerWishlist extends
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
        $collection = Mage::getModel('wishlist/item')
            ->getCollection()
            ->addCustomerIdFilter($customer->getId());

        $data[] = ['PRODUCT NAME', 'ADDED AT', 'QUANTITY', 'DESCRIPTION'];

        foreach ($collection as $item) {
            $data[] = [
                $item->getProductId(),
                $item->getAddedAt(),
                $item->getQty(),
                $item->getDescription()
            ];
        }

        return $data;
    }
}
