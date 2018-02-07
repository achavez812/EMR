
<?php

class ExamDiagnosisTreatmentMapping {


	private $exam_category_array = [
	    "Specialty",
	    "Skin",
	    "Eyes",
	    "Ears",
	    "Nose",
	    "Oral",
	    "Throat",
	    "Chest",
	    "Cardiac",
	    "Abdomen",
	    "Genitourinary",
	    "Musculoskeletal",
	    "Neurologic"
	];

	private $diagnosis_category_array = [
	    "General",
	    "Specialty",
	    "Skin",
	    "Eyes",
	    "Ears",
	    "Nose",
	    "Oral",
	    "Throat",
	    "Chest",
	    "Cardiac",
	    "Abdomen",
	    "Genitourinary",
	    "Musculoskeletal",
	    "Neurologic"
	];

	private $exam_option_array; 
	
	private $diagnosis_option_array;

	private $treatment_option_array;

	private $treatment_general_option_array;

	private $treatment_specialty_option_array;

	private $treatment_skin_option_array;

	private $treatment_eyes_option_array;

	private $treatment_ears_option_array;

	private $treatment_nose_option_array;

	private $treatment_oral_option_array;

	private $treatment_throat_option_array;

	private $treatment_chest_option_array;

	private $treatment_cardiac_option_array;
	
	private $treatment_abdomen_option_array;

	private $treatment_genitourinary_option_array;

	private $treatment_musculoskeletal_option_array;

	private $treatment_neurologic_option_array;

	//EXAM STUFF
	private $exam_specialty_array = [
		"NORMAL",
	    "Blood",
	    "Urine",
	    "Feces",
	    "Other"
	];

	private $exam_skin_array = [
		"NORMAL",
	    "Rash",
	    "Other"
	];

	private $exam_eyes_array = [
		"NORMAL",
	    "Conjunctivitis",
	    "Refractive",
	    "Vision",
	    "Other"
	];

	private $exam_ears_array = [
		"NORMAL",
	    "Canal",
	    "Tympanic Membrane",
	    "Other"
	];

	private $exam_nose_array = [
		"NORMAL",
	    "Congestion",
	    "Other"
	];

	private $exam_oral_array = [
		"NORMAL",
	    "Dental",
	    "Lesion",
	    "Other"
	];

	private $exam_throat_array = [
		"NORMAL",
	    "Pharyngitis",
	    "Enlarged Tonsils",
	    "Other"
	];

	private $exam_chest_array = [
		"NORMAL",
	    "Wheezes",
	    "Rales",
	    "Other"
	];

	private $exam_cardiac_array = [
		"NORMAL",
	    "Murmur",
	    "Arrhythmia",
	    "Other"
	];

	private $exam_abdomen_array = [
		"NORMAL",
	    "Tenderness",
	    "Hepatomegaly",
	    "Splenomegaly",
	    "Other"
	];

	private $exam_genitourinary_array = [
		"NORMAL",
	    "External Erythema",
	    "Discharge",
	    "Lesion",
	    "Other"
	];

	private $exam_musculoskeletal_array = [
		"NORMAL",
	    "Joint Swelling",
	    "Joint Sensitivity",
	    "Reduced Ranged of Motion",
	    "Other"
	];

	private $exam_neurologic_array = [
		"NORMAL",
	    "General Apperance",
	    "Mental Status",
	    "Cranial Nerves",
	    "Motor",
	    "Sensory",
	    "Reflexes",
	    "Coordination/Gait",
	    "Other"
	];

	//DIAGNOSIS STUFF
	private $diagnosis_general_array = [
	    "Anemia",
	    "Dehydration",
	    "Diabetes",
	    "Hypertension",
	    "Overuse Muscle Pain",
	    "Upper Respiratory Infection",
	    "Viral Syndrome",
	    "Social Problem / Domestic Violence",
	    "Other"
	];

	private $diagnosis_specialty_array = [
		"Other"
	];

