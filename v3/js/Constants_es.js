var EXAMS_MAP = {
	"1" : "Laboratorio",
	"2" : "Physical",
	"3" : "Normal",
	"4" : "Anormal",
	"5" : "No (Normal)",
	"6" : "Sí",
	"7" : "No Embarazada (Normal)",
	"8" : "Sí Embarazada",
	"9" : "Sangres",
	"10" : "Heces",
	"11" : "Embarazo",
	"12" : "Orina",
	"13" : "HbA1c",
	"14" : "Glucosa", 
	"15" : "Cara",
	"16" : "Cuello",
	"17" : "Hombros",
	"18" : "Pecho",
	"19" : "Abdomen",
	"20" : "Espalda (Superior)",
	"21" : "Espalda (Inferior)",
	"22" : "Brazos",
	"23" : "Manos",
	"24" : "Piernas",
	"25" : "Pies",
	"26" : "Ninguna (Normal)",
	"27" : "Elevado",
	"28" : "Pústula(s)",
	"29" : "Vesículas",
	"30" : "Buen Movimiento de Aire (Normal)",
	"31" : "Sibilancias",
	"32" : "Consolidación",
	"33" : "Rhonchi/Rales",
	"34" : "Murphys",
	"35" : "Dolor",
	"36" : "Rango de Movimiento",
	"37" : "Intacto (Normal)",
	"38" : "No Intacto",
	"39" : "Codos",
	"40" : "Muñecas",
	"41" : "Dedos",
	"42" : "Cadera",
	"43" : "Rodillas",
	"44" : "Tobillos",
	"45" : "Extremidad Superior Derecha",
	"46" : "Extremidad Superior Izquierda",
	"47" : "Extremidad Inferior Derecha",
	"48" : "Extremidad Inferior Izquierda",
	"49" : "Apariencia General",
	"50" : "Piel",
	"51" : "Cabeza",
	"52" : "Ojos",
	"53" : "Oidos",
	"54" : "Nariz/Senos Paranasales",
	"55" : "Boca/Faringe",
	"56" : "Pecho",
	"57" : "Pulmones",
	"58" : "Cardíaco",
	"59" : "Vascular",
	"60" : "Musculoesquelético",
	"61" : "Neurológico",
	"62" : "Psiquiátrico",
	"63" : "Genitales/Recto",
	"64" : "Enfermo",
	"65" : "Con Dolor",
	"66" : "Letárgico",
	"67" : "Color de Piel",
	"68" : "Lesion(es)",
	"69" : "Lesions(es) to Cuero Cabelludo",
	"70" : "Fontanelles",
	"71" : "Hundido",
	"72" : "Acuidad",
	"73" : "Párpados",
	"74" : "Esclerótico",
	"75" : "Conjuntiva",
	"76" : "Pupilas",
	"77" : "Movimientos Extraoculares",
	"78" : "Drenaje",
	"79" : "Rojo",
	"80" : "Inyectado",
	"81" : "Lentos",
	"82" : "Asimétrico",
	"83" : "Inflamado",
	"84" : "Oído externo",
	"85" : "Canal",
	"86" : "Membrana Timpánica",
	"87" : "Reflejo de Luz",
	"88" : "Movimiento Doloroso",
	"89" : "Cerumen",
	"90" : "Fluido",
	"91" : "Rinorrea",
	"92" : "Sensibilidad al Seno",
	"93" : "Mucosa Bucal/Oral",
	"94" : "Condición de los Dientes/Encías",
	"95" : "Faringe/Amígdalas",
	"96" : "Húmedo",
	"97" : "Seco",
	"98" : "Carries/Bajo",
	"99" : "Eritematoso",
	"100" : "Exudados de Amígdala",
	"101" : "Eritema Faríngeo",
	"102" : "Dolor de Garganta a Palpación",
	"103" : "Ganglios Linfáticos",
	"104" : "Dañado",
	"105" : "Palpable (Normal)",
	"106" : "No Palpable",
	"107" : "Sensibilidad",
	"108" : "Derecho",
	"109" : "Izquierdo",
	"110" : "Regular (Normal)",
	"111" : "Irregular",
	"112" : "Soplo",
	"113" : "Pulsos",
	"114" : "Carótida",
	"115" : "Femoral",
	"116" : "Radial",
	"117" : "Presence of Edema",
	"118" : "Bilateral",
	"119" : "Unilateral Derecho",
	"120" : "Unilateral Izquierdo",
	"121" : "Hepatomegalia",
	"122" : "Esplenomegalia",
	"123" : "Cuadrante Superior Izquierdo Dolor",
	"124" : "Cuadrante Inferior Izquierdo Dolor",
	"125" : "Cuadrante Superior Derecho Dolor",
	"126" : "Cuadrante Inferior Derecho Dolor",
	"127" : "Defensa",
	"128" : "Dolor de Rebote",
	"129" : "Espina",
	"130" : "Extremidad Superior Derecha",
	"131" : "Extremidad Superior Izquierda",
	"132" : "Extremidad Inferior Derecha",
	"133" : "Extremidad Inferior Izquierda",
	"134" : "Nervios Craneales",
	"135" : "Fuerza del Motor",
	"136" : "Sensación",
	"137" : "Paso",	
	"138" : "Depresión",
	"139" : "Suicida"
};

