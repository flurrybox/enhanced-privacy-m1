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
use Mage_Customer_Model_Group as Group;

/**
 * Class Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_CustomerData.
 */
class Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_CustomerData extends
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
        $customer->delete();
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
        $customer
            ->setPrefix(Data::ANONYMOUS_STR)
            ->setFirstname(Data::ANONYMOUS_STR)
            ->setMiddlename(Data::ANONYMOUS_STR)
            ->setLastname(Data::ANONYMOUS_STR)
            ->setSuffix(Data::ANONYMOUS_STR)
            ->setEmail($this->getAnonymousEmail($customer->getId()))
            ->setDob(Data::ANONYMOUS_DATE)
            ->setTaxvat(Data::ANONYMOUS_STR)
            ->setGender(0)
            ->setData('is_anonymized', true)
            ->setGroupId(Group::NOT_LOGGED_IN_ID)
            ->save();
    }

    /**
     * Get anonymized email.
     *
     * @param $customerId
     *
     * @return string
     */
    protected function getAnonymousEmail($customerId)
    {
        return uniqid($customerId) . '@' . Data::ANONYMOUS_STR . '.com';
    }

}