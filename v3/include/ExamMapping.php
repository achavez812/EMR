<?php

class ExamMapping {

	private $EXAM_TYPE_LABORATORY = '1';
	private $EXAM_TYPE_PHYSICAL = '2';

	private $normal_abnormal_array = [
		'3',
		'4'
	];

	private $no_yes_array = [
		'5',
		'6'
	];

	private $pregnancy_options_array = [
		'7',
		'8'
	];

	private $skin_lesions_options_array = [
		'26',
		'27',
		'28',
		'29'
	];

	private $lungs_options_array = [
		'30',
		'31',
		'32',
		'33'
	];

	private $abdomen_options_array = [
		'5',
		'6',
		'34'
	];

	private $musculoskeletal_options_array = [
		'3',
		'35',
		'36'
	];

	private $intact_options_array = [
		'37',
		'38'
	];


	private $main_map;
	private $laboratory_map;
	private $physical_map;



	function __construct() {
		//LABORATORY MAPPING
		$lab_blood_map = [
			'13' => $this->normal_abnormal_array,
			'14' => $this->normal_abnormal_array
		];

		$this->laboratory_map = [
			'9' => $lab_blood_map,
			'10' => $this->normal_abnormal_array,
			'11' => $this->pregnancy_options_array,
			'12' => $this->normal_abnormal_array
		];

		//PHYSICAL MAPPING
		$phy_general_appearance_map = [
			'64' => $this->no_yes_array,
			'65' => $this->no_yes_array,
			'66' => $this->no_yes_array
		];

		$phy_ski_skin_color_map = [
			'15' => $this->normal_abnormal_array,
			'16' => $this->normal_abnormal_array,
			'17' => $this->normal_abnormal_array,
			'18' => $this->normal_abnormal_array,
			'19' => $this->normal_abnormal_array,
			'20' => $this->normal_abnormal_array,
			'21' => $this->normal_abnormal_array,
			'22' => $this->normal_abnormal_array,
			'23' => $this->normal_abnormal_array,
			'24' => $this->normal_abnormal_array,
			'25' => $this->normal_abnormal_array
		];

		$phy_ski_lesions_map = [
			'15' => $this->skin_lesions_options_array,
			'16' => $this->skin_lesions_options_array,
			'17' => $this->skin_lesions_options_array,
			'18' => $this->skin_lesions_options_array,
			'19' => $this->skin_lesions_options_array,
			'20' => $this->skin_lesions_options_array,
			'21' => $this->skin_lesions_options_array,
			'22' => $this->skin_lesions_options_array,
			'23' => $this->skin_lesions_options_array,
			'24' => $this->skin_lesions_options_array,
			'25' => $this->skin_lesions_options_array
		];

		$phy_skin_map = [
			'67' => $phy_ski_skin_color_map,
			'68' => $phy_ski_lesions_map,
		];

		$phy_head_map = [
			'69' => $this->no_yes_array,
			'70' => ['3', '71']
		];

		$phy_eyes_map = [
			'72' => $this->normal_abnormal_array,
			'73' => ['3', '79', '28'],
			'74' => ['3', '79', '68'],
			'75' => ['3', '80'],
			'76' => ['3', '81', '82'],
			'77' => $this->intact_options_array,
			'78' => $this->no_yes_array
		];

		$phy_ears_map = [
			'84' => ['3', '79', '68', '88'],
			'85' => ['3', '79', '83', '89'],
			'86' => ['3', '79', '83', '90'],
			'87' => $this->no_yes_array
		];

		$phy_nose_sinuses_map = [
			'91' => $this->no_yes_array,
			'92' => $this->no_yes_array
		];

		$phy_mouth_pharynx_map = [
			'93' => ['3', '96', '97', '68'],
			'94' => ['3', '98', '83'],
			'95' => ['3', '99', '100', '101']
		];

		$phy_neck_map = [
			'36' => ['3', '104'],
			'102' => $this->no_yes_array,
			'103' => ['105', '106']
		];

		$phy_chest_breasts_map = [
			'107' => $this->no_yes_array,
			'68' => ['26', '6']
		];

		$phy_lungs_map = [
			'108' => $this->lungs_options_array,
			'109' => $this->lungs_options_array
		];


		$phy_vascular_map = [
			'113' => $this->normal_abnormal_array,
			'114' => $this->normal_abnormal_array,
			'115' => $this->normal_abnormal_array,
			'116' => $this->normal_abnormal_array,
			'117' => ['26', '118', '119', '120']
		];

		$phy_abdomen_map = [
			'121' => $this->no_yes_array,
			'122' => $this->no_yes_array,
			'123' => $this->no_yes_array,
			'124' => $this->no_yes_array,
			'125' => $this->no_yes_array,
			'126' => $this->no_yes_array,
			'127' => $this->no_yes_array,
			'128' => $this->no_yes_array
		];

		$musculoskeletal_base_map = [
			'35' => $this->no_yes_array,
			'36' => $this->intact_options_array
		];

		$phy_mus_upper_extremities_map = [
			'17' => $musculoskeletal_base_map,
			'39' => $musculoskeletal_base_map,
			'40' => $musculoskeletal_base_map,
			'41' => $musculoskeletal_base_map
		];

		$phy_mus_lower_extremities_map = [
			'42' => $musculoskeletal_base_map,
			'43' => $musculoskeletal_base_map,
			'44' => $musculoskeletal_base_map,
			'25' => $musculoskeletal_base_map
		];

		$phy_musculoskeletal_map = [
			'16' => $musculoskeletal_base_map,
			'129' => $musculoskeletal_base_map,
			'130' => $phy_mus_upper_extremities_map,
			'131' => $phy_mus_upper_extremities_map,
			'132' => $phy_mus_lower_extremities_map,
			'133' => $phy_mus_lower_extremities_map
		];

		$neurologic_options_map = [
			'3' => $this->normal_abnormal_array,
			'45' => $this->normal_abnormal_array,
			'46' => $this->normal_abnormal_array,
			'47' => $this->normal_abnormal_array,
			'48' => $this->normal_abnormal_array
		];

		$phy_neurologic_map = [
			'134' => $this->normal_abnormal_array, 
			'135' => $neurologic_options_map,
			'136' => $neurologic_options_map,
			'137' => $this->normal_abnormal_array
		];

		$phy_psychiatric_map = [
			'138' => $this->no_yes_array,
			'139' => $this->no_yes_array
		];



		$this->physical_map = [
			'49' => $phy_general_appearance_map,
			'50' => $phy_skin_map,
			'51' => $phy_head_map,
			'52' => $phy_eyes_map,
			'53' => $phy_ears_map,
			'54' => $phy_nose_sinuses_map,
			'55' => $phy_mouth_pharynx_map,
			'16' => $phy_neck_map,
			'56' => $phy_chest_breasts_map,
			'57' => $phy_lungs_map,
			'58' => ['110', '111', '112'],
			'59' => $phy_vascular_map,
			'19' => $phy_abdomen_map,
			'60' => $phy_musculoskeletal_map,
			'61' => $phy_neurologic_map,
			'62' => $phy_psychiatric_map,
			'63' => $this->normal_abnormal_array
		];

		$this->main_map = [
			$this->EXAM_TYPE_LABORATORY => $this->laboratory_map,
			$this->EXAM_TYPE_PHYSICAL => $this->physical_map
		];
	}

	public function getFullMapping() {
		return $this->main_map;
	}


}

?>