var ADD_NEW_USER_ERROR = "Error. No se puede agregar ese usuario porque ya existe un usuario con ese nombre de usuario.";

var ALERT_INVALID_EDIT_CODE = "Error. Código de Edición necesita tener al menos 6 letras/dígitos.";

var TOUCH_HERE = "Toque Aquí";
var OTHER = "Otro";
var OTHER_TREATMENT = "Otro Tratamiento";
var NORMAL_CAPS = "NORMAL";

var EXAMS_NORMAL_CHOICE = '0';
var EXAMS_OTHER_CHOICE = '-1';

var NORMAL = "Normal";
var ABNORMAL = "Anormal";
var NORMAL_IN_PARANTHESES = "(Normal)";
var ABNORMAL_IN_PARANTHESES = "(Anormal)";

var normal_abnormal_array = ["3", "4"];

var BOOLEAN_UNKNOWN = 0;
var BOOLEAN_FALSE = 1;
var BOOLEAN_TRUE = 2;

var CATEGORIES_MORE_OPTIONS = "Categorías (Mas Opciones)";
var CATEGORIES = "Categorías";

var GENERAL_TREATMENTS = "Tratamientos Generales";

var DIAGNOSIS_MAPPING = {
	"1" : "General/Laboratorio",
	"2" : "Apariencia General",
	"3" : "Piel",
	"4" : "Cabeza",
	"5" : "Ojos",
	"6" : "Oidos",
	"7" : "Nariz/Senos Paranasales",
	"8" : "Boca/Faringe",
	"9" : "Cuello",
	"10" : "Pecho",
	"11" : "Pulmones",
	"12" : "Cardíaco",
	"13" : "Vascular",
	"14" : "Abdomen", 
	"15" : "Musculoesquelético",
	"16" : "Neurológico",
	"17" : "Psiquiátrico",
	"18" : "Genitales/Recto",
	"19" : "Anemia",
	"20" : "Deshidración",
	"21" : "Diabetes",
	"22" : "Hipertensión",
	"23" : "Embarazada",
	"24" : "Problema Social/Violencia Doméstica",
	"25" : "Letargo",
	"26" : "Desnutrido",
	"27" : "Eczema",
	"28" : "Impétigo",
	"29" : "Sarna",
	"30" : "Tiña",
	"31" : "Piojos",
	"32" : "Conjuntivitis Alérgica/Viral",
	"33" : "Conjuntivitis Bacteriana",
	"34" : "Catarata",
	"35" : "Abrasión Corneal",
	"36" : "Pterigión",
	"37" : "Problema de la Vista",
	"38" : "Otitis Externa",
	"39" : "Otitis Media",
	"40" : "Infección Respiratoria Superior",
	"41" : "Síndrome Viral",
	"42" : "Caries",
	"43" : "Gingivitis",
	"44" : "Faringitis",
	"45" : "Tordo",
	"46" : "Dolor de Cuello",
	"47" : "Dolor de Pecho Cardíaco (Urgente)",
	"48" : "Dolor de Pecho No Cardíaco",
	"49" : "Asma",
	"50" : "Bronquitis",
	"51" : "Neumonía",
	"52" : "Amebiasis",
	"53" : "Gastritis/Reflujo",
	"54" : "Gastroenteritis",
	"55" : "Parásitos Intestinales",
	"56" : "Artritis",
	"57" : "Dolor de Espalda",
	"58" : "Herida Traumática",
	"59" : "Dolor Muscular",
	"60" : "Dolor Muscular por Uso Excesivo",
	"61" : "Dolor de Cabeza",
	"62" : "Depresión",
	"63" : "Problema Emocional",
	"64" : "Suicida",
	"65" : "Vaginitis Bacteriana",
	"66" : "Infección del Tracto Urinario",
	"67" : "Infección por Levaduras"
};

