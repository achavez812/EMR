<?php

class TreatmentMapping {

	private $main_map;

	private $general_treatments = [
		"53",
		"54"
	];

	//GENERAL & LABORATORY
	private $anemia_treatment_array = [
		"1"
	];
	private $dehydration_treatment_array = [
		"3",
		"2"
	];
	private $diabetes_treatment_array = [
		"5",
		"4",
		"6"
	];
	private $hypertension_treatment_array = [
		"55",
		"56",
		"57",
		"58",
		"59",
		"60",
		"7"
	];

	private $pregnant_treatment_array = [
		"52"
	];
	
	private $social_problem_domestic_violence_treatment_array = [

	];


	//GENERAL APPEARNCE
	private $lethargy_treatment_array = [
		"2",
		"11"
	];

	private $malnourished_treatment_array = [
		"3",
		"2",
		"11"
	];


	//SKIN
	private $eczema_treatment_array = [
		"19"
	];
	private $impetigo_treatment_array = [
		"17",
		"18"
	];
	private $scabies_treatment_array = [
		"14",
		"15",
		"16"
	];
	private $tinea_treatment_array = [
		"12",
		"13"
	];


	//HEAD
	private $lice_treatment_array = [
		"20"
	];


	//EYES
	private $allergic_viral_conjunctivitis_treatment_array = [
		"23",
		"24"
	];

	private $bacterial_conjunctivitis_treatment_array = [
		"22",
		"21"
	];

	private $cataract_treatment_array = [

	];

	private $corneal_abrasion_treatment_array = [
		"22",
		"21"
	];

	private $pterygium_treatment_array = [
		"25"
	];

	private $vision_issue_treatment_array = [
		"26",
		"27"
	];


	//EARS
	private $otitis_externa_treatment_array = [
		"28"
	];

	private $otitis_media_treatment_array = [
		"29"
	];


	//NOSE & SINUSES
	private $upper_respiratory_infection_treatment_array = [
		"9",
		"30",
		"8"
	];

	private $viral_syndrome_treatment_array = [
		"9",
		"30",
		"8"
	];


	//MOUTN & PHARYNX
	private $caries_treatment_array = [
		"31",
		"32",
		"33"
	];

	private $gingivitis_treatment_array = [
		"31",
		"32",
		"33"
	];

	private $pharyngitis_treatment_array = [
		"9",
		"29"
	];

	private $thrush_treatment_array = [
		"34"
	];


	//NECK
	private $neck_pain_treatment_array = [
		"9",
		"8"
	];


	//CHEST & BREAST
	private $cardiac_chest_pain_treatment_array = [
		"35"
	];

	private $non_cardiac_chest_pain_treatment_array = [
		"8"
	];


	//LUNGS
	private $asthma_treatment_array = [
		"36",
		"37",
		"38"
	];

	private $bronchitis_treatment_array = [
		"36",
		"39",
		"8",
		"29"
	];

	private $pneumonia_treatment_array = [
		"29",
		"40"
	];


	//CARDIAC
	//VASCULAR


	//ABDOMEN
	private $amoebiasis_treatment_array = [
		"45"
	];

	private $gastritis_reflux_treatment_array = [
		"41",
		"42",
		"43"
	];

	private $gastroenteritis_treatment_array = [
		"44",
		"45",
		"2"
	];

	private $intestinal_parasites_treatment_array = [
		"46",
		"47"
	];


	//MUSCULOSKELETAL
	private $arthritis_treatment_array = [
		"9",
		"8",
		"10"
	];

	private $back_pain_treatment_array = [
		"9",
		"8",
		"10"
	];	

	private $traumatic_injury_treatment_array = [
		"9",
		"8",
		"10",
		"48"
	];

	private $muscle_pain_treatment_array = [
		"9",
		"8",
		"10"
	];

	private $overuse_muscle_pain_treatment_array = [
		"9",
		"8",
		"10"
	];


	//NEURLOGIC
	private $headache_treatment_array = [
		"8"
	];


	//PSYCHIATRIC
	private $depression_treatment_array = [

	];

	private $emotional_issue_treatment_array = [

	];

	private $suicidal_treatment_array = [

	];


	//GENITALIA/RECTUM
	private $bacterial_vaginitis_treatment_array = [
		"45"
	];

	private $pregnancy_treatment_array = [
		"52"
	];

	private $urinary_tract_infection_treatment_array = [
		"29",
		"51"
	];

	private $yeast_infection_treatment_array = [
		"49",
		"50"
	];


	function __construct() {
		$this->main_map = [
			"19" => $this->anemia_treatment_array,
			"20" => $this->dehydration_treatment_array,
			"21" => $this->diabetes_treatment_array,
			"22" => $this->hypertension_treatment_array,
			"23" => $this->pregnant_treatment_array,
			"24" => $this->social_problem_domestic_violence_treatment_array,
			"25" => $this->lethargy_treatment_array,
			"26" => $this->malnourished_treatment_array,
			"27" => $this->eczema_treatment_array,
			"28" => $this->impetigo_treatment_array,
			"29" => $this->scabies_treatment_array,
			"30" => $this->tinea_treatment_array,
			"31" => $this->lice_treatment_array,
			"32" => $this->allergic_viral_conjunctivitis_treatment_array,
			"33" => $this->bacterial_conjunctivitis_treatment_array,
			"34" => $this->cataract_treatment_array,
			"35" => $this->corneal_abrasion_treatment_array,
			"36" => $this->pterygium_treatment_array,
			"37" => $this->vision_issue_treatment_array,
			"38" => $this->otitis_externa_treatment_array,
			"39" => $this->otitis_media_treatment_array,
			"40" => $this->upper_respiratory_infection_treatment_array,
			"41" => $this->viral_syndrome_treatment_array,
			"42" => $this->caries_treatment_array,
			"43" => $this->gingivitis_treatment_array,
			"44" => $this->pharyngitis_treatment_array,
			"45" => $this->thrush_treatment_array,
			"46" => $this->neck_pain_treatment_array,
			"47" => $this->cardiac_chest_pain_treatment_array,
			"48" => $this->non_cardiac_chest_pain_treatment_array,
			"49" => $this->asthma_treatment_array,
			"50" => $this->bronchitis_treatment_array,
			"51" => $this->pneumonia_treatment_array,
			"52" => $this->amoebiasis_treatment_array,
			"53" => $this->gastritis_reflux_treatment_array,
			"54" => $this->gastroenteritis_treatment_array,
			"55" => $this->intestinal_parasites_treatment_array,
			"56" => $this->arthritis_treatment_array,
			"57" => $this->back_pain_treatment_array,
			"58" => $this->traumatic_injury_treatment_array,
			"59" => $this->muscle_pain_treatment_array,
			"60" => $this->overuse_muscle_pain_treatment_array,
			"61" => $this->headache_treatment_array,
			"62" => $this->depression_treatment_array,
			"63" => $this->emotional_issue_treatment_array,
			"64" => $this->suicidal_treatment_array,
			"65" => $this->bacterial_vaginitis_treatment_array,
			"66" => $this->urinary_tract_infection_treatment_array,
			"67" => $this->yeast_infection_treatment_array
		];
	}

	public function getFullMapping() {
		return $this->main_map;
	}

	public function getGeneralTreatments() {
		return $this->general_treatments;
	}

}

?>
