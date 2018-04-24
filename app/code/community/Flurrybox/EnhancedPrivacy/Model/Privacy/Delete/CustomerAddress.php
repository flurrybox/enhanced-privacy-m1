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
 * Class Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_CustomerAddress.
 */
class Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_CustomerAddress extends
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
        foreach ($customer->getAddresses() as $address) {
            $address->delete();
        }
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
        foreach ($customer->getAddresses() as $address) {
            $address
                ->setCity(Data::ANONYMOUS_STR)
                ->setCompany(Data::ANONYMOUS_STR)
                ->setCountryId(1)
                ->setFax(Data::ANONYMOUS_STR)
                ->setPrefix(Data::ANONYMOUS_STR)
                ->setFirstname(Data::ANONYMOUS_STR)
                ->setLastname(Data::ANONYMOUS_STR)
                ->setMiddlename(Data::ANONYMOUS_STR)
                ->setSuffix(Data::ANONYMOUS_STR)
                ->setPostcode(Data::ANONYMOUS_STR)
                ->setRegion(Data::ANONYMOUS_STR)
                ->setStreet([
                    Data::ANONYMOUS_STR,
                    Data::ANONYMOUS_STR
                ])
                ->setTelephone(Data::ANONYMOUS_STR)
                ->save();
        }
    }
}