var TREATMENT_MAPPING = {
	"1" : "Multivitaminas con Hierro",
	"2" : "Paquetes de Rehidratación Oral",
	"3" : "Fluidos",
	"4" : "Metformina",
	"5" : "Glibenclamida",
	"6" : "Metformina/Glibenclamida Combinación",
	"7" : "Hidroclorotiazida",
	"8" : "Ibuprofeno",
	"9" : "Acetaminofeno",
	"10" : "Naproxen",
	"11" : "Vitaminas",
	"12" : "Clotrimazol",
	"13" : "Otro Antifúngico",
	"14" : "Benzyl Benzoate",
	"15" : "Permethrin",
	"16" : "Ivermectina",
	"17" : "Pomada Antibiótico",
	"18" : "Antibiótico Oral: Cefalexina",
	"19" : "Pomada de Hidrocortisona",
	"20" : "Champú Medicado",
	"21" : "Pomada Antibiótica Oftálmica",
	"22" : "Gotas Antibióticas Oftálmicas",
	"23" : "Gotas para Ojos (Visine)",
	"24" : "Lagrimas Artificiales",
	"25" : "Gotas Salinas",
	"26" : "Lentes",
	"27" : "Gafas de Sol",
	"28" : "Gotas Óticas Antibióticas",
	"29" : "Antibiótico Oral: Amoxicilina",
	"30" : "Descongestionante",
	"31" : "Cepillo de dientes",
	"32" : "Pasta dental",
	"33" : "Hilo dental",
	"34" : "Antifúngico",
	"35" : "Aspirina",
	"36" : "Broncodilatador",
	"37" : "Esteroides Inhalados",
	"38" : "Esteroides Oral",
	"39" : "Supresor de Tos",
	"40" : "Antibiótico Oral: Azitromicina",
	"41" : "Antiácidos/Tums",
	"42" : "Antagonista H2 (Ranitidina)",
	"43" : "Inhibidores de Bomba de Protones (Omeprazol)",
	"44" : "Antibiótico Oral: Cipro",
	"45" : "Antiprotozoario oral: Metronidazol",
	"46" : "Antihelmíntico Oral: Albendazol",
	"47" : "Oral Antihelmintic: Mebendazol",
	"48" : "Materiales de Cuidado de Heridas",
	"49" : "Oral Antifúngico",
	"50" : "Antifúngico Vaginal",
	"51" : "Antibiótico Oral: Trim/Sulfa",
	"52" : "Vitaminas Prenatales",
	"53" : "Vitaminas para Adultos",
	"54" : "Vitaminas Infantiles"
};

var ALLERGIES = "Alergias";
var ILLNESSES_CONDITIONS = "Enfermedades/Condiciones";
var SURGERIES = "Cirugías";
var MEDICATIONS = "Medicamentos";
var INCORRECT = "Incorrecto";

var EMPTY_FIELDS_MUST_COMPLETE_MESSAGE = "ERROR: CAMPO VACÍO. DEBE COMPLETAR TODAS LAS PREGUNTAS.";

