<?php

/**
 * @package Country flags
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0+
 */

namespace gplcart\modules\country_flag;

use gplcart\core\Module;

/**
 * Main class for Country flags module
 */
class CountryFlag extends Module
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Implements hook "library.list"
     * @param array $libraries
     */
    public function hookLibraryList(array &$libraries)
    {
        $libraries['flag-icon-css'] = array(
            'name' => /* @text */'Country flags',
            'description' => /* @text */'A collection of all country flags in SVG',
            'type' => 'asset',
            'module' => 'country_flag',
            'url' => 'https://github.com/lipis/flag-icon-css',
            'download' => 'https://github.com/lipis/flag-icon-css/archive/2.8.0.zip',
            'version_source' => array(
                'file' => 'vendor/flag-icon-css/package.json'
            ),
            'files' => array(
                'vendor/flag-icon-css/css/flag-icon.min.css'
            ),
        );
    }

    /**
     * Implements hook "country.get.after"
     * @param string $code
     * @param array $result
     */
    public function hookCountryGetAfter(&$code, &$result)
    {
        $code = strtolower($code);
        $images = $this->getFlagImages();
        if (isset($images[$code]['1x1']) && isset($result['code']) && !isset($result['image'])) {
            $result['image'] = $images[$code]['1x1'];
        }
    }

    /**
     * Implements hook "country.list"
     * @param array $list
     */
    public function hookCountryList(array &$list)
    {
        $images = $this->getFlagImages();

        foreach ($list as $code => &$country) {
            $code = strtolower($code);
            if (isset($images[$code]['1x1']) && !isset($country['image'])) {
                $country['image'] = $images[$code]['1x1'];
            }
        }
    }

    /**
     * Implements hook "module.enable.after"
     */
    public function hookModuleEnableAfter()
    {
        $this->getLibrary()->clearCache();
    }

    /**
     * Implements hook "module.disable.after"
     */
    public function hookModuleDisableAfter()
    {
        $this->getLibrary()->clearCache();
    }

    /**
     * Implements hook "module.install.after"
     */
    public function hookModuleInstallAfter()
    {
        $this->getLibrary()->clearCache();
    }

    /**
     * Implements hook "module.uninstall.after"
     */
    public function hookModuleUninstallAfter()
    {
        $this->getLibrary()->clearCache();
    }

    /**
     * Returns an array of country flag images keyed by country code
     */
    public function getFlagImages()
    {
        $list = &gplcart_static(__METHOD__);

        if (isset($list)) {
            return $list;
        }

        $list = array();
        foreach (glob(__DIR__ . '/vendor/flag-icon-css/flags/*/*.svg') as $file) {
            $info = pathinfo($file);
            $list[$info['filename']][basename($info['dirname'])] = $file;
        }

        return $list;
    }

}
