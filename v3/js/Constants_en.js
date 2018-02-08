var EXAMS_MAP = {
	"1" : "Laboratory",
	"2" : "Physical",
	"3" : "Normal",
	"4" : "Abnormal",
	"5" : "No (Normal)",
	"6" : "Yes",
	"7" : "Not Pregnant (Normal)",
	"8" : "Yes Pregnant",
	"9" : "Blood",
	"10" : "Feces",
	"11" : "Pregnancy",
	"12" : "Urine",
	"13" : "HbA1c",
	"14" : "Blood Glucose", 
	"15" : "Face",
	"16" : "Neck",
	"17" : "Shoulders",
	"18" : "Chest",
	"19" : "Abdomen",
	"20" : "Back (Upper)",
	"21" : "Back (Lower)",
	"22" : "Arms",
	"23" : "Hands",
	"24" : "Legs",
	"25" : "Feet",
	"26" : "None (Normal)",
	"27" : "Raised",
	"28" : "Pustule(s)",
	"29" : "Vesicles",
	"30" : "Good Air Movement (Normal)",
	"31" : "Wheezes",
	"32" : "Consolidation",
	"33" : "Rhonchi/Rales",
	"34" : "Murphys",
	"35" : "Pain",
	"36" : "Range of Motion",
	"37" : "Intact (Normal)",
	"38" : "Not Intact",
	"39" : "Elbows",
	"40" : "Wrists",
	"41" : "Fingers",
	"42" : "Hips",
	"43" : "Knees",
	"44" : "Ankles",
	"45" : "RUE",
	"46" : "LUE",
	"47" : "RLE",
	"48" : "LLE",
	"49" : "General Appearance",
	"50" : "Skin",
	"51" : "Head",
	"52" : "Eyes",
	"53" : "Ears",
	"54" : "Nose/Sinuses",
	"55" : "Mouth/Pharynx",
	"56" : "Chest/Breasts",
	"57" : "Lungs",
	"58" : "Cardiac",
	"59" : "Vascular",
	"60" : "Musculoskeletal",
	"61" : "Neurologic",
	"62" : "Psychiatric",
	"63" : "Genitalia/Rectum",
	"64" : "Ill",
	"65" : "In Pain",
	"66" : "Lethargic",
	"67" : "Skin Color",
	"68" : "Lesion(s)",
	"69" : "Lesions(s) to Scalp",
	"70" : "Fontanelles",
	"71" : "Sunken",
	"72" : "Acuity",
	"73" : "Eyelids",
	"74" : "Sclera",
	"75" : "Conjuctivae",
	"76" : "Pupils",
	"77" : "Extraocular Movements",
	"78" : "Drainage",
	"79" : "Red",
	"80" : "Injected",
	"81" : "Sluggish",
	"82" : "Asymmetric",
	"83" : "Inflamed",
	"84" : "Outer Ear",
	"85" : "Canal",
	"86" : "Tympanic Membrane",
	"87" : "Light Reflex",
	"88" : "Painful Movement",
	"89" : "Cerumen",
	"90" : "Fluid",
	"91" : "Rhonorrhea",
	"92" : "Sinus Tenderness",
	"93" : "Buccal/Oral Mucosa",
	"94" : "Condition of Teeth/Gums",
	"95" : "Pharynx/Tonsils",
	"96" : "Moist",
	"97" : "Dry",
	"98" : "Carries/Poor",
	"99" : "Erythematous",
	"100" : "Tonsillar Exudates",
	"101" : "Pharyngeal Erythema",
	"102" : "Throat Pain upon Palpation",
	"103" : "Lymph Nodes",
	"104" : "Impaired",
	"105" : "Palpable (Normal)",
	"106" : "Not Palpable",
	"107" : "Tenderness",
	"108" : "Right",
	"109" : "Left",
	"110" : "Regular (Normal)",
	"111" : "Irregular",
	"112" : "Murmurs",
	"113" : "Pulses",
	"114" : "Carotid",
	"115" : "Femoral",
	"116" : "Radial",
	"117" : "Presence of Edema",
	"118" : "Bilateral",
	"119" : "Unilateral Right",
	"120" : "Unilateral Left",
	"121" : "Hepatomegaly",
	"122" : "Splenomegaly",
	"123" : "LUQ Pain",
	"124" : "LLQ Pain",
	"125" : "RUQ Pain",
	"126" : "RLQ Pain",
	"127" : "Guarding",
	"128" : "Rebound",
	"129" : "Spine",
	"130" : "Upper Extremities Right",
	"131" : "Upper Extremities Left",
	"132" : "Lower Extremities Right",
	"133" : "Lower Extremities Left",
	"134" : "Cranial Nerves",
	"135" : "Motor Strength",
	"136" : "Sensation",
	"137" : "Gait",	
	"138" : "Depression",
	"139" : "Suicidal"
};


