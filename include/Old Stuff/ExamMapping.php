<?php


class ExamMapping {

	private $physical_exam_option_array;
	private $physical_exam_map;
	private $physical_exam_map2;
	private $physical_exam_map3;

	private $general_appearance_option_array;

	private $skin_option_array;
	private $skin_map;
	private $skin_option1_map;
	private $skin_option2_map;

	private $head_option_array;
	private $eyes_option_array;
	private $ears_option_array;
	private $nose_sinuses_option_array;
	private $mouth_pharynx_option_array;
	private $neck_option_array;
	private $chest_option_array;
	private $lungs_option_array;
	private $breasts_option_array;
	private $cardiac_option_array;
	private $vascular_option_array;
	private $abdomen_option_array;

	private $musculoskeletal_option_array;
	private $musculoskeletal_map;
	private $musculoskeletal_map2;



	private $musculoskeletal_option1_map;
	private $musculoskeletal_option2_map;
	private $musculoskeletal_option3_map;
	private $musculoskeletal_option3_map2;
	private $musculoskeletal_option3_option1_map;
	private $musculoskeletal_option3_option2_map;
	private $musculoskeletal_option3_option3_map;
	private $musculoskeletal_option3_option4_map;
	private $musculoskeletal_option4_map;
	private $musculoskeletal_option4_map2;
	private $musculoskeletal_option4_option1_map;
	private $musculoskeletal_option4_option2_map;
	private $musculoskeletal_option4_option3_map;
	private $musculoskeletal_option4_option4_map;
	private $musculoskeletal_option5_map;
	private $musculoskeletal_option5_map2;
	private $musculoskeletal_option5_option1_map;
	private $musculoskeletal_option5_option2_map;
	private $musculoskeletal_option5_option3_map;
	private $musculoskeletal_option5_option4_map;
	private $musculoskeletal_option6_map;
	private $musculoskeletal_option6_map2;
	private $musculoskeletal_option6_option1_map;
	private $musculoskeletal_option6_option2_map;
	private $musculoskeletal_option6_option3_map;
	private $musculoskeletal_option6_option4_map;

	private $neurologic_option_array;
	private $neurologic_map;
	private $neurologic_option2_map;
	private $neurologic_option3_map;

	private $genitalia_rectum_option_array;

	private $no_yes_other_array = [
		"No (Normal)",
		"Yes",
		"Other"
	];

	private $normal_abnormal_other_array = [
		"Normal",
		"Abnormal",
		"Other"
	];

	private $skin_location_array = [
		"Normal",
		"Face",
		"Neck",
		"Shoulders",
		"Chest",
		"Abdomen",
		"Back (Upper)",
		"Back (Lower)",
		"Arms",
		"Hands",
		"Legs",
		"Feet",
		"Other"
	];

	private $skin_lesions_array = [
		"None (Normal)",
		"Raised",
		"Pustules",
		"Vesicles",
		"Other"
	];

	private $lungs_options_array = [
		"Good Air Movement (Normal)",
		"Wheezes",
		"Consolidation",
		"Rhonchi/Rales",
		"Other"
	];

	private $abdomen_options_array = [
		"No (Normal)",
		"Yes",
		"Murphys",
		"Other"
	];

	private $musculoskeletal_options_array = [
		"Normal",
		"Pain",
		"Range of Motion",
		"Other"
	];

	private $musculoskeletal_range_of_motion_array = [
		"Intact (Normal)",
		"Not Intact",
		"Other"
	];

	private $musculoskeletal_upper_extremities_array = [
		"Normal",
		"Shoulders",
		"Elbows",
		"Wrists",
		"Fingers",
		"Other"
	];

	private $musculoskeletal_lower_extremities_array = [
		"Normal",
		"Hips",
		"Knees",
		"Ankles",
		"Feet",
		"Other"
	];

	private $neurologic_options_array = [
		"Normal",
		"RUE",
		"LUE",
		"RLE",
		"LLE",
		"Other"
	];

	private $exam_type_array = [
	    "Physical",
	    "Laboratory"
	];

	//LABORATORY EXAM
	private $laboratory_exam_category_array = [
		"Blood",
		"Feces",
		"Urine",
		"Other"
	];

	//PHYSICAL EXAM
	private $physical_exam_category_array = [
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
		"Genitalia/Rectum"
	];

	//PHySICAL EXAM: GENERAL APPEARANCE
	private $general_appearance_array = [
		"Normal",
		"Ill",
		"In Pain",
		"Lethargic",
		"Other"
	];

	private $general_appearance_option1_array;

	private $general_appearance_option2_array;

	private $general_appearance_option3_array;

	private $general_appearance_other_array;

	//PHYSICAL EXAM: SKIN
	private $skin_array = [
		"Normal",
		"Skin Color",
		"Lesions",
		"Other"
	];

	private $skin_option1_array;

