<?php

/**
 * @package Country flags
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0+
 */

namespace gplcart\modules\country_flag;

use gplcart\core\Library;

/**
 * Main class for Country flags module
 */
class CountryFlag
{

    /**
     * Library class instance
     * @var \gplcart\core\Library $library
     */
    protected $library;

    /**
     * @param Library $library
     */
    public function __construct(Library $library)
    {
        $this->library = $library;
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
    public function hookCountryGetAfter($code, &$result)
    {
        $this->setCountryFlag($code, $result);
    }

    /**
     * Implements hook "country.list"
     * @param array $countries
     */
    public function hookCountryList(array &$countries)
    {
        $this->setCountryFlags($countries);
    }

    /**
     * Implements hook "module.enable.after"
     */
    public function hookModuleEnableAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Implements hook "module.disable.after"
     */
    public function hookModuleDisableAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Implements hook "module.install.after"
     */
    public function hookModuleInstallAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Implements hook "module.uninstall.after"
     */
    public function hookModuleUninstallAfter()
    {
        $this->library->clearCache();
    }

    /**
     * Returns an array of country flag images keyed by country code
     */
    public function getCountryFlags()
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

    /**
     * Sets a country flag image
     * @param string $code
     * @param array $country
     */
    protected function setCountryFlag($code, array &$country)
    {
        $lower_code = strtolower($code);
        $images = $this->getCountryFlags();
        if (isset($images[$lower_code]['1x1']) && !isset($country['image'])) {
            $country['image'] = $images[$lower_code]['1x1'];
        }
    }

    /**
     * Sets flags for an array of images
     * @param array $countries
     */
    protected function setCountryFlags(array &$countries)
    {
        $images = $this->getCountryFlags();
        foreach ($countries as $code => &$country) {
            $code = strtolower($code);
            if (isset($images[$code]['1x1']) && !isset($country['image'])) {
                $country['image'] = $images[$code]['1x1'];
            }
        }
    }

}
