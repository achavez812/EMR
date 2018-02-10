<?php

define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');      
define('DB_NAME', 'db_emr');

define('IMPORT_DIRECTORY', "/media/pi/IMPORT/");
define('EXPORT_DIRECTORY', "/media/pi/EXPORT/");

const BASE_COMMUNITIES = ["Providencia", "Pampojila", "San Gabriel", "San Andres", "Nueva Vida", "San Jose", "Totolya", "Porvenir", "Tierra Santa", "San Gregorio", "San Felipe", "Quixaya", "San Juan", "Xejuyu", "Panimaquip", "San Martin", "Sector 97", "Santa Teresita", "El Naranjo"];

define('INVALID_VALUE', -1);

define('MODE_ARG', 'mode');
define('MODE_NONE', 0);
define('MODE_REGISTRY', 1);
define('MODE_TRIAGE', 2);
define('MODE_CONSULT', 3);

define('REDIRECT_COMMUNITIES', 1);
define('REDIRECT_PATIENTS', 2);
define('REDIRECT_PROFILE', 3);
define('REDIRECT_TRIAGE_INTAKE_LIST', 4);
define('REDIRECT_MEDICAL_CONSULT_LIST', 5);
define('REDIRECT_COMPLETED_CONSULT_LIST', 6);

define('TABLE_COMMUNITIES', 'communities');
define('COMMUNITIES_COLUMN_NAME', 'name');

define('TABLE_PATIENTS', 'patients');
define('PATIENTS_COLUMN_ID', 'id');
define('PATIENTS_COLUMN_NAME', 'name');
define('PATIENTS_COLUMN_COMMUNITY_NAME', 'community_name');
define('PATIENTS_COLUMN_SEX', 'sex');
define('PATIENTS_COLUMN_EXACT_DATE_OF_BIRTH_KNOWN', 'exact_date_of_birth_known');
define('PATIENTS_COLUMN_DATE_OF_BIRTH', 'date_of_birth');
define('PATIENTS_COLUMN_CONSULT_STATUS', 'consult_status');
define('PATIENTS_COLUMN_CONSULT_STATUS_DATETIME', 'consult_status_datetime');

define('TABLE_MESSAGES', 'messages');
define('MESSAGES_COLUMN_ID', 'id');
define('MESSAGES_COLUMN_PATIENT_ID', 'patient_id');
define('MESSAGES_COLUMN_STATUS', 'status');
define('MESSAGES_COLUMN_MESSAGE', 'message');
define('MESSAGES_COLUMN_SUBMITTER', 'submitter');
define('MESSAGES_COLUMN_DATETIME_CREATED', 'datetime_created');
define('MESSAGES_COLUMN_DATETIME_LAST_UPDATED', 'datetime_last_updated');

define('TABLE_CONSULTS', 'consults');
define('CONSULTS_COLUMN_ID', 'id');
define('CONSULTS_COLUMN_PATIENT_ID', 'patient_id');
define('CONSULTS_COLUMN_CHIEF_PHYSCIAN', 'chief_physician');
define('CONSULTS_COLUMN_SIGNING_PHYSICIAN', 'signing_physician');
define('CONSULTS_COLUMN_LOCATION', 'location');
define('CONSULTS_COLUMN_NOTES', 'notes');
define('CONSULTS_COLUMN_STATUS', 'status');
define('CONSULTS_COLUMN_DATETIME_STARTED', 'datetime_started');
define('CONSULTS_COLUMN_DATETIME_COMPLETED', 'datetime_completed');

define('CONSULT_STATUS_READY_FOR_TRIAGE_INTAKE', 1);
define('CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT', 2);


define('CONSULT_STATUS_NONE', 0);
define('CONSULT_STATUS_READY_FOR_TRIAGE_PENDING', 1);
define('CONSULT_STATUS_READY_FOR_TRIAGE_IN_PROGRESS', 2);
define('CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT_PENDING', 3);
define('CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT_IN_PROGRESS', 4);
define('CONSULT_STATUS_CONSULT_COMPLETED', 5);
define('CONSULT_STATUS_EDITABLE', 6);