	private $skin_option1_option1_array;

	private $skin_option1_option2_array;

	private $skin_option1_option3_array;

	private $skin_option1_option4_array;

	private $skin_option1_option5_array;

	private $skin_option1_option6_array;

	private $skin_option1_option7_array;

	private $skin_option1_option8_array;

	private $skin_option1_option9_array;

	private $skin_option1_option10_array;

	private $skin_option1_option11_array;

	private $skin_option1_other_array;

	private $skin_option2_array;

	private $skin_option2_option1_array;

	private $skin_option2_option2_array;

	private $skin_option2_option3_array;

	private $skin_option2_option4_array;

	private $skin_option2_option5_array;

	private $skin_option2_option6_array;

	private $skin_option2_option7_array;

	private $skin_option2_option8_array;

	private $skin_option2_option9_array;

	private $skin_option2_option10_array;

	private $skin_option2_option11_array;

	private $skin_option2_other_array;

	private $skin_other_array;

	//PHYSICAL EXAM: HEAD
	private $head_array = [
		"Normal",
		"Lesions to Scalp",
		"Fontanelles",
		"Other"
	];

	private $head_option1_array;

	private $head_option2_array = [
		"Normal",
		"Sunken",
		"Other"
	];

	private $head_other_array;

	//PHYSICAL EXAM: EYES
	private $eyes_array = [
		"Normal",
		"Acuity",
		"Eyelids",
		"Sclera",
		"Conjuctivae",
		"Pupils",
		"Extraocular Movements",
		"Drainage",
		"Other"
	];

	private $eyes_option1_array;

	private $eyes_option2_array = [
		"Normal",
		"Red",
		"Pustule",
		"Other"
	];

	private $eyes_option3_array = [
		"Normal",
		"Red",
		"Lesion",
		"Other"
	];

	private $eyes_option4_array = [
		"Normal",
		"Injected",
		"Other"
	];

	private $eyes_option5_array = [
		"Normal",
		"Sluggish",
		"Asymmetric",
		"Other"

	];

	private $eyes_option6_array = [
		"Intact (Normal)",
		"Not Intact",
		"Other"
	];

	private $eyes_option7_array;

	private $eyes_other_array;

	//PHYSICAL EXAM: EARS
	private $ears_array = [
		"Normal",
		"Outer Ear",
		"Canal",
		"Tympanic Membrane",
		"Light Reflex",
		"Other"
	];

	private $ears_option1_array = [
		"Normal",
		"Red",
		"Lesion",
		"Painful Movement",
		"Other"
	];

	private $ears_option2_array = [
		"Normal",
		"Red",
		"Inflamed",
		"Cerumen",
		"Other"
	];

	private $ears_option3_array = [
		"Normal",
		"Red",
		"Inflamed",
		"Fluid",
		"Other"
	];

	private $ears_option4_array;

	private $ears_other_array;

	//PHYSICAL EXAM: NOSE/SINUSES
	private $nose_sinuses_array = [
		"Normal",
		"Rhonorrhea",
		"Sinus Tenderness",
		"Other"
	];

	private $nose_sinuses_option1_array;

	private $nose_sinuses_option2_array;

	private $nose_sinuses_other_array;

	//PHYSICAL EXAM: MOUTH/PHARYNX
	private $mouth_pharynx_array = [
		"Normal",
		"Buccal/Oral Mucosa",
		"Condition of Teeth/Gums",
		"Pharynx/Tonsils",
		"Other"
	];

	private $mouth_pharynx_option1_array = [
		"Normal",
		"Moist",
		"Dry",
		"Lesions",
		"Other"
	];

	private $mouth_pharynx_option2_array = [
		"Normal",
		"Carries/Poor",
		"Inflamed",
		"Other"
	];

	private $mouth_pharynx_option3_array = [
		"Normal",
		"Erythematous",
		"Tonsillar Exudates",
		"Pharyngeal Erythema",
		"Other"
	];

	private $mouth_pharynx_other_array;

	//PHYSICAL EXAM: NECK
	private $neck_array = [
		"Normal",
		"Range of Motion",
		"Throat Pain to Palpation",
		"Lymph Nodes",
		"Other"
	];

	private $neck_option1_array = [
		"Normal",
		"Impaired",
		"Other"
	];

	private $neck_option2_array;

	private $neck_option3_array = [
		"Palpable (Normal)",
		"Not Palpable",
		"Other"
	];

	private $neck_other_array;

	//PHYSICAL EXAM: CHEST
	private $chest_array = [
		"Normal",
		"Tenderness",
		"Lesions",
		"Other"
	];

	private $chest_option1_array;

	private $chest_option2_array = [
		"None (Normal)",
		"Yes",
		"Other"
	];

	private $chest_other_array;

	//PHYSICAL EXAM: LUNGS
	private $lungs_array = [
		"Normal",
		"Right",
		"Left",
		"Other"
	];

