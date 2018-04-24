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
 * Class Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_CustomerReviews.
 */
class Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_CustomerReviews extends
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
        $this->processReviews($customer->getId());
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
        $this->processReviews($customer->getId());
    }

    /**
     * Process review anonymization.
     *
     * @param $customerId
     *
     * @return void
     */
    protected function processReviews($customerId)
    {
        $reviews = Mage::getModel('review/review')
            ->getCollection()
            ->addFieldToFilter('customer_id',$customerId);

        foreach ($reviews as $review) {
            $review->setData('nickname', Flurrybox_EnhancedPrivacy_Helper_Data::ANONYMOUS_STR);
        }

        $reviews->walk('save');
    }
}
