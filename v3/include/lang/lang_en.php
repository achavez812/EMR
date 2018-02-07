<?php

define("HOME", "Home");
define("TOUCH_HERE", "Touch Here");

define("LANGUAGE_IDIOMA", "Lang/Idioma");
define("ENGLISH", "English");
define("SPANISH", "Español");

define("REGISTRY_BROWSE", "Registry/Browse");
define("READY_FOR_TRIAGE_INTAKE", "Ready for Triage/Intake");
define("READY_FOR_MEDICAL_CONSULT", "Ready for Medical Consult");
define('READY_FOR_TRIAGE_INTAKE_ABBREVIATION', 'Ready for<br>Triage/In');
define('READY_FOR_MEDICAL_CONSULT_ABBREVIATION', 'Ready for<br>Med Cnslt');
define('TRIAGE_INTAKE_PENDING', "Triage/Intake Pending");
define('MEDICAL_CONSULT_PENDING', "Medical Consult Pending");
define('TRIAGE_INTAKE_IN_PROGRESS', "Triage/Intake In Progress");
define('MEDICAL_CONSULT_IN_PROGRESS', "Medical Consult In Progress");
define('COMPLETED_CONSULTS_TODAY', "Completed Consults Today");
define('COMPLETED_CONSULT_TODAY', "Completed Consult Today");
define('COMPLETED_CONSULTS_TODAY_ABBREVIATION', "Cmpl. Cons. Today");
define('NO_COMPLETED_CONSULTS_TODAY', "No Completed Consults Today");
define('COMPLETED_CONSULT', "Completed Consult");

define("READY_FOR_FIELD", "Ready For:");


define('TRIAGE_INTAKE', 'Triage/Intake');
define('MEDICAL_CONSULT', 'Medical Consult');

define('TRIAGE_INTAKE_ABBREVIATION', 'Triage/In');
define('MEDICAL_CONSULT_ABBREVIATION', 'Med Cnslt');

define("BACK_TO_HOME_PAGE", "Back to Home Page");
define("BACK_TO_COMMUNITIES", "Back to Communities");
define("BACK_TO", "Back to");
define("BACK_TO_PROFILE", "Back to Profile");
define("BACK_TO_TRIAGE_INTAKE_LIST", "Back to Triage/Intake List");
define("BACK_TO_MEDICAL_CONSULT_LIST", "Back to Medical Consult List");
define("BACK_TO_COMPLETED_CONSULTS_LIST", "Back to Completed Consults List");

define("PATIENT_PROFILE", "Patient Profile");


define("HOME_SET_REGISTRY_BROWSE_MESSAGE", "The main Registry/Browse page has been set as the home page.");
define("HOME_SET_TRIAGE_INTAKE_MESSAGE", "The main Triage/Intake Queue page has been set as the home page.");
define("HOME_SET_MEDICAL_CONSULT_MESSAGE", "The main Medical Consult Queue page has been set as the home page.");



define("PATIENT_MATCHES_FOUND", "It is possible this patient has already been registered. Please review the following matches. If one of the results is correct, you can click on it. If none of the results are correct, please click 'SAVE'.");
define("PATIENT_MATCHES", "Patient Matches");


define('COMMUNITIES', 'Communities');
define('PATIENTS', 'Patients');
define('SEARCH_PATIENTS', 'Search Patients');

define('SEARCH_RESULTS', 'Search Results');
define('SEARCH_FIELD', 'Search:');
define('NO_MATCHING_RESULTS', "No Matching Results");

define('RESULTS', 'Results');
define('RESULTS_IN_COMMUNITY', 'Results in Community');
define('OTHER_RESULTS', 'Other Results');

define('NO_PATIENTS_IN_COMMUNITY_MESSAGE', "There are no registered patients in this community.");

define('NAME_FIELD', "Name:");
define('COMMUNITY_FIELD', "Community:");
define('SEX_FIELD', "Sex:");
define('IS_EXACT_DOB_KNOWN', "Is the exact date of birth known?");
define('DATE_OF_BIRTH_FIELD', "Date of Birth:");
define('AGE_YEARS_FIELD', "Age (Years):");

define('AGE_FIELD', "Age:");
define('CONSULT_FIELD', "Consult:");
define('CONSULT', "Consult");