	private $diagnosis_skin_array = [
	    "Tinea",
	    "Scabies",
	    "Impetigo",
	    "Eczema",
	    "Other"
	];

	private $diagnosis_eyes_array = [
	    "Infectious Conjunctivitis",
	    "Pterygium",
	    "Vision Issue",
	    "Other"
	];

	private $diagnosis_ears_array = [
	    "Otitis Externa",
	    "Otitis Media",
	    "Other"
	];

	private $diagnosis_nose_array = [
		"Other"
	];

	private $diagnosis_oral_array = [
	    "Caries",
	    "Thrush",
	    "Other"
	];

	private $diagnosis_throat_array = [
	    "Pharyngitis",
	    "Other"
	];

	private $diagnosis_chest_array = [
	    "Pneuomnia",
	    "Bronchitis",
	    "Asthma",
	    "Other"
	];

	private $diagnosis_cardiac_array = [
		"Other"
	];

	private $diagnosis_abdomen_array = [
	    "Gastritis/Reflux",
	    "Gastroenteritis",
	    "Intestinal Parasites",
	    "Other"
	];

	private $diagnosis_genitourinary_array = [
	    "Urinary Tract Infection",
	    "Pregnancy",
	    "Vaginitis",
	    "Other"
	];

	private $diagnosis_musculoskeletal_array = [
	    "Arthritis",
	    "Back Pain",
	    "Traumatic Injury",
	    "Other"
	];

	private $diagnosis_neurologic_array = [
	    "Headache",
	    "Emotional Issue",
	    "Other"
	];

	//GENERAL TREATMENT 
	private $treatment_anemia_array = [
	    "Multivitamins with Iron",
	    "Other"
	];

	private $treatment_dehydration_array = [
	    "Oral Rehydration Packets",
	    "Fluids",
	    "Other"
	];

	private $treatment_diabetes_array = [
	    "Metformin",
	    "Glibenclamide",
	    "Other"
	];

	private $treatment_hypertension_array = [
	    "Hydrochlorothiazide",
	    "Other"
	];

	private $treatment_overuse_muscle_painarray = [
	    "Ibuprofen",
	    "Acetomenophen",
	    "Naproxen",
	    "Other"
	];

	private $treatment_upper_respiratory_infection_array = [
	    "Ibuprofen",
	    "Acetomenophen",
	    "Decongestant",
	    "Other"
	];

	private $treatment_viral_syndrome_array = [
	    "Ibuprofen",
	    "Acetomenophen",
	    "Other"
	];

	private $treatment_social_problem_domestic_violence_array = [
		"Other"
	];

	//SPECIALTY TREATMENT
	//NONE

	//SKIN TREATMENT 
	private $treatment_tinea_array = [
	    "Clortrimazole",
	    "Other"
	];

	private $treatment_scabies_array = [
	    "Benzyl Benzoate",
	    "Permethrin",
	    "Ivermectin",
	    "Other"
	];

	private $treatment_impetigo_array = [
	    "Antibiotic Ointment",
	    "Oral Antibiotic: Cephalexin",
	    "Oral Antibiotic: Other",
	    "Other"
	];

	private $treatment_eczema_array = [
	    "Hydrocortisone Ointment",
	    "Other"
	];

	//EYES TREATMENT 
	private $treatment_infection_conjunctivitis_array = [
	    "Ophthalmic Antibiotic Ointment/Drops",
	    "Steroid Ointment/Drops",
	    "Other"
	];

	private $treatment_pterygium_array = [
	    "Saline Drops",
	    "Steroid Ointment/Drops",
	    "Other"
	];
	        
	private $treatment_vision_issue_array = [
		"Other"
	];

	//EARS TREATMENT
	private $treatment_otitis_externa_array = [
	    "Otic Antibiotic Drops",
	    "Other"
	];

	private $treatment_otitis_media_array = [
	    "Oral Antibiotic: Amoxicillin",
	    "Oral Antibiotic: Other",
	    "Other"
	];

	//NOSE TREATMENT
	//NONE

