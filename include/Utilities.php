

<?php

class Utilities
{

    function __construct()
    {

    }

    public static function convertLBtoKG($LB) {
        return round($LB / 2.2046, 1);
    }

    public static function convertKGtoLB($KG) {
        return round($KG * 2.2046, 1);
    }

    public static function convertFtoC($F) {
        return round(($F - 32) * (5.0 / 9.0), 1);
    }

    public static function convertCtoF($C) {
        return round(($C * (9.0 / 5.0)) + 32, 1);
    }

    public static function reformatDateForDisplay($date) {
    	$date_split = explode("-", substr($date, 0, 10));

    	return intval($date_split[1]) . "/" . intval($date_split[2]) . "/" . $date_split[0];
    }

    public static function reformatDateForDisplay2($date) {
        $date_split = explode("-", substr($date, 0, 10));

        return intval($date_split[1]) . "/" . intval($date_split[2]) . "/" . substr($date_split[0], 2, 2);
    }

    public static function reformatDateTimeForDisplay($datetime) {
        $date_part = Utilities::reformatDateForDisplay2($datetime);
        $time_part = explode(":", substr($datetime, 11, 5));

        $hour_part = intval($time_part[0]);
        //$minute_part = intval($time_part[1]);

        $extra_text = ($hour_part > 11) ? 'pm' : 'am';
        if ($hour_part === 0) {
            $hour_part = 12;
        } else if ($hour_part > 12) {
            $hour_part = $hour_part - 12;
        }

        return $date_part . " " . $hour_part . ":" . $time_part[1] . $extra_text;
    }

    public static function convertAgeYearsToDateOfBirth($age_years) {
    	$current_date = substr(Utilities::getCurrentDateTime(), 0, 10);

    	$date_split = explode("-", $current_date);

    	$year = intval($date_split[0]);

    	$new_year = $year - $age_years;

    	return $new_year . "-" . $date_split[1] . "-" . $date_split[2];
    }

    public static function getAgeInYears($date_of_birth) {
        $age_months = Utilities::getTimeBetweenInMonths($date_of_birth, Utilities::getCurrentDateTime());
        $age_int = intval($age_months / 12);
        return $age_int;
    }

    public static function getCurrentAgeString($date_of_birth, $lang) {
        $years = " Years";
        $months = " Months";
        if($lang == "es") {
            $years = " Años";
            $months = " Meses";
        }

    	$age_months = Utilities::getTimeBetweenInMonths($date_of_birth, Utilities::getCurrentDateTime());
    	$age_int = intval($age_months / 12);
    	if ($age_months >= 24) {
    		return $age_int . $years ;
    	} else {
    		$months_remaining = $age_months - ($age_int * 12);
    		return $age_int . $years . " " .  $months_remaining . $months;
    	}
    }

    public static function getTimeBetweenInMonths($date1, $date2) {
    	$date1 = str_replace('-', ' ', $date1);
    	$date2 = str_replace('-', ' ', $date2);

    	$date1_split = explode(' ', $date1);
    	$date2_split = explode(' ', $date2);

    	$year1 = intval($date1_split[0]);
    	$month1 = intval($date1_split[1]);
    	$day1 = intval($date1_split[2]);

    	$year2 = intval($date2_split[0]);
    	$month2 = intval($date2_split[1]);
    	$day2 = intval($date2_split[2]);

    	$year_difference = $year2 - $year1;
    	$month_difference = $month2 - $month1;
    	$day_difference = $day2 - $day1;

    	$total_months = $year_difference * 12;
    	$total_months += $month_difference;
    	if ($day_difference < 0) {
    		$total_months--;
    	}

    	return $total_months;
    }


    public static function getCurrentDateTime() {
    	date_default_timezone_set("America/Guatemala");
    	return date("Y-m-d H:i:s");
    }

    public static function getCurrentDate() {
        date_default_timezone_set("America/Guatemala");
        return date("Y-m-d");
    }

}