define('MALE', "Male");
define('FEMALE', "Female");
define('UNKNOWN', "Unknown");
define('YES', "Yes");
define('NO', "No");
define("OTHER_COMMUNITY", "Other Community");
define("OTHER_COMMUNITY_FIELD", "Other Community:");

define('ADD_NEW_PATIENT', 'Add New Patient');
define('EDIT_PATIENT', "Edit Patient");
define('SAVE_CAPS', 'SAVE');
define('EDIT_CAPS', 'EDIT');
define('DELETE_CAPS', 'DELETE');

define("APPROXIMATE_ABBREVIATION", "(App.)");

define("SETTINGS", "Settings");

define("CONSULT_CAPS", "CONSULT");
define("HISTORY_CAPS", "HISTORY");
define("HISTORY", "History");

define("POST_MESSAGE", "Post Message");
define("ACTIVE_MESSAGES", "Active Messages");
define("POSTED_BY_FIELD", "Posted By:");

define("PAST_CONSULTS", "Past Consults");
define("ACTIVE", "Active");
define("COMPLETED", "Completed");
define("NO_PAST_CONSULTS", "There are no past consults for this patient.");


define("MESSAGE", "Message");
define("MESSAGE_FIELD", "Message:");
define("NAME_OF_POSTER_FIELD", "Name of Poster:");
define("STATUS_FIELD", "Status:");
define("INACTIVE", "Inactive");

define('DUE_ALL', "All");
define('PENDING', "Pending");
define("IN_PROGRESS", "In Progress");

define('PENDING_NOT_STARTED', 'Pending (Not Started)');

define("GO_TO_ACTIVE_CONSULT", "Go to Active Consult");
define('ACTIVE_CONSULT', 'Active Consult');

define('CHIEF_COMPLAINT_HPI', 'Chief Complaint/HPI');
define('HISTORY_OF_PRESENT_ILLNESS', 'History of Present Illness');
define('VITAL_SIGNS_MEASUREMENTS', 'Vital Signs/Measurements');
define('VITALS_MEASUREMENTS', 'Vitals/Measurements');


define('EXAMS', 'Exams');
define('DIAGNOSES', 'Diagnoses');
define('DIAGNOSIS', 'Diagnosis');
define('TREATMENT', 'Treatment');
define('TREATMENTS', 'Treatments');
define('FOLLOWUP', 'Followup');
define('SIGN_AND_COMPLETE', 'Sign and Complete');
define('SIGNATURE_INFORMATION', 'Signature Information');

define('DELETE_CONSULT', 'Delete Consult');

define('CHIEF_COMPLAINTS', "Chief Complaints");
define('PRIMARY_CHIEF_COMPLAINT', 'Primary Chief Complaint');
define('PRIMARY_CHIEF_COMPLAINT_FIELD', 'Primary Chief Complaint:');

define('SECONDARY_CHIEF_COMPLAINT', 'Secondary Chief Complaint');
define('SECONDARY_CHIEF_COMPLAINT_FIELD', 'Secondary Chief Complaint:');

define('SELECT_NEW_OPTIONS', 'Select New Options');
define('SELECTED_OPTIONS', 'Selected Options');
define('OPTIONS_FIELD', 'Options:');

define('NONE_PREVIOUSLY_SELECTED', 'None Previously Selected');
define('NONE_SELECTED', 'None Selected');
define('SELECTED_FIELD', 'Selection:');

define('OTHER', 'Other');
define('OTHER_EXAM_FIELD', 'Other Exam:');

const MONTH_ABBREVIATIONS = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

define('PREGNANCY', 'Pregnancy');


//MAX KEY VALUE IS "255"
const DEFAULT_CHIEF_COMPLAINT_MAP = [
	"1" => "Abdominal Pain",
	"2" => "Acid Reflux",
	"3" => "Chest Pain",
	"4" => "Cold/Flu",
	"5" => "Cough",
	"6" => "Dental Issue",
	"7" => "Depression",
	"8" => "Diarrhea",
	"9" => "Ear Pain",
	"10" => "Eye Irritation",
	"11" => "Fever",
	"12" => "Headache",
	"13" => "Joint Pain",
	"14" => "Muscle Ache/Pain",
	"15" => "Nausea",
	"16" => "Pain with Urination",
	"17" => "Pregnancy",
	"18" => "Rash/Skin Irritation",
	"19" => "Shortness of Breath",
	"20" => "Vision Issues",
	"21" => "Throat Pain/Soreness",
	"22" => "Wound/Laceration"
];

