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
 * Class Flurrybox_EnhancedPrivacy_Helper_Data.
 */
class Flurrybox_EnhancedPrivacy_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Config XML paths
     */
    const CONF_GENERAL_ENABLE = 'customer/enhancedprivacy/general_enable';
    const CONF_INFORMATION_PAGE = 'customer/enhancedprivacy/information_page';
    const CONF_GENERAL_INFORMATION = 'customer/enhancedprivacy/general_information';
    const CONF_DELETE_ENABLE = 'customer/enhancedprivacy/delete_enable';
    const CONF_DELETE_SCHEMA = 'customer/enhancedprivacy/delete_schema';
    const CONF_DELETE_TIME = 'customer/enhancedprivacy/delete_time';
    const CONF_DELETE_SUCCESS = 'customer/enhancedprivacy/delete_success';
    const CONF_DELETE_INFO = 'customer/enhancedprivacy/delete_information';
    const CONF_DELETE_TITLE = 'customer/enhancedprivacy/delete_title';
    const CONF_DELETE_BUTTON_TEXT = 'customer/enhancedprivacy/delete_button_text';
    const CONF_DELETE_REASON = 'customer/enhancedprivacy/delete_reason';
    const CONF_ANONYMIZATION_ENABLE = 'customer/enhancedprivacy/anon_enable';
    const CONF_ANONYMIZATION_MESSAGE = 'customer/enhancedprivacy/anon_message';
    const CONF_EXPORT_ENABLE = 'customer/enhancedprivacy/export_enable';
    const CONF_EXPORT_INFORMATION = 'customer/enhancedprivacy/export_information';
    const CONF_POPUP_ENABLED = 'customer/enhancedprivacy/popup_enable';
    const CONF_POPUP_TEXT = 'customer/enhancedprivacy/popup_text';

    /**
     * Schedule types
     */
    const SCHEDULE_TYPE_DELETE = 'delete';
    const SCHEDULE_TYPE_ANONYMIZE = 'anonymize';

    /**
     * Cookie name
     */
    const COOKIE_COOKIES_POLICY = 'privacy-cookies-policy';

    /**
     * Anonymous values
     */
    const ANONYMOUS_STR = 'Anonymous';
    const ANONYMOUS_DATE = 1;

    /**
     * Check if module is enabled.
     *
     * @return string|null
     */
    public function isModuleEnabled()
    {
        return Mage::getStoreConfig(self::CONF_GENERAL_ENABLE);
    }

    /**
     * Get information page action.
     *
     * @return string|null
     */
    public function getInformationPage()
    {
        return Mage::getStoreConfig(self::CONF_INFORMATION_PAGE);
    }

    /**
     * Get general information.
     *
     * @return string|null
     */
    public function getGeneralInformation()
    {
        return Mage::getStoreConfig(self::CONF_GENERAL_INFORMATION);
    }

    /**
     * Check if deletion is enabled.
     *
     * @return int|null
     */
    public function isDeleteEnabled()
    {
        return Mage::getStoreConfig(self::CONF_DELETE_ENABLE);
    }

    /**
     * Get deletion schema.
     *
     * @return string|null
     */
    public function getDeleteSchema()
    {
        return Mage::getStoreConfig(self::CONF_DELETE_SCHEMA);
    }

    /**
     * Get deletion timer.
     *
     * @return int|null
     */
    public function getDeleteTime()
    {
        return Mage::getStoreConfig(self::CONF_DELETE_TIME) * 60;
    }

    /**
     * Get deletion success message.
     *
     * @return string|null
     */
    public function getDeleteSuccess()
    {
        return Mage::getStoreConfig(self::CONF_DELETE_SUCCESS);
    }

    /**
     * Get deletion information.
     *
     * @return string|null
     */
    public function getDeleteInformation()
    {
        return Mage::getStoreConfig(self::CONF_DELETE_INFO);
    }

    /**
     * Get deletion title.
     *
     * @return string|null
     */
    public function getDeleteTitle()
    {
        return Mage::getStoreConfig(self::CONF_DELETE_TITLE);
    }

    /**
     * Get delete button text.
     *
     * @return string|null
     */
    public function getDeleteButtonText()
    {
        return Mage::getStoreConfig(self::CONF_DELETE_BUTTON_TEXT);
    }

    /**
     * Get delete reason description.
     *
     * @return string|null
     */
    public function getDeleteReason()
    {
        return Mage::getStoreConfig(self::CONF_DELETE_REASON);
    }

    /**
     * Check if anonymization is enabled.
     *
     * @return int|null
     */
    public function isAnonymizationEnabled()
    {
        return Mage::getStoreConfig(self::CONF_ANONYMIZATION_ENABLE);
    }

    /**
     * Get anonymization message.
     *
     * @return string|null
     */
    public function getAnonymizationMessage()
    {
        return Mage::getStoreConfig(self::CONF_ANONYMIZATION_MESSAGE);
    }

    /**
     * Check if export is enabled.
     *
     * @return int|null
     */
    public function isExportEnabled()
    {
        return Mage::getStoreConfig(self::CONF_EXPORT_ENABLE);
    }

    /**
     * Get export information.
     *
     * @return string|null
     */
    public function getExportInformation()
    {
        return Mage::getStoreConfig(self::CONF_EXPORT_INFORMATION);
    }

    /**
     * Check if popup is enabled.
     *
     * @return int|null
     */
    public function isPopupEnabled()
    {
        return Mage::getStoreConfig(self::CONF_POPUP_ENABLE);
    }

    /**
     * Get popup text.
     *
     * @return string|null
     */
    public function getPopupText()
    {
        return Mage::getStoreConfig(self::CONF_POPUP_TEXT);
    }

    /**
     * Get cookie name.
     *
     * @return string
     */
    public function getCookieName()
    {
        return self::COOKIE_COOKIES_POLICY;
    }

    /**
     * Get ZIP path.
     *
     * @return string
     */
    public function getZipPath()
    {
        return Mage::getBaseDir('media') . '/privacy/';
    }

    /**
     * Check if customer has orders.
     *
     * @param $customerId
     *
     * @return bool
     */
    public function hasOrders($customerId)
    {
        return (bool) $this->getCustomerOrderCollection($customerId)->getSize();
    }

    /**
     * Get customer order collection.
     *
     * @param $customerId
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    private function getCustomerOrderCollection($customerId)
    {
        return Mage::getResourceModel('sales/order_collection')
            ->addFieldToSelect('customer_id','state')
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('state', array(
                'in' => Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates()
            ));
    }
}