var ADD_NEW_USER_ERROR = "Error. Cannot add new user because a user with that username already exists.";
var ALERT_INVALID_EDIT_CODE = "Error. Edit code must be at least 6 characters/digits.";

var TOUCH_HERE = "Touch Here";
var OTHER = "Other";
var OTHER_TREATMENT = "Other Treatment";
var NORMAL_CAPS = "NORMAL";

var EXAMS_NORMAL_CHOICE = '0';
var EXAMS_OTHER_CHOICE = '-1';

var NORMAL = "Normal";
var ABNORMAL = "Abnormal";
var NORMAL_IN_PARANTHESES = "(Normal)";
var ABNORMAL_IN_PARANTHESES = "(Abnormal)";

var normal_abnormal_array = ["3", "4"];

var BOOLEAN_UNKNOWN = 0;
var BOOLEAN_FALSE = 1;
var BOOLEAN_TRUE = 2;

var CATEGORIES_MORE_OPTIONS = "Categories (More Options)";
var CATEGORIES = "Categories";

var GENERAL_TREATMENTS = "General Treatments";

var DIAGNOSIS_MAPPING = {
	"1" : "General/Laboratory",
	"2" : "General Appearance",
	"3" : "Skin",
	"4" : "Head",
	"5" : "Eyes",
	"6" : "Ears",
	"7" : "Nose/Sinuses",
	"8" : "Mouth/Pharynx",
	"9" : "Neck",
	"10" : "Chest/Breasts",
	"11" : "Lungs",
	"12" : "Cardiac",
	"13" : "Vascular",
	"14" : "Abdomen", 
	"15" : "Musculoskeletal",
	"16" : "Neurologic",
	"17" : "Psychiatric",
	"18" : "Genitalia/Rectum",
	"19" : "Anemia",
	"20" : "Dehydration",
	"21" : "Diabetes",
	"22" : "Hypertension",
	"23" : "Pregnant",
	"24" : "Social Problem/Domestic Violence",
	"25" : "Lethargy",
	"26" : "Malnourished",
	"27" : "Eczema",
	"28" : "Impetigo",
	"29" : "Scabies",
	"30" : "Tinea",
	"31" : "Lice",
	"32" : "Allergic/Vital Conjunctivitis",
	"33" : "Bacterial Conjunctivitis",
	"34" : "Cataract",
	"35" : "Corneal Abrasion",
	"36" : "Pterygium",
	"37" : "Vision Issue",
	"38" : "Otitis Externa",
	"39" : "Otitis Media",
	"40" : "Upper Respiratory Infection",
	"41" : "Viral Syndrome",
	"42" : "Caries",
	"43" : "Gingivitis",
	"44" : "Pharyngitis",
	"45" : "Thrush",
	"46" : "Neck Pain",
	"47" : "Cardiac Chest Pain (Urgent)",
	"48" : "Non-Cardiac Chest Pain",
	"49" : "Asthma",
	"50" : "Bronchitis",
	"51" : "Pneumonia",
	"52" : "Amoebiasis",
	"53" : "Gastritis/Reflux",
	"54" : "Gastroenteritis",
	"55" : "Intestinal Parasites",
	"56" : "Arthritis",
	"57" : "Back Pain",
	"58" : "Traumatic Injury",
	"59" : "Muscle Pain",
	"60" : "Overuse Muscle Pain",
	"61" : "Headache",
	"62" : "Depression",
	"63" : "Emotional Issue",
	"64" : "Suicidal",
	"65" : "Bacterial Vaginitis",
	"66" : "Urinary Tract Infection",
	"67" : "Yeast Infection"
};

var TREATMENT_MAPPING = {
	"1" : "Multivitamins with Iron",
	"2" : "Oral Rehydration Packets",
	"3" : "Fluids",
	"4" : "Metformin",
	"5" : "Glibenclamide",
	"6" : "Metformin/Glibenclamide Combination",
	"7" : "Hydrochlorothiazide",
	"8" : "Ibuprofen",
	"9" : "Acetamenophen",
	"10" : "Naproxen",
	"11" : "Vitamins",
	"12" : "Clotrimazole",
	"13" : "Antifungal Other",
	"14" : "Benzyl Benzoate",
	"15" : "Permethrin",
	"16" : "Ivermectin",
	"17" : "Antibiotic Ointment",
	"18" : "Oral Antibiotic: Cephalexin",
	"19" : "Hydrocortisone Ointment",
	"20" : "Medicated Shampoo",
	"21" : "Ophthalmic Antibiotic Ointment",
	"22" : "Ophthalmic Antibiotic Drops",
	"23" : "Eye Drops (Visine)",
	"24" : "Artificial Tears",
	"25" : "Saline Drops",
	"26" : "Glasses",
	"27" : "Sun Glasses",
	"28" : "Otic Antibiotic Drops",
	"29" : "Oral Antibiotic: Amoxicillin",
	"30" : "Decongestant",
	"31" : "Toothbrush",
	"32" : "Toothpaste",
	"33" : "Floss",
	"34" : "Antifungal",
	"35" : "Aspirin",
	"36" : "Bronchodilator",
	"37" : "Inhaled Steroids",
	"38" : "Oral Steroids",
	"39" : "Cough Suppressant",
	"40" : "Oral Antibiotic: Azithromycin",
	"41" : "Antacids/Tums",
	"42" : "H2 Antogonist (Ranitidine)",
	"43" : "PPI (Omeprazole)",
	"44" : "Oral Antibiotic: Cipro",
	"45" : "Oral Antiprotozoal: Metronidazole",
	"46" : "Oral Antihelmintic: Albendazole",
	"47" : "Oral Antihelmintic: Mebendazole",
	"48" : "Wound Care Materials",
	"49" : "Oral Antifungal",
	"50" : "Vaginal Antifungal",
	"51" : "Oral Antibiotic: Trim/Sulfa",
	"52" : "Prenatal Vitamins",
	"53" : "Adult Vitamins",
	"54" : "Child Vitamins"
};

