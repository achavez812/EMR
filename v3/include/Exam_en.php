<?php

	const EXAM_MAPPING = [
		"1" => "Laboratory",
		"2" => "Physical",
		"3" => "Normal",
		"4" => "Abnormal",
		"5" => "No (Normal)",
		"6" => "Yes",
		"7" => "Not Pregnant (Normal)",
		"8" => "Yes Pregnant",
		"9" => "Blood",
		"10" => "Feces",
		"11" => "Pregnancy",
		"12" => "Urine",
		"13" => "HbA1c",
		"14" => "Blood Glucose" 
		"15" => "Face",
		"16" => "Neck",
		"17" => "Shoulders",
		"18" => "Chest",
		"19" => "Abdomen",
		"20" => "Back (Upper)",
		"21" => "Back (Lower)",
		"22" => "Arms",
		"23" => "Hands",
		"24" => "Legs",
		"25" => "Feet"
		"26" => "None (Normal)",
		"27" => "Raised",
		"28" => "Pustule(s)",
		"29" => "Vesicles",
		"30" => "Good Air Movement (Normal)",
		"31" => "Wheezes",
		"32" => "Consolidation",
		"33" => "Rhonchi/Rales",
		"34" => "Murphys",
		"35" => "Pain",
		"36" => "Range of Motion",
		"37" => "Intact (Normal)",
		"38" => "Not Intact",
		"39" => "Elbows",
		"40" => "Wrists",
		"41" => "Fingers",
		"42" => "Hips",
		"43" => "Knees",
		"44" => "Ankles",
		"45" => "RUE",
		"46" => "LUE",
		"47" => "RLE",
		"48" => "LLE",
		"49" => "General Appearance",
		"50" => "Skin",
		"51" => "Head",
		"52" => "Eyes",
		"53" => "Ears",
		"54" => "Nose/Sinuses",
		"55" => "Mouth/Pharynx",
		"56" => "Chest/Breasts",
		"57" => "Lungs",
		"58" => "Cardiac",
		"59" => "Vascular",
		"60" => "Musculoskeletal",
		"61" => "Neurologic",
		"62" => "Psychiatric",
		"63" => "Genitalia/Rectum",
		"64" => "Ill",
		"65" => "In Pain",
		"66" => "Lethargic",
		"67" => "Skin Color",
		"68" => "Lesion(s)",
		"69" => "Lesions(s) to Scalp",
		"70" => "Fontanelles",
		"71" => "Sunken",
		"72" => "Acuity",
		"73" => "Eyelids",
		"74" => "Sclera",
		"75" => "Conjuctivae",
		"76" => "Pupils",
		"77" => "Extraocular Movements",
		"78" => "Drainage",
		"79" => "Red",
		"80" => "Injected",
		"81" => "Sluggish",
		"82" => "Asymmetric",
		"83" => "Inflamed"
		"84" => "Outer Ear",
		"85" => "Canal",
		"86" => "Tympanic Membrane",
		"87" => "Light Reflex",
		"88" => "Painful Movement"
		"89" => "Cerumen",
		"90" => "Fluid",
		"91" => "Rhonorrhea",
		"92" => "Sinus Tenderness",
		"93" => "Buccal/Oral Mucosa",
		"94" => "Condition of Teeth/Gums",
		"95" => "Pharynx/Tonsils",
		"96" => "Moist",
		"97" => "Dry",
		"98" => "Carries/Poor",
		"99" => "Erythematous",
		"100" => "Tonsillar Exudates",
		"101" => "Pharyngeal Erythema",
		"102" => "Throat Pain upon Palpation",
		"103" => "Lymph Nodes",
		"104" => "Impaired",
		"105" => "Palpable (Normal)",
		"106" => "Not Palpable",
		"107" => "Tenderness",
		"108" => "Right",
		"109" => "Left",
		"110" => "Regular (Normal)",
		"111" => "Irregular",
		"112" => "Murmurs",
		"113" => "Pulses",
		"114" => "Carotid",
		"115" => "Femoral",
		"116" => "Radial",
		"117" => "Presence of Edema",
		"118" => "Bilateral",
		"119" => "Unilateral Right",
		"120" => "Unilateral Left",
		"121" => "Hepatomegaly",
		"122" => "Splenomegaly",
		"123" => "LUQ Pain",
		"124" => "LLQ Pain",
		"125" => "RUQ Pain",
		"126" => "RLQ Pain",
		"127" => "Guarding",
		"128" => "Rebound",
		"129" => "Spine",
		"130" => "Upper Extremities Right",
		"131" => "Upper Extremities Left",
		"132" => "Lower Extremities Right",
		"133" => "Lower Extremities Left",
		"134" => "Cranial Nerves",
		"135" => "Motor Strength",
		"136" => "Sensation",
		"137" => "Gait",	
		"138" => "Depression",
		"139" => "Suicidal"
	];

	private $EXAM_TYPE_LABORATORY = "1";
	private $EXAM_TYPE_PHYSICAL = "2";

	private $normal_abnormal_array = [
		"3",
		"4"
	];

	private $no_yes_array = [
		"5",
		"6"
	];

	private $pregnancy_options_array = [
		"7",
		"8"
	];

	private $skin_lesions_options_array = [
		"26",
		"27",
		"28",
		"29"
	];

	private $lungs_options_array = [
		"30",
		"31",
		"32",
		"33"
	];

	private $abdomen_options_array = [
		"5",
		"6",
		"34"
	];

	private $musculoskeletal_options_array = [
		"3",
		"35",
		"36"
	];

	private $intact_options_array = [
		"37",
		"38"
	];




	private $main_map = [
		"1" => $laboratory_map,
		"2" => $physical_map
	];

	private $laboratory_map = [
		"9" => $lab_blood_map,
		"10" => $normal_abnormal_array,
		"11" => $pregnancy_options_array,
		"12" => $normal_abnormal_array
	];

	private $lab_blood_map = [
		"13" => $lab_blo_hba1c_map,
		"14" => $lab_blo_blood_glucose_map
	];







	private $physical_map = [
		 "49" => $phy_general_appearance_map,
		 "50" => $phy_skin_map,
		 "51" => $phy_head_map,
		 "52" => $phy_eyes_map,
		 "53" => $phy_ears_map,
		 "54" => $phy_nose_sinuses_map,
		 "55" => $phy_mouth_pharynx_map,
		 "16" => $phy_neck_map,
		 "56" => $phy_chest_breasts_map,
		 "57" => $phy_lungs_map,
		 "58" => ["110", "111", "112"],
		 "59" => $phy_vascular_map,
		 "19" => $phy_abdomen_map,
		 "60" => $phy_musculoskeletal_map,
		 "61" => $phy_neurologic_map,
		 "62" => $phy_psychiatric_map,
		 "63" => $normal_abnormal_array
	];

	private $phy_general_appearance_map = [
		"64" => $no_yes_array,
		"65" => $no_yes_array,
		"66" => $no_yes_array,
	];

	private $phy_skin_map = [
		"67" => $phy_ski_skin_color_map,
		"68" => $phy_ski_lesions_map,
	];

	private $phy_ski_skin_color_map = [
		"15" => $normal_abnormal_array,
		"16" => $normal_abnormal_array,
		"17" => $normal_abnormal_array,
		"18" => $normal_abnormal_array,
		"19" => $normal_abnormal_array,
		"20" => $normal_abnormal_array,
		"21" => $normal_abnormal_array,
		"22" => $normal_abnormal_array,
		"23" => $normal_abnormal_array,
		"24" => $normal_abnormal_array,
		"25" => $normal_abnormal_array
	];

	private $phy_ski_lesions_map = [
		"15" => $skin_lesions_options_array,
		"16" => $skin_lesions_options_array,
		"17" => $skin_lesions_options_array,
		"18" => $skin_lesions_options_array,
		"19" => $skin_lesions_options_array,
		"20" => $skin_lesions_options_array,
		"21" => $skin_lesions_options_array,
		"22" => $skin_lesions_options_array,
		"23" => $skin_lesions_options_array,
		"24" => $skin_lesions_options_array,
		"25" => $skin_lesions_options_array
	];

	private $phy_head_map = [
		"69" => $no_yes_array,
		"70" => ["3", "71"]
	];

	private $phy_eyes_map = [
		"72" => $normal_abnormal_array,
		"73" => ["3", "79", "28"],
		"74" => ["3", "79", "68"],
		"75" => ["3", "80"],
		"76" => ["3", "81", "82"],
		"77" => $intact_options_array,
		"78" => $no_yes_array
	];

	private $phy_ears_map = [
		"84" => ["3", "79", "68", "88"],
		"85" => ["3", "79", "83", "89"],
		"86" => ["3", "79", "83", "90"],
		"87" => $no_yes_array
	];

	private $phy_nose_sinuses_map = [
		"91" => $no_yes_array,
		"92" => $no_yes_array
	];

	private $phy_mouth_pharynx_map = [
		"93" => ["3", "96", "97", "68"],
		"94" => ["3", "98", "83"],
		"95" => ["3", "99", "100", "101"]
	];

	private $phy_neck_map = [
		"36" => ["3", "104"],
		"102" => $no_yes_array,
		"103" => ["105", "106"]
	];

	private $phy_chest_breasts_map = [
		"107" => $no_yes_array,
		"68" => ["26", "6"]
	];

	private $phy_lungs_map = [
		"108" => $lungs_options_array,
		"109" => $lungs_options_array
	];


	private $phy_vascular_map = [
		"113" => $normal_abnormal_array,
		"114" => $normal_abnormal_array,
		"115" => $normal_abnormal_array,
		"116" => $normal_abnormal_array,
		"117" => ["26", "118", "119", "120"]
	];

	private $phy_abdomen_map = [
		"121" => $no_yes_array,
		"122" => $no_yes_array,
		"123" => $no_yes_array,
		"124" => $no_yes_array,
		"125" => $no_yes_array,
		"126" => $no_yes_array,
		"127" => $no_yes_array,
		"128" => $no_yes_array
	];

	private $phy_musculoskeletal_map = [
		"16" => $musculoskeletal_base_map,
		"129" => $musculoskeletal_base_map,
		"130" => $phy_mus_upper_extremities_map,
		"131" => $phy_mus_upper_extremities_map,
		"132" => $phy_mus_lower_extremities_map,
		"133" => $phy_mus_lower_extremities_map
	];

	private $musculoskeletal_base_map = [
		"35" => $no_yes_array,
		"36" => $intact_options_array
	]

	private $phy_mus_upper_extremities_map = [
		"17" => $musculoskeletal_base_map,
		"39" => $musculoskeletal_base_map,
		"40" => $musculoskeletal_base_map,
		"41" => $musculoskeletal_base_map
	];

	private $phy_mus_lower_extremities_map = [
		"42" => $musculoskeletal_base_map,
		"43" => $musculoskeletal_base_map,
		"44" => $musculoskeletal_base_map,
		"25" => $musculoskeletal_base_map
	];

	private $phy_neurologic_map = [
		"134" => $normal_abnormal_array, 
		"135" => $neurologic_options_map,
		"136" => $neurologic_options_map,
		"137" => $normal_abnormal_array
	];

	private $neurologic_options_map = [
		"3" => $normal_abnormal_array,
		"45" => $normal_abnormal_array,
		"46" => $normal_abnormal_array,
		"47" => $normal_abnormal_array,
		"48" => $normal_abnormal_array
	];

	private $phy_psychiatric_map = [
		"138" => $no_yes_array,
		"139" => $no_yes_array
	];
	





?>