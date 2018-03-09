[![Build Status](https://scrutinizer-ci.com/g/gplcart/country_flag/badges/build.png?b=master)](https://scrutinizer-ci.com/g/gplcart/country_flag/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gplcart/country_flag/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gplcart/country_flag/?branch=master)

Country flags is a [GPL Cart](https://github.com/gplcart/gplcart) module that adds a collection of country flags in SVG format (see https://github.com/lipis/flag-icon-css).

Icons are automatically added to country data arrays:

	// Single item
    $country = \gplcart\core\models\Country::get($code);
    
	if(!empty($country['image])){
    	print_r($country['image]);
    }

	// Lists
    $countries = \gplcart\core\models\Country::getList();
    
    foreach($countries as $country){
    	if(!empty($country['image])){
      		print_r($country['image]);
       	}
    }


To get them manually call `\gplcart\modules\country_flag\CountryFlag::getFlagImages()`

**Installation**

This module requires 3-d party library which should be downloaded separately. You have to use [Composer](https://getcomposer.org) to download all the dependencies.

1. From your web root directory: `composer require gplcart/country_flag`. If the module was downloaded and placed into `system/modules` manually, run `composer update` to make sure that all 3-d party files are presented in the `vendor` directory.
2. Go to `admin/module/list` end enable the module