define("HOW_DID_THE_PAIN_BEGIN", "How did the pain begin?");
define("WHAT_CAUSED_THE_PAIN", "What caused the pain?");
define("WHAT_WORSENS_THE_PAIN", "What worsens the pain?");
define("WHAT_LESSENS_THE_PAIN", "What lessens the pain?");
define("TYPE_OF_PAIN", "Type of Pain:");
define("MAIN_REGION_OF_PAIN", "Main region of pain:");
define("REGIONS_WHERE_PAIN_RADIATES", "Regions where pain radiates:");
define("PAIN_SEVERITY", "Pain Severity (0-10):");
define("HOW_LONG_SINCE_ISSUE_BEGAN", "How long since issue began?");
define("HAS_PATIENT_EXPERIENCED_BEFORE", "Has the patient experienced this issue before?");
define("DOES_PATIENT_CURRENTLY_HAVE_ISSUE", "Does the patient currently have this issue?");

const O_PAIN_HOW_ARRAY = ["Gradually", "Suddenly"];
const O_PAIN_CAUSE_ARRAY = ["Inactivity", "Physical Activity", "Stress"];
const P_PAIN_PROVOCATION_ARRAY = ["Physical Activity", "Pressure on Area"];
const P_PAIN_PALLIATION_ARRAY = ["Medication", "Rest"];
const Q_PAIN_TYPE_ARRAY = ["Burning", "Constant", "Crushing", "Dull/Numb", "Intermittent", "Itching", "Sharp", "Stabbing", "Tearing", "Throbbing"];
const R_PAIN_REGION_ARRAY = ["Head", "Scalp", "Forehead", "Ears", "Eyes", "Nose", "Mouth", "Jaw", "Chin", "Neck", "Shoulders", "Back (Upper)", "Back (Lower)", "Chest", "Abdomen", "Stomach", "Hip", "Arm", "Elbow", "Forearm", "Hand", "Fingers", "Groin", "Buttocks", "Leg", "Thigh", "Knee", "Calf", "Shin", "Ankle", "Foot", "Heel", "Toes"];
const TIME_OPTION_ARRAY = ["Hours", "Days", "Weeks", "Months", "Years"];


define("HOW_MANY_WEEKS_PREGNANT", "How many weeks pregnant?");
define("RECEIVING_PRENATAL_CARE", "Receiving prenatal care?");
define("TAKING_PRENATAL_VITAMINS", "Taking prenatal vitamins?");
define("RECEIVED_ULTRASOUND", "Received Ultrasound?");
define("HOW_MANY_LIVE_BIRTHS", "How many live births?");
define("HOW_MANY_MISCARRIAGES", "How many miscarriages?");
define("ANY_DYSURIA_URGENCY_OR_FREQUENCY", "Any Dysuria urgency or frequency?");
define("ANY_ABNORMAL_VAGINAL_DISCHARGE", "Any abnormal vaginal discharge?");
define("ANY_VAGINAL_BLEEDING", "Any vaginal bleeding?");
define("ANY_PREVIOUS_PREGNANCY_COMPLICATIONS", "Any previous pregnancy complications?");
define("FURTHER_EXPLANATION", "Further Explanation");
define("NOTES_FIELD", "Notes:");

