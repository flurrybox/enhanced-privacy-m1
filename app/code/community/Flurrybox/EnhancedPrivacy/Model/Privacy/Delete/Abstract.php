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
 * Class Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_Abstract.
 */
abstract class Flurrybox_EnhancedPrivacy_Model_Privacy_Delete_Abstract
{
    /**
     * Executed upon customer data deletion.
     *
     * @param $customer
     *
     * @return void
     */
    abstract function delete($customer);

    /**
     * Executed upon customer data anonymization.
     *
     * @param $customer
     *
     * @return void
     */
    abstract function anonymize($customer);
}
