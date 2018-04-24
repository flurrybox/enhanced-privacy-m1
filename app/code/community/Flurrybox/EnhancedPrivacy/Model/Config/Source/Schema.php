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
 * Class Flurrybox_EnhancedPrivacy_Model_Config_Source_Schema.
 */
class Flurrybox_EnhancedPrivacy_Model_Config_Source_Schema
{
    const DELETE = 0;
    const ANONYMIZE = 1;
    const DELETE_ANONYMIZE = 2;

    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            self::DELETE => 'Always delete',
            self::ANONYMIZE => 'Always anonymize',
            self::DELETE_ANONYMIZE => 'Delete if no orders made, anonymize otherwise'
        ];
    }

    /**
     * Options getter.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];

        foreach ($this->getOptions() as $key => $value) {
            $options[] = ['value' => $key, 'label' => $value];
        }

        return $options;
    }

    /**
     * Get options in "key-value" format.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getOptions();
    }
}