define("IS_PREGNANT", "Is currently pregnant?");
define("DATE_LAST_MENSTRUATION", "Date of Last Menstruation");
define("TEMPERATURE_UNITS", "Temperature Units");
define("FAHRENHEIT_ABBREVIATION", "F");
define("CELSIUS_ABBREVIATION", "C");
define("TEMPERATURE_VALUE", "Temperature Value");
define("BLOOD_PRESSURE_SYSTOLIC", "Blood Pressure Systolic");
define("BLOOD_PRESSURE_DIASTOLIC", "Blood Pressure Diastolic");
define("PULSE_RATE", "Pulse Rate");
define("BLOOD_OXYGEN_SATURATION", "Blood Oxygen Saturation");
define("RESPIRATION_RATE", "Respiration Rate");
define("WEIGHT_UNITS", "Weight Units");
define("POUNDS_ABBREVIATION", "lb");
define("KILOGRAMS_ABBREVIATION", "kg");
define("WEIGHT_VALUE", "Weight Value");
define("HEIGHT_UNITS", "Height Units");
define("CENTIMETERS_ABBREVIATION", "cm");
define("INCHES_ABBREVIATION", "in");
define("HEIGHT_VALUE", "Height");
define("WAIST_CIRCUMFERENCE_UNITS", "Waist Circumference Units");
define("WAIST_CIRCUMFERENCE_VALUE", "Waist Circumference Value");

define("PATIENT_IS_PREGNANT", "Patient is pregnant.");
define("TEMPERATURE_FIELD", "Temperature:");
define("BLOOD_PRESSURE_FIELD", "Blood Pressure:");
define("WAIST_CIRCUMFERENCE_FIELD", "Waist Circumference:");
define("WEIGHT_FIELD", "Weight:");
define("HEIGHT_FIELD", "Height:");
define("BMI_FIELD", "BMI:");

define("GO_BACK", "Go Back");

define("EXAM_TYPE", "Exam Type");

define("NORMAL_IN_PARANTHESES", "(Normal)");
define("ABNORMAL_IN_PARANTHESES", "(Abnormal)");

define("ABNORMAL_ABBREVIATION_IN_PARANTHESES", "(Abn.)");

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
	"14" => "Blood Glucose", 
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
	"25" => "Feet",
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
	"83" => "Inflamed",
	"84" => "Outer Ear",
	"85" => "Canal",
	"86" => "Tympanic Membrane",
	"87" => "Light Reflex",
	"88" => "Painful Movement",
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

define("MAIN_OPTIONS", "Main Options");
define("CATEGORIES", "Categories");
define("CATEGORIES_MORE_OPTIONS", "Categories (More Options)");
define("FULL_LIST", "Full List");
define("FULL_LIST_CAPS", "FULL LIST");
define("INFORMATION_FIELD", "Information:");
define("TYPE_FIELD", "Type:");
define("CHRONIC", "Chronic");
define("ACUTE", "Acute");

define("MEDICATION_CONSULT_MESSAGE", "This medication was added through a consult.");


const DIAGNOSIS_MAPPING = [
	"1" => "General/Laboratory",
	"2" => "General Appearance",
	"3" => "Skin",
	"4" => "Head",
	"5" => "Eyes",
	"6" => "Ears",
	"7" => "Nose/Sinuses",
	"8" => "Mouth/Pharynx",
	"9" => "Neck",
	"10" => "Chest/Breasts",
	"11" => "Lungs",
	"12" => "Cardiac",
	"13" => "Vascular",
	"14" => "Abdomen", 
	"15" => "Musculoskeletal",
	"16" => "Neurologic",
	"17" => "Psychiatric",
	"18" => "Genitalia/Rectum",
	"19" => "Anemia",
	"20" => "Dehydration",
	"21" => "Diabetes",
	"22" => "Hypertension",
	"23" => "Pregnant",
	"24" => "Social Problem/Domestic Violence",
	"25" => "Lethargy",
	"26" => "Malnourished",
	"27" => "Eczema",
	"28" => "Impetigo",
	"29" => "Scabies",
	"30" => "Tinea",
	"31" => "Lice",
	"32" => "Allergic/Vital Conjunctivitis",
	"33" => "Bacterial Conjunctivitis",
	"34" => "Cataract",
	"35" => "Corneal Abrasion",
	"36" => "Pterygium",
	"37" => "Vision Issue",
	"38" => "Otitis Externa",
	"39" => "Otitis Media",
	"40" => "Upper Respiratory Infection",
	"41" => "Viral Syndrome",
	"42" => "Caries",
	"43" => "Gingivitis",
	"44" => "Pharyngitis",
	"45" => "Thrush",
	"46" => "Neck Pain",
	"47" => "Cardiac Chest Pain (Urgent)",
	"48" => "Non-Cardiac Chest Pain",
	"49" => "Asthma",
	"50" => "Bronchitis",
	"51" => "Pneumonia",
	"52" => "Amoebiasis",
	"53" => "Gastritis/Reflux",
	"54" => "Gastroenteritis",
	"55" => "Intestinal Parasites",
	"56" => "Arthritis",
	"57" => "Back Pain",
	"58" => "Traumatic Injury",
	"59" => "Muscle Pain",
	"60" => "Overuse Muscle Pain",
	"61" => "Headache",
	"62" => "Depression",
	"63" => "Emotional Issue",
	"64" => "Suicidal",
	"65" => "Bacterial Vaginitis",
	"66" => "Urinary Tract Infection",
	"67" => "Yeast Infection"
];