	//ORAL TREATMENT  
	private $treatment_caries_array = [
		"Other"
	];

	private $treatment_thrush_array = [
		"Other"
	];


	//THROAT TREATMENT
	private $treatment_pharyngitis_array = [
	    "Oral Antibiotic: Amoxicillin",
	    "Oral Antibiotic: Other",
	    "Other"
	];

	//CHEST TREATMENT  
	private $treatment_pneumonia_array = [
	    "Oral Antibiotic: Amoxicillin",
	    "Oral Antibiotic: Other",
	    "Other"
	];

	private $treatment_bronchitis_array = [
	    "Oral Antibiotic: Amoxicillin",
	    "Oral Antibiotic: Other",
	    "Cough Suppressant",
	    "Bronchodilator",
	    "Other"
	];

	private $treatment_asthma_array = [
	    "Bronchodilator",
	    "Inhaled Steroids",
	    "Oral Steroids",
	    "Other"
	];

	//CARDIAC TREATMENT  
	//NONE

	//ABDOMEN TREATMENT  
	private $treatment_gastritis_reflux_array = [
	    "Antacids",
	    "Ranitidine",
	    "Lansoprazole/Omeprazole",
	    "Other"
	];

	private $treatment_gastroenteritis_array = [
	    "Oral Rehydration Packets",
	    "Oral Antibiotics: Cipro",
	    "Oral Antibiotics: Trim/Sulfa",
	    "Oral Antibiotics: Other",
	    "Oral Antiprotozoal: Metronidazole",
	    "Oral Antiprotozoal: Other",
	    "Other"
	];

	private $treatment_intestinal_parasites_array = [
	    "Oral Antihelmintic: Albendazole",
	    "Oral Antihelmintic: Other",
	    "Other"
	];

	//GENITOURINARY TREATMENT 
	private $treatment_urinary_tract_infection_array = [
	    "Oral Antibiotic: Amoxicillin",
	    "Oral Antibiotic: Trim/Sulfa",
	    "Oral Antibiotic: Other",
	    "Other"
	];

	private $treatment_pregnancy_array = [
	    "Prenatal Vitamins",
	    "Other"
	];

	private $treatment_vaginitis_array = [
	    "Metronidazole",
	    "Other"
	];

	//MUSCULOSKELETAL TREATMENT ARRAY
	private $treatment_arthritis_array = [
	    "Ibuprofen",
	    "Naproxen",
	    "Other"
	];

	private $treatment_back_pain_array = [
	    "Ibuprofen",
	    "Naproxen",
	    "Other"
	];

	private $treatment_traumatic_injury_array = [
		"Other"
	];

	//NEUROLOGIC TREATMENT 
	private $treatment_headache_array = [
	    "Ibuprofen",
	    "Other"
	];

