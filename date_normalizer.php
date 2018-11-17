<?php

//	Number format date-matcher -> return array['day'=>dd,'month'=>mm,'year'=>yy]
	class _number{

		public static function match($arr){

			foreach ($arr as $value) {

				$itsDay = intval(substr(date("Y"), -2)) <= $value;

				switch ($value) {

					case preg_match('/\d{4}/', $value) ? true:false:
						$date[2]=$value;
						break;
					case $itsDay ? true:false :
					 	$date[0]=$value;
					 	break;

					default:
						$date[1]=$value;
				}
			}
			return $date;
		}
	}

//	String format date-matcher -> return array['day'=>dd,'month'=>mm,'year'=>yy]

class _string{

		public static function match($value){

				$months= array('ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic');

				foreach ($months as $key => $element) {

					if(preg_match('/'.$months[$key].'/', $value)){

						preg_match_all('/(?<month>'.$months[$key].')|(?<year>\d{4,})|(?<day>\d{2,})/',$value,$match);

						foreach ($match['day'] as $value) {
							if (!empty($value)) {
									$day=$value;
								}

						}
						foreach ($match['month'] as $value) {
							if (!empty($value)){
									if ($key<9) {
											$month="0".strval($key+1);
									}else{  $month=$key+1; }
								}
						}
						foreach ($match['year'] as $value) {
							if (!empty($value)){
									$year=$value;
								}
						}
						return array($day,$month,$year);

					}
				}
		}
	}

//Main function

	function dn($value){

		$value = strtolower($value);
		switch ($value) {

			case preg_match('/\//', $value) ? true:false :

					$date = explode('/',$value);
					$date = _number::match($date);
				break;

			case preg_match('/\-/', $value) ? true:false :

					$date = explode('-',$value);
					$date = _number::match($date);
				break;

			case preg_match('/\./', $value) ? true:false :

					$date = explode('.',$value);
					$date = _number::match($date);
				break;

			case preg_match('/[a-z{3,}]/',$value) ? true:false :

					$date = _string::match($value);
				break;

			default:
				echo "It couldnt find any match for date format\n";

				$date = NULL;
				break;
		}
		if (!is_null($date)){
			return array('day'=>$date[0],'month' => $date[1], 'year' => $date[2]);
		}

	}

// DATE FORMAT TEST

	var_dump(dn("01/17/2016"));
	var_dump(dn("17/01/2016"));
	var_dump(dn("2016/17/01"));
	var_dump(dn("2016/01/17"));
	var_dump(dn("2016-01-17"));
	var_dump(dn("2016-17-01"));
	var_dump(dn("01-17-2016"));
	var_dump(dn("17-01-2016"));
	var_dump(dn("Enero,17 de 2016"));
	var_dump(dn("17 de Enero del 2016"));
	var_dump(dn("01.17.2016"));
	var_dump(dn("17.01.2016"));
	var_dump(dn("2016.01.17"));
	var_dump(dn("2016, 17 de Enero"));
	var_dump(dn("17 de Enero,2016"))

?>