	private $lungs_option1_array;

	private $lungs_option2_array;

	private $lungs_other_array;

	//PHYSICAL EXAM: BREASTS
	private $breasts_array = [
		"Normal",
		"Abnormal",
		"Other"
	];

	//PHYSICAL EXAM: CARDIAC
	private $cardiac_array = [
		"Regular (Normal)",
		"Irregular",
		"Murmurs",
		"Other"
	];

	//PHYSICAL EXAM: VASCULAR
	private $vascular_array = [
		"Normal",
		"Pulses",
		"Carotid",
		"Femoral",
		"Radial",
		"Presence of Edema",
		"Other"
	];

	private $vascular_option1_array;

	private $vascular_option2_array;

	private $vascular_option3_array;

	private $vascular_option4_array;

	private $vascular_option5_array = [
		"None (Normal)",
		"Bilateral",
		"Unilateral Right",
		"Unilateral Left",
		"Other"
	];

	private $vascular_other_array;

	//PHYSICAL EXAM: ABDOMEN
	private $abdomen_array = [
		"Normal",
		"Hepatomegaly",
		"Splenomegaly",
		"LUQ Pain",
		"LLQ Pain",
		"RUQ Pain",
		"RLQ Pain",
		"Guarding",
		"Rebound",
		"Other"
	];

	private $abdomen_option1_array;

	private $abdomen_option2_array;

	private $abdomen_option3_array;

	private $abdomen_option4_array;

	private $abdomen_option5_array;

	private $abdomen_option6_array;

	private $abdomen_option7_array;

	private $abdomen_option8_array;

	private $abdomen_other_array;

	//PHYSICAL EXAM: MUSCULOSKELETAL
	private $musculoskeletal_array = [
		"Normal",
		"Neck",
		"Spine",
		"Upper Extremities Right",
		"Upper Extremities Left",
		"Lower Extremities Right",
		"Lower Extremities Left",
		"Other"
	];

	private $musculoskeletal_option1_array;

	private $musculoskeletal_option1_option1_array;

	private $musculoskeletal_option1_option2_array;

	private $musculoskeletal_option1_other_array;


	private $musculoskeletal_option2_array;

	private $musculoskeletal_option2_option1_array;

	private $musculoskeletal_option2_option2_array;

	private $musculoskeletal_option2_other_array;


	private $musculoskeletal_option3_array;

	private $musculoskeletal_option3_option1_array;

	private $musculoskeletal_option3_option1_option1_array;

	private $musculoskeletal_option3_option1_option2_array;

	private $musculoskeletal_option3_option1_other_array;

	private $musculoskeletal_option3_option2_array;

	private $musculoskeletal_option3_option2_option1_array;

	private $musculoskeletal_option3_option2_option2_array;

	private $musculoskeletal_option3_option2_other_array;

	private $musculoskeletal_option3_option3_array;

	private $musculoskeletal_option3_option3_option1_array;

	private $musculoskeletal_option3_option3_option2_array;

	private $musculoskeletal_option3_option3_other_array;

	private $musculoskeletal_option3_option4_array;

	private $musculoskeletal_option3_option4_option1_array;

	private $musculoskeletal_option3_option4_option2_array;

	private $musculoskeletal_option3_option4_other_array;

	private $musculoskeletal_option3_other_array;


	private $musculoskeletal_option4_array;

	private $musculoskeletal_option4_option1_array;

	private $musculoskeletal_option4_option1_option1_array;

	private $musculoskeletal_option4_option1_option2_array;

	private $musculoskeletal_option4_option1_other_array;

	private $musculoskeletal_option4_option2_array;

	private $musculoskeletal_option4_option2_option1_array;

	private $musculoskeletal_option4_option2_option2_array;

	private $musculoskeletal_option4_option2_other_array;

	private $musculoskeletal_option4_option3_array;

	private $musculoskeletal_option4_option3_option1_array;

	private $musculoskeletal_option4_option3_option2_array;

	private $musculoskeletal_option4_option3_other_array;

	private $musculoskeletal_option4_option4_array;

	private $musculoskeletal_option4_option4_option1_array;

	private $musculoskeletal_option4_option4_option2_array;

	private $musculoskeletal_option4_option4_other_array;

	private $musculoskeletal_option4_other_array;


	private $musculoskeletal_option5_array;

	private $musculoskeletal_option5_option1_array;

	private $musculoskeletal_option5_option1_option1_array;

	private $musculoskeletal_option5_option1_option2_array;

	private $musculoskeletal_option5_option1_other_array;

	private $musculoskeletal_option5_option2_array;

	private $musculoskeletal_option5_option2_option1_array;

	private $musculoskeletal_option5_option2_option2_array;

	private $musculoskeletal_option5_option2_other_array;

	private $musculoskeletal_option5_option3_array;

