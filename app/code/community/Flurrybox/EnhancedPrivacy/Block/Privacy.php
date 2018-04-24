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
 * Class Flurrybox_EnhancedPrivacy_Block_Privacy.
 */
abstract class Flurrybox_EnhancedPrivacy_Block_Privacy extends Mage_Core_Block_Template
{
    /**
     * @var Flurrybox_EnhancedPrivacy_Helper_Data
     */
    protected $helper;

    /**
     * Initialize block.
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();

        $this->helper = Mage::helper('flurrybox_enhancedprivacy');
    }

    /**
     * Get back action.
     *
     * @return string
     */
    public function getBackUrl()
    {
        return Mage::getUrl('*/*/', array('_secure' => true));
    }
}
