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
 * Class Flurrybox_EnhancedPrivacy_Model_Privacy_Export_CustomerData.
 */
class Flurrybox_EnhancedPrivacy_Model_Privacy_Export_CustomerData extends
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
        $genders = [
            1 => 'Male',
            2 => 'Female',
            3 => 'Not Specified'
        ];

        $data[]   = [
            'PREFIX',
            'FIRST NAME',
            'MIDDLE NAME',
            'LAST NAME',
            'SUFFIX',
            'CREATED AT',
            'UPDATED AT',
            'EMAIL',
            'DATE OF BIRTH',
            'TAX VAT',
            'GENDER'
        ];

        $data[] = [
                $customer->getPrefix(),
                $customer->getFirstname(),
                $customer->getMiddlename(),
                $customer->getLastname(),
                $customer->getSuffix(),
                $customer->getCreatedAt(),
                $customer->getUpdatedAt(),
                $customer->getEmail(),
                $customer->getDob(),
                $customer->getTaxvat(),
                $genders[($customer->getGender() ?: 3)]
        ];

        return $data;
    }
}
