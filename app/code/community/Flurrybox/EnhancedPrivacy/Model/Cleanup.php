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
 * Class Flurrybox_EnhancedPrivacy_Model_Cleanup.
 */
class Flurrybox_EnhancedPrivacy_Model_Cleanup extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('flurrybox_enhancedprivacy/cleanup');
    }
}