	private $musculoskeletal_option5_option3_option1_array;

	private $musculoskeletal_option5_option3_option2_array;

	private $musculoskeletal_option5_option3_other_array;

	private $musculoskeletal_option5_option4_array;

	private $musculoskeletal_option5_option4_option1_array;

	private $musculoskeletal_option5_option4_option2_array;

	private $musculoskeletal_option5_option4_other_array;

	private $musculoskeletal_option5_other_array;


	private $musculoskeletal_option6_array;

	private $musculoskeletal_option6_option1_array;

	private $musculoskeletal_option6_option1_option1_array;

	private $musculoskeletal_option6_option1_option2_array;

	private $musculoskeletal_option6_option1_other_array;

	private $musculoskeletal_option6_option2_array;

	private $musculoskeletal_option6_option2_option1_array;

	private $musculoskeletal_option6_option2_option2_array;

	private $musculoskeletal_option6_option2_other_array;

	private $musculoskeletal_option6_option3_array;

	private $musculoskeletal_option6_option3_option1_array;

	private $musculoskeletal_option6_option3_option2_array;

	private $musculoskeletal_option6_option3_other_array;

	private $musculoskeletal_option6_option4_array;

	private $musculoskeletal_option6_option4_option1_array;

	private $musculoskeletal_option6_option4_option2_array;

	private $musculoskeletal_option6_option4_other_array;

	private $musculoskeletal_option6_other_array;

	private $musculoskeletal_other_array;


	//PHYSICAL EXAM: NEUROLOGIC
	private $neurologic_array = [
		"Normal",
		"Cranial Nerves",
		"Motor Strength",
		"Sensation",
		"Gait",
		"Other"

	];

	private $neurologic_option1_array;

	private $neurologic_option2_array;

	private $neurologic_option2_option1_array;

	private $neurologic_option2_option2_array;

	private $neurologic_option2_option3_array;

	private $neurologic_option2_option4_array;

	private $neurologic_option2_other_array;

	private $neurologic_option3_array;

	private $neurologic_option3_option1_array;

	private $neurologic_option3_option2_array;

	private $neurologic_option3_option3_array;

	private $neurologic_option3_option4_array;

	private $neurologic_option3_other_array;

	private $neurologic_option4_array;

	private $neurologic_other_array;


	//PHySICAL EXAM: GENITALIA/RECTUM
	private $genitalia_rectum_array = [
		"Normal",
		"Abnormal",
		"Other"
	];


