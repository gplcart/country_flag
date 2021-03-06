<?php

/**
 * @package Country flags
 * @author Iurii Makukh <gplcart.software@gmail.com>
 * @copyright Copyright (c) 2017, Iurii Makukh <gplcart.software@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0+
 */

namespace gplcart\modules\country_flag;

/**
 * Main class for Country flags module
 */
class Main
{

    /**
     * Implements hook "library.list"
     * @param array $libraries
     */
    public function hookLibraryList(array &$libraries)
    {
        $libraries['flag-icon-css'] = array(
            'name' => 'Country flags', // @text
            'description' => 'A collection of all country flags in SVG', // @text
            'type' => 'asset',
            'module' => 'country_flag',
            'url' => 'https://github.com/lipis/flag-icon-css',
            'download' => 'https://github.com/lipis/flag-icon-css/archive/2.8.0.zip',
            'version' => '2.8.0',
            'files' => array(
                'css/flag-icon.min.css'
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
     * Returns an array of country flag images keyed by country code
     */
    public function getCountryFlags()
    {
        $list = &gplcart_static(__METHOD__);

        if (isset($list)) {
            return $list;
        }

        $list = array();

        foreach (glob(GC_DIR_VENDOR_ASSET . '/flag-icon-css/flags/*/*.svg') as $file) {
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
