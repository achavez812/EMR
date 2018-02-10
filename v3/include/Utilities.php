
<?php

class Utilities {

	function __construct() {

	}

    function endsWith($haystack, $needle) {
        $length = strlen($needle);

        return $length === 0 || (substr($haystack, -$length) === $needle);
    }

    public static function isAssoc($arr){
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public static function getExamLabel($value) {
        return EXAM_MAPPING[$value];
    }

	public static function getChiefComplaintLabel($value) {
        return DEFAULT_CHIEF_COMPLAINT_MAP[$value];
	}

    public static function isDefaultChiefComplaint($value) {
        return DEFAULT_CHIEF_COMPLAINT_MAP[$value] !== null;
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

    public static function convertCMtoIN($CM) {
        return round($CM * 0.3937, 1);
    }

    public static function convertINtoCM($IN) {
        return round($IN / 0.3937, 1);
    }

    public static function calculateBMI($weight_kg, $height_cm) {
        $height_m = $height_cm / 100.0;
        return round($weight_kg / ($height_m * $height_m), 1);
    }

    public static function getSexText($sex_value) {
    	if($sex_value == SEX_MALE) {
    		return MALE;
    	} else if ($sex_value == SEX_FEMALE) {
    		return FEMALE;
    	} else {
    		return UNKNOWN;
    	}
    }

    public static function formatDateForDisplay($date) {
    	$date_split = explode("-", substr($date, 0, 10));

    	$month_text = MONTH_ABBREVIATIONS[intval($date_split[1]) - 1];

    	return $month_text . " " . intval($date_split[2]) . ", " . $date_split[0];
    }

    public static function formatDateForDisplay2($date) {
        $date_split = explode("-", substr($date, 0, 10));

        $month_text = MONTH_ABBREVIATIONS[intval($date_split[1]) - 1];

        return $month_text . " " . $date_split[0];
    }

    public static function formatDateTimeForDisplay($date) {
    	$date_split = explode("-", substr($date, 0, 10));

    	$month_text = MONTH_ABBREVIATIONS[intval($date_split[1]) - 1];

    	return $month_text . " " . intval($date_split[2]) . ", " . $date_split[0];
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

    public static function isToday($date) {
    	if(!$date || strlen($date) < 10) {
    		return false;
    	}
    	$current_date = Utilities::getCurrentDate();
    	$current_date_split = explode('-', $current_date);

    	$date = str_replace('-', ' ', $date);
    	$date_split = explode(' ', $date);

    	$current_date_year = intval($current_date_split[0]);
    	$current_date_month = intval($current_date_split[1]);
    	$current_date_day = intval($current_date_split[2]);

    	$date_year = intval($date_split[0]);
    	$date_month = intval($date_split[1]);
    	$date_day = intval($date_split[2]);

    	return ($current_date_year == $date_year) && ($current_date_month == $date_month) && ($current_date_day == $date_day);
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

?>