var ALLERGIES = "Allergies";
var ILLNESSES_CONDITIONS = "Illnesses/Conditions";
var SURGERIES = "Surgeries";
var MEDICATIONS = "Medications";
var INCORRECT = "Incorrect";

var EMPTY_FIELDS_MUST_COMPLETE_MESSAGE = "ERROR: EMPTY FIELD. MUST COMPLETE ALL QUESTIONS.";

var ALLERGY_NAME_MISSING_MESSAGE = "Must enter an allergy name.";
var ILLNESS_NAME_MUST_SELECT_MESSAGE = "Must select an illness name.";
var ILLNESS_NAME_CUSTOM_MISSING_MESSAGE = "Must enter a custom illness name.";
var SURGERY_NAME_MUST_SELECT_MESSAGE = "Must select a surgery name.";
var SURGERY_NAME_CUSTOM_MISSING_MESSAGE = "Must enter a custom surgery name.";
var MEDICATION_NAME_MISSING_MESSAGE = "Must enter a medication name.";

var CHIEF_COMPLAINT_NOTHING_SELECTED_MESSAGE1 = "ERROR: Must select an option.";
var CHIEF_COMPLAINT_NOTHING_SELECTED_MESSAGE2 = "ERROR: Must complete Other option.";

var MEASUREMENTS_TEMPERATURE_UNITS_MESSAGE = "ERROR: Must selects units for Temperature.";
var MEASUREMENTS_WEIGHT_UNITS_MESSAGE = "ERROR: Must select units for Weight.";
var MEASUREMENTS_HEIGHT_UNITS_MESSAGE = "ERROR: Must select units for Height.";
var MEASUREMENTS_WAIST_CIRCUMFERENCE_UNITS_MESSAGE = "ERROR: Must select units for Waist Circumference.";

var EXAM_MUST_SELECT_OPTIONS = "ERROR: No options are selected.";
var EXAM_NAME_OTHER_MESSAGE = "ERROR: Must enter Other Exam Name.";
var EXAM_INVALID_SUBMIT_MESSAGE = "ERROR: Cannot select Normal option and another option.";
var EXAM_NAME_OTHER_MESSAGE1 = "ERROR: Must enter Other option or unselect it.";

var DIAGNOSIS_EMPTY_OTHER_MESSAGE = "ERROR: Must enter a name for other diagnosis.";
var DIAGNOSIS_EMPTY_CHRONIC_MESSAGE = "ERROR: Must select wheter Chronic or Acute.";

var TREATMENT_EMPTY_OTHER_MESSAGE = "ERROR: Must enter a name for other treatment.";
var TREATMENT_STRENGTH_UNITS_MESSAGE = "ERROR: Must enter another strength unit or select another option.";
var TREATMENT_CONC1_UNITS_MESSAGE = "ERROR: Must enter another Concentration Part 1 Unit or select another option.";
var TREATMENT_CONC2_UNITS_MESSAGE = "ERROR: Must enter another Concentration Part 2 Unit or select another option.";
var TREATMENT_CONC_MESSAGE = "ERROR: Must complete both concentration inputs or leave both blank.";
var TREATMENT_QUANTITY_UNITS_MESSAGE = "ERROR: Must enter another Quantity Unit or select another option.";
var TREATMENT_ROUTE_OTHER_MESSAGE = "ERROR: Must enter another Route or select another option.";
var TREATMENT_DOSAGE_UNITS_MESSAGE = "ERROR: Must enter another Dosage Unit or select another option.";
var TREATMENT_FREQUENCY_OTHER_MESSAGE = "ERROR: Must enter another Frequency or select another option.";
var TREATMENT_DURATION_UNITS_MESSAGE = "ERROR: Must enter another Duration Unit or select another option.";