	private $treatment_emotional_issue_array = [
		"Other"
	];

	
	function __construct() {

		$this->treatment_general_option_array = [
			$this->treatment_anemia_array,
			$this->treatment_dehydration_array,
			$this->treatment_diabetes_array,
			$this->treatment_hypertension_array,
			$this->treatment_overuse_muscle_painarray,
			$this->treatment_upper_respiratory_infection_array,
			$this->treatment_viral_syndrome_array,
			$this->treatment_social_problem_domestic_violence_array
		];

		$this->treatment_specialty_option_array = [];

		$this->treatment_skin_option_array = [
			$this->treatment_tinea_array,
			$this->treatment_scabies_array,
			$this->treatment_impetigo_array,
			$this->treatment_eczema_array
		];

		$this->treatment_eyes_option_array = [
			$this->treatment_infection_conjunctivitis_array,
			$this->treatment_pterygium_array,
			$this->treatment_vision_issue_array
		];

		$this->treatment_ears_option_array = [
			$this->treatment_otitis_externa_array,
			$this->treatment_otitis_media_array
		];

		$this->treatment_nose_option_array = [];

		$this->treatment_oral_option_array = [
			$this->treatment_caries_array,
			$this->treatment_thrush_array
		];

		$this->treatment_throat_option_array = [
			$this->treatment_pharyngitis_array
		];

		$this->treatment_chest_option_array = [
			$this->treatment_pneumonia_array,
			$this->treatment_bronchitis_array,
			$this->treatment_asthma_array
		];

		$this->treatment_cardiac_option_array = [];
		
		$this->treatment_abdomen_option_array = [
			$this->treatment_gastritis_reflux_array,
			$this->treatment_gastroenteritis_array,
			$this->treatment_intestinal_parasites_array
		];

		$this->treatment_genitourinary_option_array = [
			$this->treatment_urinary_tract_infection_array,
			$this->treatment_pregnancy_array,
			$this->treatment_vaginitis_array
		];

		$this->treatment_musculoskeletal_option_array = [
			$this->treatment_arthritis_array,
			$this->treatment_back_pain_array,
			$this->treatment_traumatic_injury_array
		];

		$this->treatment_neurologic_option_array = [
			$this->treatment_headache_array,
			$this->treatment_emotional_issue_array
		];

		$this->exam_option_array = [
	        $this->exam_specialty_array,
			$this->exam_skin_array,
			$this->exam_eyes_array,
			$this->exam_ears_array,
			$this->exam_nose_array,
			$this->exam_oral_array,
			$this->exam_throat_array,
			$this->exam_chest_array,
			$this->exam_cardiac_array,
			$this->exam_abdomen_array,
			$this->exam_genitourinary_array,
			$this->exam_musculoskeletal_array,
			$this->exam_neurologic_array
		];
	
		$this->diagnosis_option_array = [
			$this->diagnosis_general_array,
	        $this->diagnosis_specialty_array,
			$this->diagnosis_skin_array,
			$this->diagnosis_eyes_array,
			$this->diagnosis_ears_array,
			$this->diagnosis_nose_array,
			$this->diagnosis_oral_array,
			$this->diagnosis_throat_array,
			$this->diagnosis_chest_array,
			$this->diagnosis_cardiac_array,
			$this->diagnosis_abdomen_array,
			$this->diagnosis_genitourinary_array,
			$this->diagnosis_musculoskeletal_array,
			$this->diagnosis_neurologic_array
		];

		$this->treatment_option_array = [
			$this->treatment_general_option_array,
	        $this->treatment_specialty_option_array,
			$this->treatment_skin_option_array,
			$this->treatment_eyes_option_array,
			$this->treatment_ears_option_array,
			$this->treatment_nose_option_array,
			$this->treatment_oral_option_array,
			$this->treatment_throat_option_array,
			$this->treatment_chest_option_array,
			$this->treatment_cardiac_option_array,
			$this->treatment_abdomen_option_array,
			$this->treatment_genitourinary_option_array,
			$this->treatment_musculoskeletal_option_array,
			$this->treatment_neurologic_option_array
		];

		
	}

	public function convertExamIndexToDiagnosisIndex($exam_index) {
		return $exam_index + 1;
	}

	public function getExamCategories() {
		return $this->exam_category_array;
	}

	public function getDiagnosisCategories() {
		return $this->diagnosis_category_array;
	}

	public function getExamOptions($exam_category_index) {
		if (isset($this->exam_option_array[$exam_category_index])) {
			return $this->exam_option_array[$exam_category_index];
		}
		return [];
	}

	public function getDiagnosisOptions($diagnosis_category_index) {
		if (isset($this->diagnosis_option_array[$diagnosis_category_index])) {
			return $this->diagnosis_option_array[$diagnosis_category_index];
		}
		return [];
	}

	public function getTreatmentOptions($treatment_category_index, $treatment_option_index) {
		if (isset($this->treatment_option_array[$treatment_category_index])) {
			$treatment_array = $this->treatment_option_array[$treatment_category_index];
			if (isset($treatment_array[$treatment_option_index])) {
				return $treatment_array[$treatment_option_index];
			} 
		} 
		return [];
	}
	
	





}

?>