var ALLERGY_NAME_MISSING_MESSAGE = "Necesita ingresar un nombre de alergia.";
var ILLNESS_NAME_MUST_SELECT_MESSAGE = "Necesita escoger un nombre de enfermedad.";
var ILLNESS_NAME_CUSTOM_MISSING_MESSAGE = "Necesita ingresar un nombre de enfermedad.";
var SURGERY_NAME_MUST_SELECT_MESSAGE = "Necesita escoger un nombre de cirugia.";
var SURGERY_NAME_CUSTOM_MISSING_MESSAGE = "Necesita ingresar un nombre de cirugia.";
var MEDICATION_NAME_MISSING_MESSAGE = "Necesita ingresar un nombre de medicamento.";

var CHIEF_COMPLAINT_NOTHING_SELECTED_MESSAGE1 = "ERROR: Necesita seleccionar una opción.";
var CHIEF_COMPLAINT_NOTHING_SELECTED_MESSAGE2 = "ERROR: Necesita llenar otra opción.";

var MEASUREMENTS_TEMPERATURE_UNITS_MESSAGE = "ERROR: NECESITA ESCOGER UNIDADES PARA TEMPERATURA.";
var MEASUREMENTS_WEIGHT_UNITS_MESSAGE = "ERROR: NECESITA ESCOGER UNIDADES PARA PESO.";
var MEASUREMENTS_HEIGHT_UNITS_MESSAGE = "ERROR: NECESITA ESCOGER UNIDADES PARA ESTATURA.";
var MEASUREMENTS_WAIST_CIRCUMFERENCE_UNITS_MESSAGE = "ERROR: NECESITA ESCOGER UNIDADES PARA CIRCUNFERENCIA DE CINTURA.";

var EXAM_MUST_SELECT_OPTIONS = "ERROR: No hay opciones seleccionado.";
var EXAM_NAME_OTHER_MESSAGE = "ERROR: Necesita llenar nombre de Otro Examen.";
var EXAM_INVALID_SUBMIT_MESSAGE = "ERROR: No puede selecionar la opcion Normal y otra al mismo tiempo.";
var EXAM_NAME_OTHER_MESSAGE1 = "ERROR: Necesita llenar otra opcion o no seleccionarlo.";

var DIAGNOSIS_EMPTY_OTHER_MESSAGE = "ERROR: Necesita ingresar un nombre para el otro diagnostico.";
var DIAGNOSIS_EMPTY_CHRONIC_MESSAGE = "ERROR: Necesita selecionnar si es Cronico o Agudo.";

var TREATMENT_EMPTY_OTHER_MESSAGE = "ERROR: Necesita ingresar un nombre para el otro tratamiento.";
var TREATMENT_STRENGTH_UNITS_MESSAGE = "ERROR: NECESITA COMPLETAR CAMPO DE OTRO UNIDADES DE FUERZA O ESCOGER OTRA OPCION.";
var TREATMENT_CONC1_UNITS_MESSAGE = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE CONCENTRACION 1 O ESCOGER OTRA OPCION.";
var TREATMENT_CONC2_UNITS_MESSAGE = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE CONCENTRACION 2 O ESCOGER OTRA OPCION.";
var TREATMENT_CONC_MESSAGE = "ERROR: NECESITA COMPLETAR LOS DOS CAMPOS DE CONCETRACION O DEJARLOS VACIOS.";
var TREATMENT_QUANTITY_UNITS_MESSAGE = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE CANTIDAD O ESCOGER OTRA OPCION.";
var TREATMENT_ROUTE_OTHER_MESSAGE = "ERROR: NECESITA COMPLETAR EL CAMPA DE RUTA O ESCOGER OTRA OPCION.";
var TREATMENT_DOSAGE_UNITS_MESSAGE = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE DOSIS O ESCOGER OTRA OPCION.";
var TREATMENT_FREQUENCY_OTHER_MESSAGE = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE FRECUENCIA O ESCOGER OTRA OPCION.";
var TREATMENT_DURATION_UNITS_MESSAGE = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE DURACION O ESCOGER OTRA OPCION.";