const TREATMENT_MAPPING = [
	"1" => "Multivitamins with Iron",
	"2" => "Oral Rehydration Packets",
	"3" => "Fluids",
	"4" => "Metformin",
	"5" => "Glibenclamide",
	"6" => "Metformin/Glibenclamide Combination",
	"7" => "Hydrochlorothiazide",
	"8" => "Ibuprofen",
	"9" => "Acetamenophen",
	"10" => "Naproxen",
	"11" => "Vitamins",
	"12" => "Clotrimazole",
	"13" => "Antifungal Other",
	"14" => "Benzyl Benzoate",
	"15" => "Permethrin",
	"16" => "Ivermectin",
	"17" => "Antibiotic Ointment",
	"18" => "Oral Antibiotic: Cephalexin",
	"19" => "Hydrocortisone Ointment",
	"20" => "Medicated Shampoo",
	"21" => "Ophthalmic Antibiotic Ointment",
	"22" => "Ophthalmic Antibiotic Drops",
	"23" => "Eye Drops (Visine)",
	"24" => "Artificial Tears",
	"25" => "Saline Drops",
	"26" => "Glasses",
	"27" => "Sun Glasses",
	"28" => "Otic Antibiotic Drops",
	"29" => "Oral Antibiotic: Amoxicillin",
	"30" => "Decongestant",
	"31" => "Toothbrush",
	"32" => "Toothpaste",
	"33" => "Floss",
	"34" => "Antifungal",
	"35" => "Aspirin",
	"36" => "Bronchodilator",
	"37" => "Inhaled Steroids",
	"38" => "Oral Steroids",
	"39" => "Cough Suppressant",
	"40" => "Oral Antibiotic: Azithromycin",
	"41" => "Antacids/Tums",
	"42" => "H2 Antogonist (Ranitidine)",
	"43" => "PPI (Omeprazole)",
	"44" => "Oral Antibiotic: Cipro",
	"45" => "Oral Antiprotozoal: Metronidazole",
	"46" => "Oral Antihelmintic: Albendazole",
	"47" => "Oral Antihelmintic: Mebendazole",
	"48" => "Wound Care Materials",
	"49" => "Oral Antifungal",
	"50" => "Vaginal Antifungal",
	"51" => "Oral Antibiotic: Trim/Sulfa",
	"52" => "Prenatal Vitamins",
	"53" => "Adult Vitamins",
	"54" => "Child Vitamins"
];

define("PRN", "PRN");
define("SCHEDULED", "Scheduled");
define("TREATMENT_NAME", "Treatment Name");
define("INSCRIPTION_SUBSCRIPTION", "Inscription/Subscription");
define("STRENGTH_PER_UNIT", "Strength per Unit");
define("OTHER_STRENGTH_UNITS", "Other Strength Units");
define("CONCENTRATION_PEDS", "Concentration (Peds)");
define("OTHER_CONC_1_UNITS", "Other CONC 1 Units");
define("OTHER_CONC_2_UNITS", "Other CONC 2 Units");
define("QUANTITY", "Quantity");
define("OTHER_QUANTITY_UNITS", "Other Quantity Units");
define("PATIENT_USE_DIRECTIONS", "Patient Use Directions");
define("ROUTE", "Route");
define("OTHER_ROUTE", "Other Route");
define("WHEN", "When?");
define("DOSAGE", "Dosage");
define("OTHER_DOSAGE_UNITS", "Other Dosage Units");
define("FREQUENCY", "Frequency");
define("OTHER_FREQUENCY", "Other Frequency");
define("DURATION", "Duration");
define("OTHER_DURATION_UNITS", "Other Duration Units");
define("ADD_TO_MEDICATION_HISTORY", "Add to medication history?");