	function __construct() {

		$this->general_appearance_option1_array = $this->no_yes_other_array;

		$this->general_appearance_option2_array = $this->no_yes_other_array;

		$this->general_appearance_option3_array = $this->no_yes_other_array;

		$this->general_appearance_other_array = $this->normal_abnormal_other_array;

		$this->general_appearance_option_array = [
			$this->general_appearance_option1_array,
			$this->general_appearance_option2_array,
			$this->general_appearance_option3_array,
			$this->general_appearance_other_array
		];

		$this->skin_option1_array = $this->skin_location_array;

		$this->skin_option1_option1_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option2_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option3_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option4_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option5_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option6_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option7_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option8_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option9_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option10_array = $this->normal_abnormal_other_array;

		$this->skin_option1_option11_array = $this->normal_abnormal_other_array;

		$this->skin_option1_other_array = $this->normal_abnormal_other_array;

		$this->skin_option2_array = $this->skin_location_array;

		$this->skin_option2_option1_array = $this->skin_lesions_array;

		$this->skin_option2_option2_array = $this->skin_lesions_array;

		$this->skin_option2_option3_array = $this->skin_lesions_array;

		$this->skin_option2_option4_array = $this->skin_lesions_array;

		$this->skin_option2_option5_array = $this->skin_lesions_array;

		$this->skin_option2_option6_array = $this->skin_lesions_array;

		$this->skin_option2_option7_array = $this->skin_lesions_array;

		$this->skin_option2_option8_array = $this->skin_lesions_array;

		$this->skin_option2_option9_array = $this->skin_lesions_array;

		$this->skin_option2_option10_array = $this->skin_lesions_array;

		$this->skin_option2_option11_array = $this->skin_lesions_array;

		$this->skin_option2_other_array = $this->normal_abnormal_other_array;

		$this->skin_other_array = $this->normal_abnormal_other_array;

		$this->skin_option_array = [
			$this->skin_option1_array,
			$this->skin_option2_array,
			$this->skin_other_array
		];	

		$this->skin_option1_map = [
			$this->skin_option1_option1_array,
			$this->skin_option1_option2_array,
			$this->skin_option1_option3_array,
			$this->skin_option1_option4_array,
			$this->skin_option1_option5_array,
			$this->skin_option1_option6_array,
			$this->skin_option1_option7_array,
			$this->skin_option1_option8_array,
			$this->skin_option1_option9_array,
			$this->skin_option1_option10_array,
			$this->skin_option1_option11_array,
			$this->skin_option1_other_array
		];

		$this->skin_option2_map = [
			$this->skin_option2_option1_array,
			$this->skin_option2_option2_array,
			$this->skin_option2_option3_array,
			$this->skin_option2_option4_array,
			$this->skin_option2_option5_array,
			$this->skin_option2_option6_array,
			$this->skin_option2_option7_array,
			$this->skin_option2_option8_array,
			$this->skin_option2_option9_array,
			$this->skin_option2_option10_array,
			$this->skin_option2_option11_array,
			$this->skin_option2_other_array
		];

		$this->skin_map = [
			$this->skin_option1_map,
			$this->skin_option2_map,
			NULL
		];

		$this->head_option1_array = $this->no_yes_other_array;

		$this->head_other_array = $this->normal_abnormal_other_array;

		$this->head_option_array = [
			$this->head_option1_array,
			$this->head_option2_array,
			$this->head_other_array
		];

		$this->eyes_option1_array = $this->normal_abnormal_other_array;

		$this->eyes_option7_array = $this->no_yes_other_array;

		$this->eyes_other_array = $this->normal_abnormal_other_array;

		$this->eyes_option_array = [
			$this->eyes_option1_array,
			$this->eyes_option2_array,
			$this->eyes_option3_array,
			$this->eyes_option4_array,
			$this->eyes_option5_array,
			$this->eyes_option6_array,
			$this->eyes_option7_array,
			$this->eyes_other_array
		];

		$this->ears_option4_array = $this->no_yes_other_array;

		$this->ears_other_array = $this->normal_abnormal_other_array;

		$this->ears_option_array = [
			$this->ears_option1_array,
			$this->ears_option2_array,
			$this->ears_option3_array,
			$this->ears_option4_array,
			$this->ears_other_array
		];

		$this->nose_sinuses_option1_array = $this->no_yes_other_array;

		$this->nose_sinuses_option2_array = $this->no_yes_other_array;

		$this->nose_sinuses_other_array = $this->normal_abnormal_other_array;

		$this->nose_sinuses_option_array = [
			$this->nose_sinuses_option1_array,
			$this->nose_sinuses_option2_array,
			$this->nose_sinuses_other_array
		];

		$this->mouth_pharynx_other_array = $this->normal_abnormal_other_array;

		$this->mouth_pharynx_option_array = [
			$this->mouth_pharynx_option1_array,
			$this->mouth_pharynx_option2_array,
			$this->mouth_pharynx_option3_array,
			$this->mouth_pharynx_other_array
		];

		$this->neck_option2_array = $this->no_yes_other_array;

		$this->neck_other_array = $this->normal_abnormal_other_array;

		$this->neck_option_array = [
			$this->neck_option1_array,
			$this->neck_option2_array,
			$this->neck_option3_array,
			$this->neck_other_array
		];

		$this->chest_option1_array = $this->no_yes_other_array;

		$this->chest_other_array = $this->normal_abnormal_other_array;

		$this->chest_option_array = [
			$this->chest_option1_array,
			$this->chest_option2_array,
			$this->chest_other_array
		];

		$this->lungs_option1_array = $this->lungs_options_array;

		$this->lungs_option2_array = $this->lungs_options_array;

		$this->lungs_other_array = $this->normal_abnormal_other_array;

		$this->lungs_option_array = [
			$this->lungs_option1_array,
			$this->lungs_option2_array,
			$this->lungs_other_array
		];

		$this->vascular_option1_array = $this->normal_abnormal_other_array;

		$this->vascular_option2_array = $this->normal_abnormal_other_array;

		$this->vascular_option3_array = $this->normal_abnormal_other_array;

		$this->vascular_option4_array = $this->normal_abnormal_other_array;

		$this->vascular_other_array = $this->normal_abnormal_other_array;

		$this->vascular_option_array = [
			$this->vascular_option1_array,
			$this->vascular_option2_array,
			$this->vascular_option3_array,
			$this->vascular_option4_array,
			$this->vascular_option5_array,
			$this->vascular_other_array
		];

		$this->abdomen_option1_array = $this->no_yes_other_array;

		$this->abdomen_option2_array = $this->no_yes_other_array;

		$this->abdomen_option3_array = $this->no_yes_other_array;

		$this->abdomen_option4_array = $this->no_yes_other_array;

		$this->abdomen_option5_array = $this->abdomen_options_array;

		$this->abdomen_option6_array = $this->abdomen_options_array;

		$this->abdomen_option7_array = $this->no_yes_other_array;

		$this->abdomen_option8_array = $this->no_yes_other_array;

		$this->abdomen_other_array = $this->normal_abnormal_other_array;

		$this->abdomen_option_array = [
			$this->abdomen_option1_array,
			$this->abdomen_option2_array,
			$this->abdomen_option3_array,
			$this->abdomen_option4_array,
			$this->abdomen_option5_array,
			$this->abdomen_option6_array,
			$this->abdomen_option7_array,
			$this->abdomen_option8_array,
			$this->abdomen_other_array
		];

		$this->musculoskeletal_option1_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option1_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option1_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option1_other_array = $this->normal_abnormal_other_array;


		$this->musculoskeletal_option2_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option2_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option2_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option2_other_array = $this->normal_abnormal_other_array;


		$this->musculoskeletal_option3_array = $this->musculoskeletal_upper_extremities_array;

		$this->musculoskeletal_option3_option1_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option3_option1_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option3_option1_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option3_option1_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option3_option2_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option3_option2_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option3_option2_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option3_option2_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option3_option3_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option3_option3_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option3_option3_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option3_option3_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option3_option4_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option3_option4_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option3_option4_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option3_option4_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option3_other_array = $this->normal_abnormal_other_array;


		$this->musculoskeletal_option4_array = $this->musculoskeletal_upper_extremities_array;

		$this->musculoskeletal_option4_option1_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option4_option1_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option4_option1_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option4_option1_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option4_option2_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option4_option2_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option4_option2_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option4_option2_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option4_option3_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option4_option3_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option4_option3_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option4_option3_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option4_option4_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option4_option4_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option4_option4_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option4_option4_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option4_other_array = $this->normal_abnormal_other_array;


		$this->musculoskeletal_option5_array = $this->musculoskeletal_lower_extremities_array;

		$this->musculoskeletal_option5_option1_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option5_option1_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option5_option1_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option5_option1_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option5_option2_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option5_option2_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option5_option2_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option5_option2_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option5_option3_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option5_option3_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option5_option3_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option5_option3_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option5_option4_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option5_option4_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option5_option4_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option5_option4_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option5_other_array = $this->normal_abnormal_other_array;


		$this->musculoskeletal_option6_array = $this->musculoskeletal_lower_extremities_array;

		$this->musculoskeletal_option6_option1_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option6_option1_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option6_option1_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option6_option1_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option6_option2_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option6_option2_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option6_option2_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option6_option2_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option6_option3_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option6_option3_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option6_option3_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option6_option3_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option6_option4_array = $this->musculoskeletal_options_array;

		$this->musculoskeletal_option6_option4_option1_array = $this->no_yes_other_array;

		$this->musculoskeletal_option6_option4_option2_array = $this->musculoskeletal_range_of_motion_array;

		$this->musculoskeletal_option6_option4_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option6_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_other_array = $this->normal_abnormal_other_array;

		$this->musculoskeletal_option_array = [
			$this->musculoskeletal_option1_array,
			$this->musculoskeletal_option2_array,
			$this->musculoskeletal_option3_array,
			$this->musculoskeletal_option4_array,
			$this->musculoskeletal_option5_array,
			$this->musculoskeletal_option6_array,
			$this->musculoskeletal_other_array
		];

		$this->musculoskeletal_option1_map = [
			$this->musculoskeletal_option1_option1_array,
			$this->musculoskeletal_option1_option2_array,
			$this->musculoskeletal_option1_other_array
		];

		$this->musculoskeletal_option2_map = [
			$this->musculoskeletal_option2_option1_array,
			$this->musculoskeletal_option2_option2_array,
			$this->musculoskeletal_option2_other_array
		];

		$this->musculoskeletal_option3_map = [
			$this->musculoskeletal_option3_option1_array,
			$this->musculoskeletal_option3_option2_array,
			$this->musculoskeletal_option3_option3_array,
			$this->musculoskeletal_option3_option4_array,
			$this->musculoskeletal_option3_other_array
		];

		$this->musculoskeletal_option3_option1_map = [
			$this->musculoskeletal_option3_option1_option1_array,
			$this->musculoskeletal_option3_option1_option2_array,
			$this->musculoskeletal_option3_option1_other_array
		];

		$this->musculoskeletal_option3_option2_map = [
			$this->musculoskeletal_option3_option2_option1_array,
			$this->musculoskeletal_option3_option2_option2_array,
			$this->musculoskeletal_option3_option2_other_array
		];

		$this->musculoskeletal_option3_option3_map = [
			$this->musculoskeletal_option3_option3_option1_array,
			$this->musculoskeletal_option3_option3_option2_array,
			$this->musculoskeletal_option3_option3_other_array
		];

		$this->musculoskeletal_option3_option4_map = [
			$this->musculoskeletal_option3_option4_option1_array,
			$this->musculoskeletal_option3_option4_option2_array,
			$this->musculoskeletal_option3_option4_other_array
		];

		$this->musculoskeletal_option4_map = [
			$this->musculoskeletal_option4_option1_array,
			$this->musculoskeletal_option4_option2_array,
			$this->musculoskeletal_option4_option3_array,
			$this->musculoskeletal_option4_option4_array,
			$this->musculoskeletal_option4_other_array
		];

		$this->musculoskeletal_option4_option1_map = [
			$this->musculoskeletal_option4_option1_option1_array,
			$this->musculoskeletal_option4_option1_option2_array,
			$this->musculoskeletal_option4_option1_other_array
		];

		$this->musculoskeletal_option4_option2_map = [
			$this->musculoskeletal_option4_option2_option1_array,
			$this->musculoskeletal_option4_option2_option2_array,
			$this->musculoskeletal_option4_option2_other_array
		];

		$this->musculoskeletal_option4_option3_map = [
			$this->musculoskeletal_option4_option3_option1_array,
			$this->musculoskeletal_option4_option3_option2_array,
			$this->musculoskeletal_option4_option3_other_array
		];

		$this->musculoskeletal_option4_option4_map = [
			$this->musculoskeletal_option4_option4_option1_array,
			$this->musculoskeletal_option4_option4_option2_array,
			$this->musculoskeletal_option4_option4_other_array
		];

		$this->musculoskeletal_option5_map = [
			$this->musculoskeletal_option5_option1_array,
			$this->musculoskeletal_option5_option2_array,
			$this->musculoskeletal_option5_option3_array,
			$this->musculoskeletal_option5_option4_array,
			$this->musculoskeletal_option5_other_array
		];

		$this->musculoskeletal_option5_option1_map = [
			$this->musculoskeletal_option5_option1_option1_array,
			$this->musculoskeletal_option5_option1_option2_array,
			$this->musculoskeletal_option5_option1_other_array
		];

		$this->musculoskeletal_option5_option2_map = [
			$this->musculoskeletal_option5_option2_option1_array,
			$this->musculoskeletal_option5_option2_option2_array,
			$this->musculoskeletal_option5_option2_other_array
		];

		$this->musculoskeletal_option5_option3_map = [
			$this->musculoskeletal_option5_option3_option1_array,
			$this->musculoskeletal_option5_option3_option2_array,
			$this->musculoskeletal_option5_option3_other_array
		];

		$this->musculoskeletal_option5_option4_map = [
			$this->musculoskeletal_option5_option4_option1_array,
			$this->musculoskeletal_option5_option4_option2_array,
			$this->musculoskeletal_option5_option4_other_array
		];

		$this->musculoskeletal_option6_map = [
			$this->musculoskeletal_option5_option1_array,
			$this->musculoskeletal_option5_option2_array,
			$this->musculoskeletal_option5_option3_array,
			$this->musculoskeletal_option5_option4_array,
			$this->musculoskeletal_option5_other_array
		];

		$this->musculoskeletal_option6_option1_map = [
			$this->musculoskeletal_option3_option1_option1_array,
			$this->musculoskeletal_option3_option1_option2_array,
			$this->musculoskeletal_option3_option1_other_array
		];

		$this->musculoskeletal_option6_option2_map = [
			$this->musculoskeletal_option6_option2_option1_array,
			$this->musculoskeletal_option6_option2_option2_array,
			$this->musculoskeletal_option6_option2_other_array
		];

		$this->musculoskeletal_option6_option3_map = [
			$this->musculoskeletal_option6_option3_option1_array,
			$this->musculoskeletal_option6_option3_option2_array,
			$this->musculoskeletal_option6_option3_other_array
		];

		$this->musculoskeletal_option6_option4_map = [
			$this->musculoskeletal_option6_option4_option1_array,
			$this->musculoskeletal_option6_option4_option2_array,
			$this->musculoskeletal_option6_option4_other_array
		];

		$this->musculoskeletal_map = [
			$this->musculoskeletal_option1_map,
			$this->musculoskeletal_option2_map,
			$this->musculoskeletal_option3_map,
			$this->musculoskeletal_option4_map,
			$this->musculoskeletal_option5_map,
			$this->musculoskeletal_option6_map,
			$this->normal_abnormal_other_array
		];

		$this->musculoskeletal_option3_map2 = [
			$this->musculoskeletal_option3_option1_map,
			$this->musculoskeletal_option3_option2_map,
			$this->musculoskeletal_option3_option3_map,
			$this->musculoskeletal_option3_option4_map,
			NULL
		];

		$this->musculoskeletal_option4_map2 = [
			$this->musculoskeletal_option4_option1_map,
			$this->musculoskeletal_option4_option2_map,
			$this->musculoskeletal_option4_option3_map,
			$this->musculoskeletal_option4_option4_map,
			NULL
		];

		$this->musculoskeletal_option5_map2 = [
			$this->musculoskeletal_option5_option1_map,
			$this->musculoskeletal_option5_option2_map,
			$this->musculoskeletal_option5_option3_map,
			$this->musculoskeletal_option5_option4_map,
			NULL
		];

		$this->musculoskeletal_option6_map2 = [
			$this->musculoskeletal_option6_option1_map,
			$this->musculoskeletal_option6_option2_map,
			$this->musculoskeletal_option6_option3_map,
			$this->musculoskeletal_option6_option4_map,
			NULL
		];

		$this->musculoskeletal_map2 = [
			NULL,
			NULL,
			$this->musculoskeletal_option3_map2,
			$this->musculoskeletal_option4_map2,
			$this->musculoskeletal_option5_map2,
			$this->musculoskeletal_option6_map2,
			NULL
		];


		$this->neurologic_option1_array = $this->normal_abnormal_other_array;

		$this->neurologic_option2_array = $this->neurologic_options_array;

		$this->neurologic_option2_option1_array = $this->normal_abnormal_other_array;

		$this->neurologic_option2_option2_array = $this->normal_abnormal_other_array;

		$this->neurologic_option2_option3_array = $this->normal_abnormal_other_array;

		$this->neurologic_option2_option4_array = $this->normal_abnormal_other_array;

		$this->neurologic_option2_other_array = $this->normal_abnormal_other_array;

		$this->neurologic_option3_array = $this->neurologic_options_array;

		$this->neurologic_option3_option1_array = $this->normal_abnormal_other_array;

		$this->neurologic_option3_option2_array = $this->normal_abnormal_other_array;

		$this->neurologic_option3_option3_array = $this->normal_abnormal_other_array;

		$this->neurologic_option3_option4_array = $this->normal_abnormal_other_array;

		$this->neurologic_option3_other_array = $this->normal_abnormal_other_array;

		$this->neurologic_option4_array = $this->normal_abnormal_other_array;

		$this->neurologic_other_array = $this->normal_abnormal_other_array;

		$this->neurologic_option_array = [
			$this->neurologic_option1_array,
			$this->neurologic_option2_array,
			$this->neurologic_option3_array,
			$this->neurologic_option4_array,
			$this->neurologic_other_array
		];

		$this->neurologic_option2_map = [
			$this->neurologic_option2_option1_array,
			$this->neurologic_option2_option2_array,
			$this->neurologic_option2_option3_array,
			$this->neurologic_option2_option4_array,
			$this->neurologic_option2_other_array
		];

		$this->neurologic_option3_map = [
			$this->neurologic_option3_option1_array,
			$this->neurologic_option3_option2_array,
			$this->neurologic_option3_option3_array,
			$this->neurologic_option3_option4_array,
			$this->neurologic_option3_other_array
		];

		$this->neurologic_map = [
			NULL,
			$this->neurologic_option2_map,
			$this->neurologic_option3_map,
			NULL,
			NULL
		];

		$this->physical_exam_option_array = [
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
			$this->genitalia_rectum_array
		];

		$this->physical_exam_map = [
			$this->general_appearance_option_array,
			$this->skin_option_array,
			$this->head_option_array,
			$this->eyes_option_array,
			$this->ears_option_array,
			$this->nose_sinuses_option_array,
			$this->mouth_pharynx_option_array,
			$this->neck_option_array,
			$this->chest_option_array,
			$this->lungs_option_array,
			NULL,
			NULL,
			$this->vascular_option_array,
			$this->abdomen_option_array,
			$this->musculoskeletal_option_array,
			$this->neurologic_option_array,
			NULL
		];

		$this->physical_exam_map2 = [
			NULL,
			$this->skin_map,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			$this->musculoskeletal_map,
			$this->neurologic_map,
			NULL
		];

		$this->physical_exam_map3 = [
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			$this->musculoskeletal_map2,
			NULL,
			NULL
		];
	}

	public function getOptions($main_category, $subcategory1, $subcategory2, $subcategory3) {
		if ($main_category == NULL) {
			return $this->physical_exam_category_array;
		} else if ($subcategory1 == NULL) {
			return $this->physical_exam_option_array[$main_category];
		} else if($subcategory2 == NULL) {
			return $this->physical_exam_map[$main_category][$subcategory1 - 1];
		} else if ($subcategory3 == NULL) {
			return $this->physical_exam_map2[$main_category][$subcategory1 - 1][$subcategory2 - 1];
		} else {
			return $this->physical_exam_map3[$main_category][$subcategory1 - 1][$subcategory2 - 1][$subcategory3 - 1];
		}
	}

	public function isEnd($main_category, $subcategory1, $subcategory2, $subcategory3, $subcategory4) {
		if ($subcategory1 == NULL) {
			return $this->physical_exam_map[$main_category];
		} else if ($subcategory2 == NULL) {
			return $this->physical_exam_map2[$main_category][$subcategory1 - 1];
		} else if ($subcategory3 == NULL) {
			return $this->physical_exam_map3[$main_category][$subcategory1 - 1][$subcategory2 - 1];
		} else {
			return NULL;
		}  
	}

}

?>