define('COMMUNITY_CREATE_SUCCESS', 2);
define('COMMUNITY_CREATE_FAILURE', 1);
define('COMMUNITY_CREATE_ALREADY_EXISTS', 0);

define('PATIENT_CREATE_SUCCESS', 2);
define('PATIENT_CREATE_FAILURE', 1);
define('PATIENT_CREATE_ALREADY_EXISTS', 0);

define('DELETE_ARG', 'delete');
define('SAVE_ARG', 'save');
define('SAVE_NORMAL', 1);
define('SAVE_OVERWRITE', 2);

define('PATIENT_ID_ARG', 'patient_id');
define('COMMUNITY_NAME_ARG', 'community_name');
define('CONSULT_ID_ARG', 'consult_id');
define('CHIEF_COMPLAINT_ID_ARG', 'chief_complaint_id');
define('PRIMARY_CHIEF_COMPLAINTS_ARG', 'pcca');
define('SECONDARY_CHIEF_COMPLAINTS_ARG', 'scca');

define('BOOLEAN_UNKNOWN', 0);
define('BOOLEAN_FALSE', 1);
define('BOOLEAN_TRUE', 2);

define('SEX_UNKNOWN', 0);
define('SEX_MALE', 1);
define('SEX_FEMALE', 2);

define('TEMPERATURE_UNITS_CELSIUS', 1);
define('TEMPERATURE_UNITS_FAHRENHEIT', 2);

define('WEIGHT_UNITS_KILOGRAMS', 1);
define('WEIGHT_UNITS_POUNDS', 2);

define('HEIGHT_UNITS_CENTIMETERS', 1);
define('HEIGHT_UNITS_INCHES', 2);

define('STATUS_ACTIVE_UNKNOWN', 0);
define('STATUS_ACTIVE_YES', 1);
define('STATUS_ACTIVE_NO', 2);

define('SETTINGS_DEFAULT_CONSULT_LOCATION', 'default_consult_location');
define('SETTINGS_DEFAULT_CONSULT_MEDICAL_GROUP', 'default_consult_medical_group');
define('SETTINGS_DEFAULT_CONSULT_CHIEF_PHYSICIAN', 'default_consult_chief_physician');

define('INVALID_CHIEF_COMPLAINT', '255');
define('CHIEF_COMPLAINT_PRIMARY', 1);
define('CHIEF_COMPLAINT_SECONDARY', 2);

define("HPI_TYPE_ARG", "hpi_type");
define('HPI_TYPE_GENERAL', 1);
define('HPI_TYPE_PREGNANCY', 2);

define('SHOW_ARG', 'show');
define('SHOW_CHIEF_COMPLAINT', 1);
define('SHOW_HPI', 2);
define('SHOW_MEASUREMENTS_VITAL_SIGNS', 3);
define('SHOW_EXAMS', 4);
define('SHOW_DIAGNOSES', 5);
define('SHOW_TREATMENTS', 6);
define('SHOW_FOLLOWUP', 7);
define('SHOW_SIGN_AND_COMPLETE', 8);

define('FILTER_OPTION_NONE', 0);
define('FILTER_OPTION_DUE_ALL', 1);
define('FILTER_OPTION_PENDING', 2);
define('FILTER_OPTION_IN_PROGRESS', 3);



define('DEFAULT_CHIEF_COMPLAINT_PREGNANCY_VALUE', '17');

//To have different order depending on language, should move this array into the language files and re-order as necessary
//MAX KEY VALUE IS 255
const DEFAULT_CHIEF_COMPLAINT_ARRAY = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22"];

define('EXAMS_NORMAL_CHOICE', '0');
define('EXAMS_OTHER_CHOICE', '-1');

?>