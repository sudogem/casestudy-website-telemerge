<?php
/**
 * @author		Arman Ortega <brainwired@gmail.com> 
 * @created		Nov 19 2006
 * @copyright	copyright 2006 primary offshore solutions
 */

class CountryList {
	
	function CountryList() {
		// nothing here ...
	}
	
	// we will put this countries to database.. later na lng sah..
	function getCountries() {
		$countries = array(
			'Any' => 'Any' ,
			'United States' => 'United States' ,
			'Canada' => 'Canada' ,
			'United Kingdom' => 'United Kingdom' ,
			'Australia' => 'Australia' ,
			'---' => '---' ,
			'Afghanistan' => 'Afghanistan' ,
			'Albania' => 'Albania' ,
			'Algeria' => 'Algeria' ,
			'American Samoa' => 'American Samoa' ,
			'Andorra' => 'Andorra' ,
			'Andorra' => 'Andorra' ,
			'Angola' => 'Angola' ,
			'Anguilla' => 'Anguilla' ,
			'Antarctica' => 'Antarctica' ,
			'Antigua and Barbuda' => 'Antigua and Barbuda' ,
			'Argentina' => 'Argentina' ,
			'Armenia' => 'Armenia' ,
			'Aruba' => 'Aruba' ,
			'Australia' => 'Australia' ,
			'Austria' => 'Austria' ,
			'Azerbaijan' => 'Azerbaijan' ,
			'Bahamas' => 'Bahamas' ,
			'Bahrain' => 'Bahrain' ,
			'Bangladesh' => 'Bangladesh' ,
			'Barbados' => 'Barbados' ,
			'Belarus' => 'Belarus' ,
			'Belgium' => 'Belgium' ,
			'Belize' => 'Belize' ,
			'Benin' => 'Benin' ,
			'Bermuda' => 'Bermuda' ,
			'Bhutan' => 'Bhutan' ,
			'Bissau' => 'Bissau' ,
			'Bolivia' => 'Bolivia' ,
			'Bosnia and Herzegovina' => 'Bosnia and Herzegovina' ,
			'Botswana' => 'Botswana' ,
			'Cambodia' => 'Cambodia' ,
			'Canada' => 'Canada' ,
			'China' => 'China' ,
			'Egypt' => 'Egypt' ,
			'France' => 'France' ,
			'Germany' => 'Germany' ,
			'Hong Kong' => 'Hong Kong' ,
			'Indonesia' => 'Indonesia' ,
			'Japan' => 'Japan' ,
			'Korea, Republic of' => 'Korea, Republic of' ,
			'Malaysia' => 'Malaysia' ,
			'Philippines' => 'Philippines' ,
			'Singapore' => 'Singapore' ,
			'Taiwan, Republic of China' => 'Taiwan, Republic of China' ,
			'Vietnam' => 'Vietnam' ,
			'Zimbabwe' => 'Zimbabwe'
		);
		return $countries;
	}
}
?>