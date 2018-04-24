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
 * Class Flurrybox_EnhancedPrivacy_Model_Export.
 */
class Flurrybox_EnhancedPrivacy_Model_Export
{
    /**
     * @var Flurrybox_EnhancedPrivacy_Helper_Data
     */
    protected $helper;

    /**
     * Flurrybox_EnhancedPrivacy_Model_Export constructor.
     */
    public function __construct()
    {
        $this->helper = Mage::helper('flurrybox_enhancedprivacy');
    }

    /**
     * Export customer data.
     *
     * @return void
     */
    public function export()
    {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $date = $this->getDateStamp();

        $path = $this->helper->getZipPath();

        if (!is_dir($path)){
            mkdir($path);
        }

        $zipFileName = 'customer_data_'.$date.'.zip';
        $files = [];

        foreach ($this->mapProcessors($this->getProcessors()) as $name => $processor) {
            if (!$processor instanceof Flurrybox_EnhancedPrivacy_Model_Privacy_Export_Abstract) {
                continue;
            }

            $fileName = $name .'_'. $date .'.csv';
            $this->createCsv($fileName,$processor->export($customer));

            $files[] = $fileName;
        }

        $this->pack($files, $zipFileName);
        $this->prepareDownload($zipFileName);
    }

    /**
     * Create Csv File.
     *
     * @param $fileName
     * @param $data
     *
     * @return void
     */
    protected function createCsv($fileName, $data)
    {
        $handle = fopen($this->helper->getZipPath().$fileName, 'w+');

        foreach ($data as $line) {
            fputcsv($handle, $line);
        }
    }

    /**
     * Download Zip File.
     *
     * @param $zipFileName
     *
     * @return void
     */
    protected function prepareDownload($zipFileName)
    {
        if (file_exists($this->helper->getZipPath().$zipFileName)) {
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
            readfile($this->helper->getZipPath() . $zipFileName);

            $this->deleteFile($this->helper->getZipPath() . $zipFileName);
            exit;
        }
    }

    /**
     * Define processor names and classes
     *
     * @return array
     */
    protected function getProcessors()
    {
        return [
            'customer_address' => 'flurrybox_enhancedprivacy/privacy_export_customerAddress',
            'customer_data' => 'flurrybox_enhancedprivacy/privacy_export_customerData',
            'customer_quote' => 'flurrybox_enhancedprivacy/privacy_export_customerQuote',
            'customer_review' => 'flurrybox_enhancedprivacy/privacy_export_customerReviews',
            'customer_wishlist' => 'flurrybox_enhancedprivacy/privacy_export_customerWishlist'
        ];
    }

    /**
     * Create Zip File.
     *
     * @param array $files
     * @param $zipFileName
     *
     * @return void
     */
    protected function pack($files = [], $zipFileName)
    {
        if (empty($files)) {
            return;
        }

        $zip = new ZipArchive();

        foreach ($files as $file) {
            if ($zip->open($this->helper->getZipPath() . $zipFileName, ZipArchive::CREATE) !== true) {
                return;
            }

            $zip->addFile($this->helper->getZipPath() . $file, $file);
        }

        $zip->close();
        $this->deleteExportFiles($files);
    }

    /**
     * Delete temporary export files.
     * 
     * @param $files
     *
     * @return void
     */
    protected function deleteExportFiles($files)
    {
        foreach($files as $file) {
            $this->deleteFile($this->helper->getZipPath() . $file);
        }
    }

    /**
     * Delete file.
     *
     * Works only on UNIX-like systems.
     *
     * @param $fileName
     *
     * @return void
     */
    protected function deleteFile($fileName)
    {
        @unlink($fileName);
    }

    /**
     * Get current time stamp.
     *
     * @return false|string
     */
    protected function getDateStamp()
    {
        return date('Y-m-d_h-i-s', strtotime('now'));
    }

    /**
     * Instantiate processor models
     *
     * @param $processorClasses
     * @return array
     */
    protected function mapProcessors($processorClasses = [])
    {
        $processors = [];

        foreach ($processorClasses as $name => $class) {
            $processors[$name] = Mage::getModel($class);
        }

        return $processors;
    }
}
