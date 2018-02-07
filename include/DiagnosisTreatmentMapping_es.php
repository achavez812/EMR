<?php

class DiagnosisTreatmentMapping_es {
	//PHYSICAL EXAM STUFF
	private $diagnosis_array = [
		"General/Laboratorio",
		"Apariencia General",
		"Piel",
		"Cabeza",
		"Ojos",
		"Orejas",
		"Nariz/Senos Paranasales",
		"Cara/Faringe",
		"Cuello",
		"Pecho",
		"Pulmones",
		"Cardíaco",
		"Vascular",
		"Abdomen",
		"Musculoesquelético",
		"Neurológico",
		"Psiquiátrico",
		"Genitales/Recto"
	];

	private $general_laboratory_diagnosis_array = [
		"Anemia",
		"Deshidración",
		"Diabetes",
		"Hipertensión",
		"Embarazada",
		"Problema Social/Violencia Doméstica"
	];

	private $general_appearance_diagnosis_array = [
		"Deshidración",
		"Letargo",
		"Desnutrido"
	];

	private $skin_diagnosis_array = [
		"Eczema",
		"Impétigo",
		"Sarna",
		"Tiña"
	];

	private $head_diagnosis_array = [
		"Eczema",
		"Impétigo",
		"Piojos",
		"Sarna",
		"Tiña"
	];

	private $eyes_diagnosis_array = [
		"Conjuntivitis Alérgica/Viral",
		"Conjuntivitis Bacteriana",
		"Catarata",
		"Abrasión Corneal",
		"Pterigión",
		"Problema de la Vista"
	];

	private $ears_diagnosis_array = [
		"Otitis Externa",
		"Otitis Media"
	];

	private $nose_sinuses_diagnosis_array = [
		"Infección Respiratoria Superior",
		"Síndrome Viral"
	];

	private $mouth_pharynx_diagnosis_array = [
		"Caries",
		"Gingivitis",
		"Faringitis",
		"Tordo",
		"Infección Respiratoria Superior",
		"Síndrome Viral"
	];

	private $neck_diagnosis_array = [
		"Dolor de Cuello"
	];

	private $chest_breasts_diagnosis_array = [
		"Dolor de Pecho Cardíaco (Urgente)",
		"Dolor de Pecho No Cardíaco"
	];

	private $lungs_diagnosis_array = [
		"Asma",
		"Bronquitis",
		"Neumonía"
	];

	private $cardiac_diagnosis_array = [
		"Dolor de Pecho Cardíaco (Urgente)",
		"Dolor de Pecho No Cardíaco"
	];

	private $vascular_diagnosis_array = [

	];

	private $abdomen_diagnosis_array = [
		"Amebiasis",
		"Gastritis/Reflujo",
		"Gastroenteritis",
		"Parásitos Intestinales"
	];

	private $musculoskeletal_diagnosis_array = [
		"Artritis",
		"Dolor de Espalda",
		"Herida traumática",
		"Dolor Muscular",
		"Dolor Muscular por Uso Excesivo"
	];

	private $neurologic_diagnosis_array = [
		"Dolor de Cabeza"
	];

	private $psychiatric_diagnosis_array = [
		"Depresión",
		"Problema Emocional",
		"Suicida"
	];

	private $genitalia_rectum_diagnosis_array = [
		"Vaginitis Bacteriana",
		"Embarazo",
		"Infección del Tracto Urinario",
		"Infección por Levaduras"
	];

	private $diagnosis_map;

	private $treatment_array = array(
		1 => "Multivitaminas con Hierro",
		2 => "Paquetes de Rehidratación Oral",
		3 => "Fluidos",
		4 => "Metformina",
		5 => "Glibenclamida",
		6 => "Metformina/Glibenclamida Combinación",
		7 => "Hidroclorotiazida",
		8 => "Ibuprofeno",
		9 => "Acetaminofeno",
		10 => "Naproxen",
		11 => "Vitaminas",
		12 => "Clotrimazol",
		13 => "Otro Antifúngico",
		14 => "Benzyl Benzoate",
		15 => "Permethrin",
		16 => "Ivermectina",
		17 => "Pomada Antibiótico",
		18 => "Antibiótico Oral: Cefalexina",
		19 => "Pomada de Hidrocortisona",
		20 => "Champú Medicado",
		21 => "Pomada Antibiótica Oftálmica",
		22 => "Gotas Antibióticas Oftálmicas",
		23 => "Gotas para Ojos (Visine)",
		24 => "Lagrimas Artificiales",
		25 => "Gotas Salinas",
		26 => "Lentes",
		27 => "Gafas de Sol",
		28 => "Gotas Óticas Antibióticas",
		29 => "Antibiótico Oral: Amoxicilina",
		30 => "Descongestionante",
		31 => "Cepillo de dientes",
		32 => "Pasta dental",
		33 => "Hilo dental",
		34 => "Antifúngico",
		35 => "Aspirina",
		36 => "Broncodilatador",
		37 => "Esteroides Inhalados",
		38 => "Esteroides Oral",
		39 => "Supresor de Tos",
		40 => "Antibiótico Oral: Azitromicina",
		41 => "Antiácidos/Tums",
		42 => "Antagonista H2 (Ranitidina)",
		43 => "Inhibidores de Bomba de Protones (Omeprazol)",
		44 => "Antibiótico Oral: Cipro",
		45 => "Antiprotozoario oral: Metronidazol",
		46 => "Antihelmíntico Oral: Albendazol",
		47 => "Oral Antihelmintic: Mebendazol",
		48 => "Materiales de Cuidado de Heridas",
		49 => "Oral Antifúngico",
		50 => "Antifúngico Vaginal",
		51 => "Antibiótico Oral: Trim/Sulfa",
		52 => "Vitaminas Prenatales",
		53 => "Vitaminas para Adultos",
		54 => "Vitaminas Infantiles"
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
			$this->pregnancy_treatment_array,
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
			null,
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