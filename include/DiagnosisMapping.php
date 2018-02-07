<?php

class DiagnosisMapping {
	//PHYSICAL EXAM STUFF
	private $diagnosis_array = [
		"General/Laboratory",
		"General Appearance",
		"Skin",
		"Head",
		"Eyes",
		"Ears",
		"Nose/Sinuses",
		"Mouth/Pharynx",
		"Neck",
		"Chest",
		"Lungs",
		"Breasts",
		"Cardiac",
		"Vascular",
		"Abdomen",
		"Musculoskeletal",
		"Neurologic",
		"Psychiatric",
		"Genitalia/Rectum"
	];

	private $general_laboratory_array = [
		"Anemia",
		"Dehydration",
		"Diabetes",
		"Hypertension",
		"Overuse Muscle Pain",
		"Social Problem/Domestic Violence",
		"Upper Respiratory Infection",
		"Viral Syndrome"
	];

	private $general_appearance_array = [

	];

	private $skin_array = [
		"Eczema",
		"Impetigo",
		"Scabies",
		"Tinea"
	];

	private $head_array = [

	];

	private $eyes_array = [
		"Infectious Conjunctivitis",
		"Pterygium",
		"Vision Issue"
	];

	private $ears_array = [
		"Otitis Externa",
		"Otitis Media"
	];

	private $nose_sinuses_array = [

	];

	private $mouth_pharynx_array = [
		"Caries",
		"Gingivitis",
		"Pharyngitis",
		"Thrush"
	];

	private $neck_array = [

	];

	private $chest_array = [
		"Asthma",
		"Bronchitis",
		"Pneumonia"
	];

	private $lungs_array = [

	];

	private $breasts_array = [

	];

	private $cardiac_array = [

	];

	private $vascular_array = [

	];

	private $abdomen_array = [
		"Gastritis/Reflux",
		"Gastroenteritis",
		"Intestinal Parasites"
	];

	private $musculoskeletal_array = [
		"Arthritis",
		"Back Pain",
		"Traumatic Injury"
	];

	private $neurologic_array = [
		"Headache"
	];

	private $psychiatric_array = [
		"Depression",
		"Emotional Issue",
		"Suicidal"
	];

	private $genitalia_rectum_array = [
		"Pregnancy",
		"Urinary Tract Infection",
		"Vaginitis"
	];

	private $diagnosis_map;

	function __construct() {

		$this->diagnosis_map = [
			$this->general_laboratory_array,
			$this->general_appearance_array,
			$this->skin_array,
			$this->head_array,
			$this->eyes_array,
			$this->ears_array,
			$this->nose_sinuses_array,
			$this->mouth_pharynx_array,
			$this->neck_array,
			$this->chest_array,
			$this->lungs_array,
			$this->breasts_array,
			$this->cardiac_array,
			$this->vascular_array,
			$this->abdomen_array,
			$this->musculoskeletal_array,
			$this->neurologic_array,
			$this->psychiatric_array,
			$this->genitalia_rectum_array
		];

	}

	public function getDiagnosisOptions($type) {
		if($type == NULL) {
			return $this->diagnosis_array;
		} else {
			return $this->diagnosis_map[$type];
		}
	}



	
}



?>