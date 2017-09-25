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

1. Download and extract to `system/modules` manually or using composer `composer require gplcart/country_flag`. IMPORTANT: If you downloaded the module manually, be sure that the name of extracted module folder doesn't contain a branch/version suffix, e.g `-master`. Rename if needed.
2. Go to `admin/module/list` end enable the module