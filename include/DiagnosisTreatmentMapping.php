<?php

class DiagnosisTreatmentMapping {
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
		"Chest/Breasts",
		"Lungs",
		"Cardiac",
		"Vascular",
		"Abdomen",
		"Musculoskeletal",
		"Neurologic",
		"Psychiatric",
		"Genitalia/Rectum"
	];

	private $general_laboratory_diagnosis_array = [
		"Anemia",
		"Dehydration",
		"Diabetes",
		"Hypertension",
		"Social Problem/Domestic Violence"
	];

	private $general_appearance_diagnosis_array = [
		"Dehydration",
		"Lethargy",
		"Malnourished"
	];

	private $skin_diagnosis_array = [
		"Eczema",
		"Impetigo",
		"Scabies",
		"Tinea"
	];

	private $head_diagnosis_array = [
		"Eczema",
		"Impetigo",
		"Lice",
		"Scabies",
		"Tinea"
	];

	private $eyes_diagnosis_array = [
		"Allergic/Viral Conjunctivitis",
		"Bacterial Conjunctivitis",
		"Cataract",
		"Corneal Abrasion",
		"Pterygium",
		"Vision Issue"
	];

	private $ears_diagnosis_array = [
		"Otitis Externa",
		"Otitis Media"
	];

	private $nose_sinuses_diagnosis_array = [
		"Upper Respiratory Infection",
		"Viral Syndrome"
	];

	private $mouth_pharynx_diagnosis_array = [
		"Caries",
		"Gingivitis",
		"Pharyngitis",
		"Thrush",
		"Upper Respiratory Infection",
		"Viral Syndrome"
	];

	private $neck_diagnosis_array = [
		"Neck Pain"
	];

	private $chest_breasts_diagnosis_array = [
		"Cardiac Chest Pain (Urgent)",
		"Non-Cardiac Chest Pain"
	];

	private $lungs_diagnosis_array = [
		"Asthma",
		"Bronchitis",
		"Pneumonia"
	];

	private $cardiac_diagnosis_array = [
		"Cardiac Chest Pain (Urgent)",
		"Non-Cardiac Chest Pain"
	];

	private $vascular_diagnosis_array = [

	];

	private $abdomen_diagnosis_array = [
		"Amoebiasis",
		"Gastritis/Reflux",
		"Gastroenteritis",
		"Intestinal Parasites"
	];

	private $musculoskeletal_diagnosis_array = [
		"Arthritis",
		"Back Pain",
		"Traumatic Injury",
		"Muscle Pain",
		"Overuse Muscle Pain"
	];

	private $neurologic_diagnosis_array = [
		"Headache"
	];

	private $psychiatric_diagnosis_array = [
		"Depression",
		"Emotional Issue",
		"Suicidal"
	];

	private $genitalia_rectum_diagnosis_array = [
		"Bacterial Vaginitis",
		"Pregnancy",
		"Urinary Tract Infection",
		"Yeast Infection"
	];

	private $diagnosis_map;

	private $treatment_array = array(
		1 => "Multivitamins with Iron",
		2 => "Oral Rehydration Packets",
		3 => "Fluids",
		4 => "Metformin",
		5 => "Glibenclamide",
		6 => "Metformin/Glibenclamide Combination",
		7 => "Hydrochlorothiazide",
		8 => "Ibuprofen",
		9 => "Acetamenophen",
		10 => "Naproxen",
		11 => "Vitamins",
		12 => "Clotrimazole",
		13 => "Antifungal Other",
		14 => "Benzyl Benzoate",
		15 => "Permethrin",
		16 => "Ivermectin",
		17 => "Antibiotic Ointment",
		18 => "Oral Antibiotic: Cephalexin",
		19 => "Hydrocortisone Ointment",
		20 => "Medicated Shampoo",
		21 => "Ophthalmic Antibiotic Ointment",
		22 => "Ophthalmic Antibiotic Drops",
		23 => "Eye Drops (Visine)",
		24 => "Artificial Tears",
		25 => "Saline Drops",
		26 => "Glasses",
		27 => "Sun Glasses",
		28 => "Otic Antibiotic Drops",
		29 => "Oral Antibiotic: Amoxicillin",
		30 => "Decongestant",
		31 => "Toothbrush",
		32 => "Toothpaste",
		33 => "Floss",
		34 => "Antifungal",
		35 => "Aspirin",
		36 => "Bronchodilator",
		37 => "Inhaled Steroids",
		38 => "Oral Steroids",
		39 => "Cough Suppressant",
		40 => "Oral Antibiotic: Azithromycin",
		41 => "Antacids/Tums",
		42 => "H2 Antogonist (Ranitidine)",
		43 => "PPI (Omeprazole)",
		44 => "Oral Antibiotic: Cipro",
		45 => "Oral Antiprotozoal: Metronidazole",
		46 => "Oral Antihelmintic: Albendazole",
		47 => "Oral Antihelmintic: Mebendazole",
		48 => "Wound Care Materials",
		49 => "Oral Antifungal",
		50 => "Vaginal Antifungal",
		51 => "Oral Antibiotic: Trim/Sulfa",
		52 => "Prenatal Vitamins",
		53 => "Adult Vitamins",
		54 => "Child Vitamins"
	);


	private $general_treatments = [
		53,
		54
	];

	private $treatment_map;

	private $general_laboratory_treatment_map;
	private $anemia_treatment_array = [
		1
	];
	private $dehydration_treatment_array = [
		3,
		2
	];
	private $diabetes_treatment_array = [
		5,
		4,
		6
	];
	private $hypertension_treatment_array = [
		7
	];
	
	private $social_problem_domestic_violence_treatment_array = [

	];

	private $general_appearance_treatment_map;

	private $lethargy_treatment_array = [
		2,
		11
	];

	private $malnourished_treatment_array = [
		3,
		2,
		11
	];

	private $skin_treatment_map;
	private $eczema_treatment_array = [
		19
	];
	private $impetigo_treatment_array = [
		17,
		18
	];
	private $scabies_treatment_array = [
		14,
		15,
		16
	];
	private $tinea_treatment_array = [
		12,
		13
	];

	private $head_treatment_map;

	private $lice_treatment_array = [
		20
	];

	private $eyes_treatment_map;
	private $allergic_viral_conjunctivitis_treatment_array = [
		23,
		24
	];
	private $bacterial_conjunctivitis_treatment_array = [
		22,
		21
	];
	private $conrneal_abrason_treatment_array = [
		22,
		21
	];
	private $pterygium_treatment_array = [
		25
	];
	private $vision_issue_treatment_array = [
		26,
		27
	];

	private $ears_treatment_map;
	private $otitis_externa_treatment_array = [
		28
	];
	private $otitis_media_treatment_array = [
		29
	];

	private $nose_sinuses_treatment_map;
	private $upper_respiratory_infection_treatment_array = [
		9,
		30,
		8
	];
	private $viral_syndrome_treatment_array = [
		9,
		30,
		8
	];

	private $mouth_pharynx_treatment_map;
	private $caries_treatment_array = [
		31,
		32,
		33
	];
	private $gingivitis_treatment_array = [
		31,
		32,
		33
	];
	private $pharyngitis_treatment_array = [
		9,
		29
	];
	private $thrush_treatment_array = [
		34
	];

	private $neck_treatment_map;
	private $neck_pain_treatment_array = [
		9,
		8
	];

	private $chest_breasts_treatment_map;
	private $cardiac_chest_pain_treatment_array = [
		35
	];
	private $non_cardiac_chest_pain_treatment_array = [
		8
	];

	private $lungs_treatment_map;
	private $asthma_treatment_array = [
		36,
		37,
		38
	];
	private $bronchitis_treatment_array = [
		36,
		39,
		8,
		29
	];
	private $pneumonia_treatment_array = [
		29,
		40
	];

	private $cardiac_treatment_map;

	private $vascular_treatment_map;

	private $abdomen_treatment_map;
	private $amoebiasis_treatment_array = [
		45
	];
	private $gastritis_reflux_treatment_array = [
		41,
		42,
		43
	];
	private $gastroenteritis_treatment_array = [
		44,
		45,
		2
	];
	private $intestinal_parasites_treatment_array = [
		46,
		47
	];

	private $musculoskeletal_treatment_map;
	private $arthritis_treatment_array = [
		9,
		8,
		10
	];
	private $back_pain_treatment_array = [
		9,
		8,
		10
	];	
	private $muscle_pain_treatment_array = [
		9,
		8,
		10
	];
	private $overuse_muscle_pain_treatment_array = [
		9,
		8,
		10
	];
	private $traumatic_injury_treatment_array = [
		9,
		8,
		10,
		48
	];

	private $neurologic_treatment_map;
	private $headache_treatment_array = [
		8
	];

	private $psychiatric_treatment_map;
	private $depression_treatment_array = [

	];
	private $emotional_issue_treatment_array = [

	];
	private $suicidal_treatment_array = [

	];

	private $genitalia_rectum_treatment_map;
	private $bacterial_vaginitis_treatment_array = [
		45
	];
	private $pregnancy_treatment_array = [
		52
	];
	private $urinary_tract_infection_treatment_array = [
		29,
		51
	];
	private $yeast_infection_treatment_array = [
		49,
		50
	];
	

	function __construct() {

		$this->diagnosis_map = [
			$this->general_laboratory_diagnosis_array,
			$this->general_appearance_diagnosis_array,
			$this->skin_diagnosis_array,
			$this->head_diagnosis_array,
			$this->eyes_diagnosis_array,
			$this->ears_diagnosis_array,
			$this->nose_sinuses_diagnosis_array,
			$this->mouth_pharynx_diagnosis_array,
			$this->neck_diagnosis_array,
			$this->chest_breasts_diagnosis_array,
			$this->lungs_diagnosis_array,
			$this->cardiac_diagnosis_array,
			$this->vascular_diagnosis_array,
			$this->abdomen_diagnosis_array,
			$this->musculoskeletal_diagnosis_array,
			$this->neurologic_diagnosis_array,
			$this->psychiatric_diagnosis_array,
			$this->genitalia_rectum_diagnosis_array
		];

		$this->general_laboratory_treatment_map = [
			$this->anemia_treatment_array,
			$this->dehydration_treatment_array,
			$this->diabetes_treatment_array,
			$this->hypertension_treatment_array,
			$this->social_problem_domestic_violence_treatment_array
		];

		$this->general_appearance_treatment_map = [
			$this->dehydration_treatment_array,
			$this->lethargy_treatment_array,
			$this->malnourished_treatment_array
		];

		$this->skin_treatment_map = [
			$this->eczema_treatment_array,
			$this->impetigo_treatment_array,
			$this->scabies_treatment_array,
			$this->tinea_treatment_array
		];

		$this->head_treatment_map = [
			$this->eczema_treatment_array,
			$this->impetigo_treatment_array,
			$this->lice_treatment_array,
			$this->scabies_treatment_array,
			$this->tinea_treatment_array
		];

		$this->eyes_treatment_map = [
			$this->allergic_viral_conjunctivitis_treatment_array,
			$this->bacterial_conjunctivitis_treatment_array,
			$this->conrneal_abrason_treatment_array,
			$this->pterygium_treatment_array,
			$this->vision_issue_treatment_array
		];

		$this->ears_treatment_map = [
			$this->otitis_externa_treatment_array,
			$this->otitis_media_treatment_array
		];

		$this->nose_sinuses_treatment_map = [
			$this->upper_respiratory_infection_treatment_array,
			$this->viral_syndrome_treatment_array
		];

		$this->mouth_pharynx_treatment_map = [
			$this->caries_treatment_array,
			$this->gingivitis_treatment_array,
			$this->pharyngitis_treatment_array,
			$this->thrush_treatment_array,
			$this->upper_respiratory_infection_treatment_array,
			$this->viral_syndrome_treatment_array
		];

		$this->neck_treatment_map = [
			$this->neck_pain_treatment_array
		];

		$this->chest_breasts_treatment_map = [
			$this->cardiac_chest_pain_treatment_array,
			$this->non_cardiac_chest_pain_treatment_array
		];

		$this->lungs_treatment_map = [
			$this->asthma_treatment_array,
			$this->bronchitis_treatment_array,
			$this->pneumonia_treatment_array
		];

		$this->cardiac_treatment_map = [
			$this->cardiac_chest_pain_treatment_array,
			$this->non_cardiac_chest_pain_treatment_array
		];

		$this->vascular_treatment_map = [

		];

		$this->abdomen_treatment_map = [
			$this->amoebiasis_treatment_array,
			$this->gastritis_reflux_treatment_array,
			$this->gastroenteritis_treatment_array,
			$this->intestinal_parasites_treatment_array
		];

		$this->musculoskeletal_treatment_map = [
			$this->arthritis_treatment_array,
			$this->back_pain_treatment_array,
			$this->muscle_pain_treatment_array,
			$this->overuse_muscle_pain_treatment_array,
			$this->traumatic_injury_treatment_array
		];

		$this->neurologic_treatment_map = [
			$this->headache_treatment_array
		];

		$this->psychiatric_treatment_map = [
			$this->depression_treatment_array,
			$this->emotional_issue_treatment_array,
			$this->suicidal_treatment_array
		];

		$this->genitalia_rectum_treatment_map = [
			$this->bacterial_vaginitis_treatment_array,
			$this->pregnancy_treatment_array,
			$this->urinary_tract_infection_treatment_array,
			$this->yeast_infection_treatment_array
		];

		$this->treatment_map = [
			$this->general_laboratory_treatment_map,
			$this->general_appearance_treatment_map,
			$this->skin_treatment_map,
			$this->head_treatment_map,
			$this->eyes_treatment_map,
			$this->ears_treatment_map,
			$this->nose_sinuses_treatment_map,
			$this->mouth_pharynx_treatment_map,
			$this->neck_treatment_map,
			$this->chest_breasts_treatment_map,
			$this->lungs_treatment_map,
			$this->cardiac_treatment_map,
			$this->vascular_treatment_map,
			$this->abdomen_treatment_map,
			$this->musculoskeletal_treatment_map,
			$this->neurologic_treatment_map,
			$this->psychiatric_treatment_map,
			$this->genitalia_rectum_treatment_map
		];

	}

	public function getDiagnosisOptions($category) {
		if($category === NULL) {
			return $this->diagnosis_array;
		} else {
			return $this->diagnosis_map[$category];
		}
	}

	public function getGeneralTreatments() {
		return $this->general_treatments;
	}

	public function getTreatmentOptions($diagnosis_category, $diagnosis_type) {
		return $this->treatment_map[$diagnosis_category][$diagnosis_type];
	}

	public function getTreatment($mapping_index) {
		return $this->treatment_array[$mapping_index];
	}

	
}



?>