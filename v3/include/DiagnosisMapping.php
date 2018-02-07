<?php

class DiagnosisMapping {

	private $main_map;
	private $main_options;

	function __construct() {

		$general_laboratory_array = [
			"19",
			"20",
			"21",
			"22",
			"23",
			"24"
		];

		$general_appearance_array = [
			"19",
			"25",
			"26"
		];

		$skin_array = [
			"27",
			"28",
			"29",
			"30"
		];

		$head_array = [
			"27",
			"28",
			"31",
			"29",
			"30"
		];

		$eyes_array = [
			"32",
			"33",
			"34",
			"35",
			"36",
			"37"
		];	

		$ears_array = [
			"38",
			"39"
		];

		$nose_sinuses_array = [
			"40",
			"41"
		];

		$mouth_pharynx_array = [
			"42",
			"43",
			"44",
			"45",
			"40",
			"41"
		];

		$neck_array = [
			"46"
		];

		$chest_breasts_array = [
			"47",
			"48"
		];

		$lungs_array = [
			"49",
			"50",
			"51"
		];

		$cardiac_array = [
			"47",
			"48"
		];

		$vascular_array = [

		];

		$abdomen_array = [
			"52",
			"53",
			"54",
			"55"
		];

		$musculoskeletal_array = [
			"56",
			"57",
			"58",
			"59",
			"60"
		];

		$neurologic_array = [
			"61"
		];

		$psychiatric_array = [
			"62",
			"63",
			"64"
		];

		$genitalia_rectum_array = [
			"65",
			"23",
			"66",
			"67"
		];

		$this->main_map = [
			"1" => $general_laboratory_array,
			"2" => $general_appearance_array,
			"3" => $skin_array,
			"4" => $head_array,
			"5" => $eyes_array,
			"6" => $ears_array,
			"7" => $nose_sinuses_array,
			"8" => $mouth_pharynx_array,
			"9" => $neck_array,
			"10" => $chest_breasts_array,
			"11" => $lungs_array,
			"12" => $cardiac_array,
			"13" => $vascular_array,
			"14" => $abdomen_array, 
			"15" => $musculoskeletal_array,
			"16" => $neurologic_array,
			"17" => $psychiatric_array,
			"18" => $genitalia_rectum_array
		];

		$this->main_options = [
			"56",
			"57",
			"20",
			"53",
			"22",
			"61",
			"59",
			"41"
		];

	}

	public function getFullMapping() {
		return $this->main_map;
	}

	public function getMainOptions() {
		return $this->main_options;

	}

}

?>