const STRENGTH_UNITS_ARRAY = ["mg", "mL", "mcg", "g"];
const CONC_PART_ONE_UNITS_ARRAY = ["mg", "mcg", "g"];
const CONC_PART_TWO_UNITS_ARRAY = ["mL", "mcL", "L"];
const QUANTITY_UNITS_ARRAY = ["Units", "Capsules", "Tablets", "Bottles", "mg", "mL"];
const ROUTE_ARRAY = ["N/A", "PO/Oral", "Skin", "Ophthalmic", "Otic", "Vaginal"];
const DOSAGE_UNITS_ARRAY = ["Units", "Capsules", "Tablets", "mg", "mL", "tsp", "Tbsp"];
const FREQUENCY_ARRAY = ["N/A", "QD/Daily", "BID", "TID", "QID", "Q1H", "Q2H", "Q3H", "Q4H", "Q6H", "Q8H", "Q12H"];
const DURATION_UNITS_ARRAY = ["Days", "Weeks", "Months", "Until None Left"];


define("ALLERGIES", "Allergies");
define("NKDA", "No Known Drug Allergies (NKDA)");
define("ILLNESSES_CONDITIONS", "Illnesses/Conditions");
define("SURGERIES", "Surgeries");
define("MEDICATIONS", "Medications");
define("NO_REPORTED_INFORMATION", "No Reported Information");
define("NO_INFORMATION", "No Information");

define("ALLERGY_NAME_FIELD", "Allergy Name:");
define("SURGERY_NAME_FIELD", "Surgery Name:");
define("MEDICATION_NAME_FIELD", "Medication Name:");
define("DATE_FIELD", "Date:");
define("LEAVE_BLANK_IF_CURRENT", "Leave Blank if Current");
define("START_DATE_FIELD", "Start Date:");
define("END_DATE_FIELD", "End Date:");

const ILLNESS_ARRAY = ['Touch Here', 'Diabetes', 'Hypertension', 'Asthma', 'Gastritis', 'Stroke', 'Heart Attack', 'Anemia', 'Other'];
const SURGERY_ARRAY = ['Touch Here', 'Appendectomy', 'Cesarean Section', 'Hysterectomy', 'Other'];

define("CANNOT_EDIT_DELETE", "This cannot be edited/deleted because it was logged through a consult.");
define("GO_TO_CONSULT", "Go to Consult");

const FOLLOWUP_TYPE_ARRAY = ["Touch Here", "Refer to Hospital Obras Sociales M.G.S.", "Refer for Promoter Program Followup", "Other"];
const FOLLOWUP_REASON_MAP = array(1 => ["Touch Here", "Evaluation by Dr. Tun", "Laboratory Exam", "Other"], 2 => ["Touch Here", "Clinical Status", "Wound Treatment", "Medication Delivery", "Other"]);

define("IS_A_FOLLOWUP_NEEDED", "Is a followup/referral needed?");
define("FOLLOWUP_REFERRAL", "Followup/Referral");
define("FOLLOWUP_REFERRAL_CUSTOM", "Followup/Referral Custom");
define("REASON", "Reason");
define("REASON_CUSTOM", "Reason Custom");

define("MEDICAL_GROUP_FIELD", "Medical Group:");
define("CHIEF_PHYSICIAN_FIELD", "Chief Physician:");
define("LOCATION_FIELD", "Location:");
define("SIGNING_PHYSICIAN_FIELD", "Signing Physician:");

define("LOG_CONSULT_AS_COMPLETE", "Log Consult as Complete?");

define("NOT_NEEDED", "Not Needed");

define("EDIT_VALIDATION", "EDIT VALIDATION");
define("EDIT_CODE", "Edit Code");
define("SUBMIT", "Submit");

define("DELETE_MESSAGE", "ENTER THE FOLLOWING CODE TO DELETE THIS CONSULT: ");
define("CANNOT_DELETE_CONSULT_MESSAGE", "All contents of the consult must be deleted before being able to delete the consult itself.");

?>