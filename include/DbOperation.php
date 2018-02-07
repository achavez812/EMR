<?php

class DbOperation
{
    private $db;
    private $con;

    function __construct()
    {
        require_once '../include/Utilities.php';
        require_once '../include/Constants.php';
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

    public function hasConsultActiveMessages($consult_id) {
        $status_active = 1;
        $stmt = $this->con->prepare("SELECT id FROM messages WHERE consult_id = ? AND status = ?");
        $stmt->bind_param("ss", $consult_id, $status_active);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getConsultActiveMessages($consult_id) {
        $status_active = 1;
        $stmt = $this->con->prepare("SELECT * FROM messages WHERE consult_id = ? AND status = ? ORDER BY datetime_created DESC");
        $stmt->bind_param("ss", $consult_id, $status_active);
        $stmt->execute();
        $messages = $stmt->get_result();
        $stmt->close();
        return $messages;
    }

    public function hasPatientActiveMessages($patient_id) {
        $status_active = 1;
        $stmt = $this->con->prepare("SELECT id FROM messages WHERE patient_id = ? AND status = ?");
        $stmt->bind_param("ss", $patient_id, $status_active);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getPatientActiveMessages($patient_id) {
        $status_active = 1;
        $stmt = $this->con->prepare("SELECT * FROM messages WHERE patient_id = ? AND status = ? ORDER BY datetime_created DESC");
        $stmt->bind_param("ss", $patient_id, $status_active);
        $stmt->execute();
        $messages = $stmt->get_result();
        $stmt->close();
        return $messages;
    }

    public function getMessage($id) {
        $stmt = $this->con->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $message = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $message;
    }

    public function hasMessage($id) {
        $stmt = $this->con->prepare("SELECT id FROM messages WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function createNewMessage($message_id, $patient_id, $consult_id, $status, $message, $submitter, $datetime) {
        if($this->hasMessage($message_id)) {
            $this->updateMessage($message_id, $status, $message, $submitter, $datetime);
        } else {
            $stmt = $this->con->prepare("INSERT INTO messages(patient_id, consult_id, status, message, submitter, datetime_created, datetime_last_updated) values(?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $patient_id, $consult_id, $status, $message, $submitter, $datetime, $datetime);
            $result = $stmt->execute();
            $stmt->close();
        }
    }

    public function updateMessage($message_id, $status, $message, $submitter, $datetime) {
        $stmt = $this->con->prepare("UPDATE messages SET status = ?, message = ?, submitter = ?, datetime_last_updated = ? WHERE id = ?");
        $stmt->bind_param("sssss", $status, $message, $submitter, $datetime, $message_id);
        $result = $stmt->execute();
        $stmt->close();
    }

    public function deleteMessage($id) {
        $stmt = $this->con->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
    }

    public function validateEditKey($edit_key) {
        $stmt = $this->con->prepare("SELECT id FROM settings WHERE edit_key = ?");
        $stmt->bind_param("s", $edit_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getExistingMedicalGroups() {
        $stmt = $this->con->prepare("SELECT DISTINCT medical_group FROM consults WHERE medical_group IS NOT NULL ORDER BY medical_group");
        $stmt->execute();
        $medical_groups = $stmt->get_result();
        $stmt->close();
        return $medical_groups;
    }

    public function getExistingChiefPhysicians($medical_group) {
        $stmt = $this->con->prepare("SELECT DISTINCT chief_physician FROM consults WHERE medical_group = ? AND chief_physician IS NOT NULL ORDER BY chief_physician");
        $stmt->bind_param("s", $medical_group);
        $stmt->execute();
        $chief_physicians = $stmt->get_result();
        $stmt->close();
        return $chief_physicians;
    } 

    public function getExistingSigningPhysicians($medical_group) {
        $stmt = $this->con->prepare("SELECT DISTINCT signing_physician FROM consults WHERE medical_group = ? AND signing_physician IS NOT NULL ORDER BY signing_physician");
        $stmt->bind_param("s", $medical_group);
        $stmt->execute();
        $signing_physicians = $stmt->get_result();
        $stmt->close();
        return $signing_physicians;
    }

    public function updateConsult($consult_id, $medical_group, $chief_physician, $signing_physician, $location, $notes, $datetime_completed) {
        $stmt = $this->con->prepare("UPDATE consults SET medical_group = ?, chief_physician = ?, signing_physician = ?, location = ?, notes = ?, datetime_completed = ? WHERE id = ?");
        $stmt->bind_param("sssssss", $medical_group, $chief_physician, $signing_physician, $location, $notes, $datetime_completed, $consult_id);
        $result = $stmt->execute();
        $stmt->close();
    }

    public function updateConsultStatus($consult_id, $status) {
        $stmt = $this->con->prepare("UPDATE consults SET status = ? WHERE id = ?");
        $stmt->bind_param("ss", $status, $consult_id);
        $result = $stmt->execute();
        $stmt->close();
    }

    public function consultHasHPI($consult_id) {
        $stmt = $this->con->prepare("SELECT id FROM chief_complaints_history WHERE consult_id = ?");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        if($num_rows > 0) {
            return true;
        } else {
            $stmt = $this->con->prepare("SELECT id FROM hpi_pregnancy WHERE consult_id = ?");
            $stmt->bind_param("s", $consult_id);
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->num_rows;
            $stmt->close();
            return $num_rows > 0;
        }
    }

    public function hasHPI($chief_complaint_id, $is_pregnancy) {
        if($is_pregnancy == 2) {
            $stmt = $this->con->prepare("SELECT id FROM hpi_pregnancy WHERE chief_complaint_id = ?");
            $stmt->bind_param("s", $chief_complaint_id);
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->num_rows;
            $stmt->close();
            return $num_rows > 0;
        } else {
            $stmt = $this->con->prepare("SELECT id FROM chief_complaints_history WHERE chief_complaint_id = ?");
            $stmt->bind_param("s", $chief_complaint_id);
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->num_rows;
            $stmt->close();
            return $num_rows > 0;
        }
    }

    public function getPregnancyHPI($chief_complaint_id) {
        $stmt = $this->con->prepare("SELECT * FROM hpi_pregnancy WHERE chief_complaint_id = ?");
        $stmt->bind_param("s", $chief_complaint_id);
        $stmt->execute();
        $hpi = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $hpi;
    }

    public function getHPI($chief_complaint_id) {
        $stmt = $this->con->prepare("SELECT * FROM chief_complaints_history WHERE chief_complaint_id = ?");
        $stmt->bind_param("s", $chief_complaint_id);
        $stmt->execute();
        $chief_complaint_history = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $chief_complaint_history;
    }

    public function createPregnancyHPI($consult_id, $chief_complaint_id, $num_weeks_pregnant, $receiving_prenatal_care, $taking_prenatal_vitamins, $received_ultrasound, $num_live_births, $num_miscarriages, $dysuria_urgency_frequency, $abnormal_vaginal_discharge, $vaginal_bleeding, $previous_pregnancy_complications, $complications_notes, $notes) {
         if($this->hasHPI($chief_complaint_id, 2)) {
            //UPDATE
            $stmt = $this->con->prepare("UPDATE hpi_pregnancy SET num_weeks_pregnant = ?, receiving_prenatal_care = ?, taking_prenatal_vitamins = ?, received_ultrasound = ?, num_live_births = ?, num_miscarriages = ?, dysuria_urgency_frequency = ?, abnormal_vaginal_discharge = ?, vaginal_bleeding = ?, previous_pregnancy_complications = ?, complications_notes = ?, notes = ? WHERE chief_complaint_id = ?");
            $stmt->bind_param("sssssssssssss", $num_weeks_pregnant, $receiving_prenatal_care, $taking_prenatal_vitamins, $received_ultrasound, $num_live_births, $num_miscarriages, $dysuria_urgency_frequency, $abnormal_vaginal_discharge, $vaginal_bleeding, $previous_pregnancy_complications, $complications_notes, $notes, $chief_complaint_id);
            $result = $stmt->execute();
            $stmt->close();
        } else {
            //CREATE
            $stmt = $this->con->prepare("INSERT INTO hpi_pregnancy(consult_id, chief_complaint_id, num_weeks_pregnant, receiving_prenatal_care, taking_prenatal_vitamins, received_ultrasound, num_live_births, num_miscarriages, dysuria_urgency_frequency, abnormal_vaginal_discharge, vaginal_bleeding, previous_pregnancy_complications, complications_notes, notes) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssssss", $consult_id, $chief_complaint_id, $num_weeks_pregnant, $receiving_prenatal_care, $taking_prenatal_vitamins, $received_ultrasound, $num_live_births, $num_miscarriages, $dysuria_urgency_frequency, $abnormal_vaginal_discharge, $vaginal_bleeding, $previous_pregnancy_complications, $complications_notes, $notes);
            $result = $stmt->execute();
            $stmt->close();
        }

    } 

    public function createHPI($consult_id, $chief_complaint_id, $o_pain_how, $o_pain_cause, $p_pain_provocation, $p_pain_palliation, $q_pain_type, $r_pain_region_main, $r_pain_region_radiates, $s_pain_level, $t_pain_begin_time, $t_pain_before, $t_pain_current, $notes) {
        if($this->hasHPI($chief_complaint_id, 1)) {
            //UPDATE
            $stmt = $this->con->prepare("UPDATE chief_complaints_history SET o_pain_how = ?, o_pain_cause = ?, p_pain_provocation = ?, p_pain_palliation = ?, q_pain_type = ?, r_pain_region_main = ?, r_pain_region_radiates = ?, s_pain_level = ?, t_pain_begin_time = ?, t_pain_before = ?, t_pain_current = ?, notes = ? WHERE chief_complaint_id = ?");
            $stmt->bind_param("sssssssssssss", $o_pain_how, $o_pain_cause, $p_pain_provocation, $p_pain_palliation, $q_pain_type, $r_pain_region_main, $r_pain_region_radiates, $s_pain_level, $t_pain_begin_time, $t_pain_before, $t_pain_current, $notes, $chief_complaint_id);
            $result = $stmt->execute();
            $stmt->close();
        } else {
            //CREATE
            $stmt = $this->con->prepare("INSERT INTO chief_complaints_history(consult_id, chief_complaint_id, o_pain_how, o_pain_cause, p_pain_provocation, p_pain_palliation, q_pain_type, r_pain_region_main, r_pain_region_radiates, s_pain_level, t_pain_begin_time, t_pain_before, t_pain_current, notes) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssssss", $consult_id, $chief_complaint_id, $o_pain_how, $o_pain_cause, $p_pain_provocation, $p_pain_palliation, $q_pain_type, $r_pain_region_main, $r_pain_region_radiates, $s_pain_level, $t_pain_begin_time, $t_pain_before, $t_pain_current, $notes);
            $result = $stmt->execute();
            $stmt->close();
        }
    }

    public function deleteHPI($chief_complaint_id, $is_pregnancy) {
        if($is_pregnancy == 2) {
            $stmt = $this->con->prepare("DELETE FROM hpi_pregnancy WHERE chief_complaint_id = ?");
            $stmt->bind_param("s", $chief_complaint_id);
            $result = $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $this->con->prepare("DELETE FROM chief_complaints_history WHERE chief_complaint_id = ?");
            $stmt->bind_param("s", $chief_complaint_id);
            $result = $stmt->execute();
            $stmt->close();
        }
    }

    public function hasChiefComplaint($consult_id) {
        $stmt = $this->con->prepare("SELECT id FROM chief_complaints WHERE consult_id = ?");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function hasExistingChiefComplaint($consult_id, $type_is_custom, $type, $is_primary) {
        $stmt = $this->con->prepare("SELECT id FROM chief_complaints WHERE consult_id = ? AND type_is_custom = ? AND type = ? and is_primary = ?");
        $stmt->bind_param("ssss", $consult_id, $type_is_custom, $type, $is_primary);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function hasPrimaryChiefComplaint($consult_id) {
        $true_value = 2;
        $stmt = $this->con->prepare("SELECT id FROM chief_complaints WHERE consult_id = ? AND is_primary = ?");
        $stmt->bind_param("ss", $consult_id, $true_value);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function hasSecondaryChiefComplaint($consult_id) {
        $false_value = 1;
        $stmt = $this->con->prepare("SELECT id FROM chief_complaints WHERE consult_id = ? AND is_primary = ?");
        $stmt->bind_param("ss", $consult_id, $false_value);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getPrimaryChiefComplaints($consult_id) {
        $true_value = 2;
        $stmt = $this->con->prepare("SELECT * FROM chief_complaints WHERE consult_id = ? AND is_primary = ? ORDER BY type_is_custom ASC, type ASC");
        $stmt->bind_param("ss", $consult_id, $true_value);
        $stmt->execute();
        $primary_chief_complaints = $stmt->get_result();
        $stmt->close();
        return $primary_chief_complaints;
    }

    public function getSecondaryChiefComplaints($consult_id) {
        $false_value = 1;
        $stmt = $this->con->prepare("SELECT * FROM chief_complaints WHERE consult_id = ? AND is_primary = ? ORDER BY type_is_custom ASC, type ASC");
        $stmt->bind_param("ss", $consult_id, $false_value);
        $stmt->execute();
        $secondary_chief_complaints = $stmt->get_result();
        $stmt->close();
        return $secondary_chief_complaints;
    }

    public function createChiefComplaint($consult_id, $type_is_custom, $type, $is_primary) {
        if(!$this->hasExistingChiefComplaint($consult_id, $type_is_custom, $type, $is_primary)) {
            $stmt = $this->con->prepare("INSERT INTO chief_complaints(consult_id, type_is_custom, type, is_primary) values(?, ?, ?, ?)");
            $stmt->bind_param("ssss", $consult_id, $type_is_custom, $type, $is_primary);
            $result = $stmt->execute();
            $stmt->close();
        }
    }

    public function deleteChiefComplaint($id) {
        $stmt = $this->con->prepare("DELETE FROM chief_complaints WHERE id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
    }


    public function startNewConsult($patient_id, $current_datetime) {
        if ($this->hasActiveConsult($patient_id)) {
            return $this->getActiveConsult($patient_id)["id"];
        } else {
            $stmt = $this->con->prepare("INSERT INTO consults(patient_id, datetime_started) values(?, ?)");
            $stmt->bind_param("ss", $patient_id, $current_datetime);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return $this->getActiveConsult($patient_id)["id"];
            } else {
                return -1;
            }
        }
    }

    public function getActiveConsult($patient_id) {
        $stmt = $this->con->prepare("SELECT * FROM consults WHERE patient_id = ? AND datetime_completed IS NULL");
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $consult = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $consult;
    }

    public function hasActiveConsult($patient_id) {
        $stmt = $this->con->prepare("SELECT id FROM consults WHERE patient_id = ? AND datetime_completed IS NULL");
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getConsults($patient_id) {
        $stmt = $this->con->prepare("SELECT * FROM consults WHERE patient_id = ? ORDER BY datetime_started DESC");
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $consults = $stmt->get_result();
        $stmt->close();
        return $consults;
    }

    public function getConsult($id) {
        $stmt = $this->con->prepare("SELECT * FROM consults WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $consult = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $consult;
    }

    public function getMeasurements($consult_id) {
        $stmt = $this->con->prepare("SELECT * FROM measurements WHERE consult_id = ?");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $measurements = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $measurements;
    }


    public function hasMeasurements($consult_id) {
        $stmt = $this->con->prepare("SELECT id FROM measurements WHERE consult_id = ?");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function createNewMeasurements($consult_id, $is_pregnant, $date_last_menstruation, $temperature_units, $temperature_value, $blood_pressure_systolic, $blood_pressure_diastolic, $pulse_rate, $blood_oxygen_saturation, $respiration_rate, $weight_units, $weight_value, $height_units, $height_value, $waist_circumference_units, $waist_circumference, $notes) {
        if ($this->hasMeasurements($consult_id)) {
            return $this->updateMeasurements($consult_id, $is_pregnant, $date_last_menstruation, $temperature_units, $temperature_value, $blood_pressure_systolic, $blood_pressure_diastolic, $pulse_rate, $blood_oxygen_saturation, $respiration_rate, $weight_units, $weight_value, $height_units, $height_value, $waist_circumference_units, $waist_circumference, $notes);
        } else {
            $stmt = $this->con->prepare("INSERT INTO measurements(consult_id, is_pregnant, date_last_menstruation, temperature_units, temperature_value, blood_pressure_systolic, blood_pressure_diastolic, pulse_rate, blood_oxygen_saturation, respiration_rate, weight_units, weight_value, height_units, height_value, waist_circumference_units, waist_circumference_value, notes) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssssssss", $consult_id, $is_pregnant, $date_last_menstruation, $temperature_units, $temperature_value, $blood_pressure_systolic, $blood_pressure_diastolic, $pulse_rate, $blood_oxygen_saturation, $respiration_rate, $weight_units, $weight_value, $height_units, $height_value, $waist_circumference_units, $waist_circumference, $notes);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return $consult_id;
            } else {
                return -1;
            }
        }
    }

    public function updateMeasurements($consult_id, $is_pregnant, $date_last_menstruation, $temperature_units, $temperature_value, $blood_pressure_systolic, $blood_pressure_diastolic, $pulse_rate, $blood_oxygen_saturation, $respiration_rate, $weight_units, $weight_value, $height_units, $height_value, $waist_circumference_units, $waist_circumference, $notes) {

        $stmt = $this->con->prepare("UPDATE measurements SET is_pregnant = ?, date_last_menstruation = ?, temperature_units = ?, temperature_value = ?, blood_pressure_systolic = ?, blood_pressure_diastolic = ?, pulse_rate = ?, blood_oxygen_saturation = ?, respiration_rate = ?, weight_units = ?, weight_value = ?, height_units = ?, height_value = ?, waist_circumference_units = ?, waist_circumference_value = ?, notes = ? WHERE consult_id = ?");
        $stmt->bind_param("sssssssssssssssss", $is_pregnant, $date_last_menstruation, $temperature_units, $temperature_value, $blood_pressure_systolic, $blood_pressure_diastolic, $pulse_rate, $blood_oxygen_saturation, $respiration_rate, $weight_units, $weight_value, $height_units, $height_value, $waist_circumference_units, $waist_circumference, $notes, $consult_id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return $consult_id;
        } else {
            return -2;
        }
    }



    public function getCustomExams($consult_id, $type, $arg1, $arg2, $arg3, $arg4, $total) {
        $stmt = "";
        if($arg1 == NULL) {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 >= ? AND information IS NOT NULL ORDER BY arg1 ASC");
            $stmt->bind_param("sss", $consult_id, $type, $total);
        } else if ($arg2 == NULL) {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 >= ? AND information IS NOT NULL ORDER BY arg2 ASC");
            $stmt->bind_param("ssss", $consult_id, $type, $arg1, $total);
        } else if ($arg3 == NULL) {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 >= ? AND information IS NOT NULL ORDER BY arg3 ASC");
            $stmt->bind_param("sssss", $consult_id, $type, $arg1, $arg2, $total);
        } else if ($arg4 == NULL) {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 >= ? AND information IS NOT NULL ORDER BY arg4 ASC");
            $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $arg3, $total);
        } else {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ? AND information IS NOT NULL");
            $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $arg3, $arg4);
        }

        $stmt->execute();
        $custom_exams = $stmt->get_result();
        $stmt->close();
        return $custom_exams;
    }

    public function hasSpecificExam($consult_id, $type, $arg1, $arg2, $arg3, $arg4, $index) {
        $stmt = "";
        if($arg1 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 is NULL");
            $stmt->bind_param("ssss", $consult_id, $type, $index);
        } else if ($arg2 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 is NULL");
            $stmt->bind_param("sssss", $consult_id, $type, $arg1, $index);
        } else if ($arg3 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 is NULL");
            $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $index);
        } else if ($arg4 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ?");
            $stmt->bind_param("sssssss", $consult_id, $type, $arg1, $arg2, $arg3, $index);
        } else {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ?");
            $stmt->bind_param("sssssss", $consult_id, $type, $arg1, $arg2, $arg3, $arg4);
        }
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getExam($consult_id, $type, $arg1, $arg2, $arg3, $arg4, $index) {
        $stmt = "";
        if($arg1 == NULL) {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 is NULL");
            $stmt->bind_param("sss", $consult_id, $type, $index);
        } else if ($arg2 == NULL) {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 is NULL");
            $stmt->bind_param("ssss", $consult_id, $type, $arg1, $index);
        } else if ($arg3 == NULL) {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 is NULL");
            $stmt->bind_param("sssss", $consult_id, $type, $arg1, $arg2, $index);
        } else if ($arg4 == NULL) {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ?");
            $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $arg3, $arg4);
        } else {
            $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ?");
            $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $arg3, $arg4);
        }
        $stmt->execute();
        $exam = $stmt->get_result()->fetch_assoc();        
        $stmt->close();
        return $exam;
    }

    public function examExists($exam_id) {
        $stmt = $this->con->prepare("SELECT id FROM exams WHERE id = ?");
        $stmt->bind_param("s", $exam_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function hasExams($consult_id) {
        $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ?");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function hasExam($consult_id, $is_normal, $type, $arg1, $arg2, $arg3, $arg4, $index) {
        $stmt = "";
        if($is_normal == 1) { 
            if($type == NULL) {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ?");
                $stmt->bind_param("ss", $consult_id, $index);
            } else if($arg1 == NULL) {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ?");
                $stmt->bind_param("sss", $consult_id, $type, $index);
            } else if ($arg2 == NULL) {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ?");
                $stmt->bind_param("ssss", $consult_id, $type, $arg1, $index);
            } else if ($arg3 == NULL) {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ?");
                $stmt->bind_param("sssss", $consult_id, $type, $arg1, $arg2, $index);
            } else if ($arg4 == NULL) {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ?");
                $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $arg3, $index);
            } else {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ?");
                $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $arg3, $arg4);
            }
        } else {
            if ($arg2 == NULL) {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND is_normal = ? AND arg2 is NULL");
                $stmt->bind_param("ssss", $consult_id, $type, $arg1, $is_normal);
            } else if ($arg3 == NULL) {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND is_normal = ? AND arg3 is NULL");
                $stmt->bind_param("sssss", $consult_id, $type, $arg1, $arg2, $is_normal);
            } else if ($arg4 == NULL) {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND is_normal = ? AND arg4 is NULL");
                $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $arg3, $is_normal);
            } else {
                $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ? AND is_normal = ?");
                $stmt->bind_param("sssssss", $consult_id, $type, $arg1, $arg2, $arg3, $arg4, $is_normal);
            }
        }
        
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getNormalExamId($consult_id, $type, $arg1, $arg2, $arg3, $arg4) {
        $is_normal = 2;
        $stmt = "";
        if ($arg2 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND is_normal = ? AND arg2 is NULL");
            $stmt->bind_param("ssss", $consult_id, $type, $arg1, $is_normal);
        } else if ($arg3 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND is_normal = ? AND arg3 is NULL");
            $stmt->bind_param("sssss", $consult_id, $type, $arg1, $arg2, $is_normal);
        } else if ($arg4 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND is_normal = ? AND arg4 is NULL");
            $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $arg3, $is_normal);
        } else {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ? AND is_normal = ?");
            $stmt->bind_param("sssssss", $consult_id, $type, $arg1, $arg2, $arg3, $arg4, $is_normal);
        }
        $stmt->execute();
        $exam = $stmt->get_result()->fetch_assoc();        
        $stmt->close();
        return $exam['id'];
    }

    public function hasNormalExam($consult_id, $type, $arg1, $arg2, $arg3, $arg4, $index) {
        $stmt = "";
        $is_normal = 2;
        if ($arg1 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 is NULL AND is_normal = ? ");
            $stmt->bind_param("ssss", $consult_id, $type, $index, $is_normal);
        } else if ($arg2 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 is NULL AND is_normal = ? ");
            $stmt->bind_param("sssss", $consult_id, $type, $arg1, $index, $is_normal);
        } else if ($arg3 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 IS NULL AND is_normal = ?");
            $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $index, $is_normal);
        } else {
            return FALSE;
        } 

        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function consultHasAbnormalExam($consult_id) {
        $is_normal = 1;
        $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND is_normal = ? ");
        $stmt->bind_param("ss", $consult_id, $is_normal);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getConsultAbnormalExams($consult_id) {
        $is_normal = 1;
        $stmt = $this->con->prepare("SELECT * FROM exams WHERE consult_id = ? AND is_normal = ? ");
        $stmt->bind_param("ss", $consult_id, $is_normal);
        $stmt->execute();
        $exams = $stmt->get_result();
        $stmt->close();
        return $exams;
    }

    public function hasAbnormalExam($consult_id, $type, $arg1, $arg2, $arg3, $arg4, $index) {
        $stmt = "";
        $is_normal = 1;
        if($type == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND is_normal = ? ");
            $stmt->bind_param("sss", $consult_id, $index, $is_normal);
        } else if ($arg1 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND is_normal = ? ");
            $stmt->bind_param("ssss", $consult_id, $type, $index, $is_normal);
        } else if ($arg2 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND is_normal = ? ");
            $stmt->bind_param("sssss", $consult_id, $type, $arg1, $index, $is_normal);
        } else if ($arg3 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND is_normal = ?");
            $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $index, $is_normal);
        } else if ($arg4 == NULL) {
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ? AND is_normal = ?");
            $stmt->bind_param("sssssss", $consult_id, $type, $arg1, $arg2, $arg3, $index, $is_normal);
        } else {
            return FALSE;
        }

        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function createNewExam($consult_id, $exam_id, $is_normal, $type, $arg1, $arg2, $arg3, $arg4, $information, $options, $other, $notes) {
        $this->removeNecessaryExams($consult_id, $is_normal, $type, $arg1, $arg2, $arg3, $arg4);
        if ($exam_id != NULL && $this->examExists($exam_id)) {
            $stmt = $this->con->prepare("UPDATE exams SET is_normal = ?, information = ?, options = ?, other = ?, notes = ? WHERE id = ?");
            $stmt->bind_param("ssssss", $is_normal, $information, $options, $other, $notes, $exam_id);
            $result = $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $this->con->prepare("INSERT INTO exams(consult_id, is_normal, type, arg1, arg2, arg3, arg4, information, options, other, notes) value (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssss", $consult_id, $is_normal, $type, $arg1, $arg2, $arg3, $arg4, $information, $options, $other, $notes);
            $result = $stmt->execute();
            $stmt->close();     
        }
    }

    public function removeNecessaryExams($consult_id, $is_normal, $type, $arg1, $arg2, $arg3, $arg4) {
        if($is_normal == 2) {
            //Delete all abnormal at same level or lower
            $abnormal = 1;
            if(!$arg2) {
                $stmt = $this->con->prepare("DELETE FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND is_normal = ?");
                $stmt->bind_param("ssss", $consult_id, $type, $arg1, $abnormal);
                $result = $stmt->execute();
                $stmt->close();
            } else if (!$arg3) {
                $stmt = $this->con->prepare("DELETE FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND is_normal = ?");
                $stmt->bind_param("sssss", $consult_id, $type, $arg1, $arg2, $abnormal);
                $result = $stmt->execute();
                $stmt->close();
            } else if (!$arg4) {
                $stmt = $this->con->prepare("DELETE FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND is_normal = ?");
                $stmt->bind_param("ssssss", $consult_id, $type, $arg1, $arg2, $arg3, $abnormal);
                $result = $stmt->execute();
                $stmt->close();
            } else {
                $stmt = $this->con->prepare("DELETE FROM exams WHERE consult_id = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ? AND is_normal = ?");
                $stmt->bind_param("sssssss", $consult_id, $type, $arg1, $arg2, $arg3, $arg4, $abnormal);
                $result = $stmt->execute();
                $stmt->close();
            }
        } else {
            //Delete normal at same level or above
            $normal = 2;
            if($arg1) {
                $stmt = $this->con->prepare("DELETE FROM exams WHERE consult_id = ? AND is_normal = ? AND type = ? AND arg1 = ? AND arg2 is NULL");
                $stmt->bind_param("ssss", $consult_id, $normal, $type, $arg1);
                $result = $stmt->execute();
                $stmt->close();

                if($arg2) {
                    $stmt = $this->con->prepare("DELETE FROM exams WHERE consult_id = ? AND is_normal = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 is NULL");
                    $stmt->bind_param("sssss", $consult_id, $normal, $type, $arg1, $arg2);
                    $result = $stmt->execute();
                    $stmt->close();

                    if($arg3) {
                        $stmt = $this->con->prepare("DELETE FROM exams WHERE consult_id = ? AND is_normal = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 is NULL");
                        $stmt->bind_param("ssssss", $consult_id, $normal, $type, $arg1, $arg2, $arg3);
                        $result = $stmt->execute();
                        $stmt->close();

                        if($arg4) {
                            $stmt = $this->con->prepare("DELETE FROM exams WHERE consult_id = ? AND is_normal = ? AND type = ? AND arg1 = ? AND arg2 = ? AND arg3 = ? AND arg4 = ?");
                            $stmt->bind_param("sssssss", $consult_id, $normal, $type, $arg1, $arg2, $arg3, $arg4);
                            $result = $stmt->execute();
                            $stmt->close();
                        }
                    }
                }
            } 
        }
    }

    public function deleteExam($exam_id) {
        $stmt = $this->con->prepare("DELETE FROM exams WHERE id = ?");
        $stmt->bind_param("s", $exam_id);
        $result = $stmt->execute();
        $stmt->close();
    }

   public function hasConsultDiagnosis($consult_id) {
        $stmt = $this->con->prepare("SELECT id FROM diagnoses_illnesses_conditions WHERE consult_id = ?");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function diagnosisCategoryHasAbnormalExam($consult_id, $index) {
        $stmt;
        if($index == 0) {
            $type = 0;
            $is_normal = 1;
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND is_normal = ?");
            $stmt->bind_param("sss", $consult_id, $type, $is_normal);
        } else {
            $type = 1;
            $is_normal = 1;
            $fixed_index = $index - 1;
            $stmt = $this->con->prepare("SELECT id FROM exams WHERE consult_id = ? AND type = ? AND is_normal = ? AND arg1 = ?");
            $stmt->bind_param("ssss", $consult_id, $type, $is_normal, $fixed_index);
        }
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function hasDiagnosis($consult_id, $category, $type) {
        $stmt;
        if($type === 0 || $type !== NULL) {
            $stmt = $this->con->prepare("SELECT id FROM diagnoses_illnesses_conditions WHERE consult_id = ? AND category = ? AND type = ?");
            $stmt->bind_param("sss", $consult_id, $category, $type);
        } else {
            $stmt = $this->con->prepare("SELECT id FROM diagnoses_illnesses_conditions WHERE consult_id = ? AND category = ?");
            $stmt->bind_param("ss", $consult_id, $category);
        }
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getDiagnosis($consult_id, $category, $type) {
        if($type === NULL) {
            return NULL;
        } else {
            $stmt = $this->con->prepare("SELECT * FROM diagnoses_illnesses_conditions WHERE consult_id = ? AND category = ? AND type = ?");
            $stmt->bind_param("sss", $consult_id, $category, $type);
            $stmt->execute();
            $diagnosis = $stmt->get_result()->fetch_assoc();        
            $stmt->close();
            return $diagnosis;
        }
    }

    public function getDiagnoses($consult_id) {
        $stmt = $this->con->prepare("SELECT * FROM diagnoses_illnesses_conditions WHERE consult_id = ? ORDER BY other, category, type");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $diagnoses = $stmt->get_result();        
        $stmt->close();
        return $diagnoses;
    }

    public function getCustomDiagnoses($consult_id, $category) {
        $stmt = $this->con->prepare("SELECT * FROM diagnoses_illnesses_conditions WHERE consult_id = ? AND category = ? AND other IS NOT NULL");
        $stmt->bind_param("ss", $consult_id, $category);
        $stmt->execute();
        $diagnoses = $stmt->get_result();        
        $stmt->close();
        return $diagnoses;
    }

    public function getDiagnosisById($id) {
        $stmt = $this->con->prepare("SELECT * FROM diagnoses_illnesses_conditions WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $diagnosis = $stmt->get_result()->fetch_assoc();        
        $stmt->close();
        return $diagnosis;
    }

    public function createNewDiagnosis($consult_id, $patient_id, $diagnosis_id, $is_chronic, $category, $type, $other, $notes, $current_datetime, $current_date) {
        if($diagnosis_id != NULL) {
            $this->updateDiagnosis($diagnosis_id, $is_chronic, $other, $notes, $current_datetime);
        } else {
            $stmt = $this->con->prepare("INSERT INTO diagnoses_illnesses_conditions(consult_id, patient_id, is_chronic, category, type, other, notes, start_date, datetime_created, datetime_last_updated) value (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $consult_id, $patient_id, $is_chronic, $category, $type, $other, $notes, $current_date, $current_datetime, $current_datetime);
            $result = $stmt->execute();
            $stmt->close();
            if($result) {
                return $consult_id;
            } else {
                return -1;
            }
        }
    }

    public function updateDiagnosis($id, $is_chronic, $other, $notes, $current_datetime) {
        $stmt = $this->con->prepare("UPDATE diagnoses_illnesses_conditions SET is_chronic = ?, other = ?, notes = ?, datetime_last_updated = ? WHERE id = ?");
        $stmt->bind_param("sssss", $is_chronic, $other, $notes, $current_datetime, $id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return $id;
        } else {
            return -2;
        }
    }

    public function deleteDiagnosis($id) {
        //DELETE DIAGNOSIS
        $stmt = $this->con->prepare("DELETE FROM diagnoses_illnesses_conditions WHERE id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();

        //DELETE TREATMENTS ASSOCIATED WITH THIS DIAGNOSIS
        $stmt = $this->con->prepare("DELETE FROM treatments WHERE diagnosis_id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
    }

    public function hasConsultTreatments($consult_id) {
        $stmt = $this->con->prepare("SELECT id FROM treatments WHERE consult_id = ?");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function diagnosisHasTreatment($consult_id, $diagnosis_id) {
        $stmt;
        if($diagnosis_id !== 0) {
            //TREATMENTS ATTACHED TO A DIAGNOSIS
            $stmt = $this->con->prepare("SELECT id FROM treatments WHERE diagnosis_id = ?");
            $stmt->bind_param("s", $diagnosis_id);
        } else {
            //GENERAL TREATMENTS NOT ATTACHED TO A DIAGNOSIS
            $stmt = $this->con->prepare("SELECT id FROM treatments WHERE consult_id = ? AND diagnosis_id IS NULL");
            $stmt->bind_param("s", $consult_id);
        }
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function hasTreatment($consult_id, $diagnosis_id, $type) {
        $stmt;
        if($diagnosis_id !== 0) {
            //TREATMENTS ATTACHED TO A DIAGNOSIS
            $stmt = $this->con->prepare("SELECT id FROM treatments WHERE diagnosis_id = ? AND type = ? AND other IS NULL");
            $stmt->bind_param("ss", $diagnosis_id, $type);
        } else {
            //GENERAL TREATMENTS NOT ATTACHED TO A DIAGNOSIS
            $stmt = $this->con->prepare("SELECT id FROM treatments WHERE consult_id = ? AND type = ? AND diagnosis_id IS NULL AND other IS NULL");
            $stmt->bind_param("ss", $consult_id, $type);
        }
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getTreatmentByInformation($consult_id, $diagnosis_id, $type) {
        $stmt;
        if($diagnosis_id !== 0) {
            //TREATMENTS ATTACHED TO A DIAGNOSIS
            $stmt = $this->con->prepare("SELECT * FROM treatments WHERE diagnosis_id = ? AND type = ? AND other IS NULL");
            $stmt->bind_param("ss", $diagnosis_id, $type);
        } else {
            //GENERAL TREATMENTS NOT ATTACHED TO A DIAGNOSIS
            $stmt = $this->con->prepare("SELECT * FROM treatments WHERE consult_id = ? AND type = ? AND diagnosis_id IS NULL AND other IS NULL");
            $stmt->bind_param("ss", $consult_id, $type);
        }
        $stmt->execute();
        $treatment = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $treatment;
    }

    public function getTreatment($id) {
        $stmt = $this->con->prepare("SELECT * FROM treatments WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $treatment = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $treatment;
    }

    public function getTreatments($consult_id) {
        $stmt = $this->con->prepare("SELECT * FROM treatments WHERE consult_id = ? ORDER BY other, type");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $treatments = $stmt->get_result();        
        $stmt->close();
        return $treatments;
    }

    public function getCustomTreatments($consult_id, $diagnosis_id) {
        if($diagnosis_id == NULL) {
            $stmt = $this->con->prepare("SELECT * FROM treatments WHERE consult_id = ? AND diagnosis_id IS NULL AND other IS NOT NULL");
            $stmt->bind_param("s", $consult_id);
            $stmt->execute();
            $treatments = $stmt->get_result();        
            $stmt->close();
            return $treatments;
        } else {
            $stmt = $this->con->prepare("SELECT * FROM treatments WHERE consult_id = ? AND diagnosis_id = ? AND other IS NOT NULL");
            $stmt->bind_param("ss", $consult_id, $diagnosis_id);
            $stmt->execute();
            $treatments = $stmt->get_result();        
            $stmt->close();
            return $treatments;
        }
    }

    public function hasTreatmentWithId($id) {
        $stmt = $this->con->prepare("SELECT id FROM treatments WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function createNewTreatment($consult_id, $treatment_id, $diagnosis_id, $type, $other, $strength, $strength_units, $strength_units_other, $conc_part_one, $conc_part_one_units, $conc_part_one_units_other, $conc_part_two, $conc_part_two_units, $conc_part_two_units_other, $quantity, $quantity_units, $quantity_units_other, $route, $route_other, $prn, $dosage, $dosage_units, $dosage_units_other, $frequency, $frequency_other, $duration, $duration_units, $duration_units_other, $notes) {
        if ($this->hasTreatmentWithId($treatment_id)) {
            return $this->updateTreatment($treatment_id, $other, $strength, $strength_units, $strength_units_other, $conc_part_one, $conc_part_one_units, $conc_part_one_units_other, $conc_part_two, $conc_part_two_units, $conc_part_two_units_other, $quantity, $quantity_units, $quantity_units_other, $route, $route_other, $prn, $dosage, $dosage_units, $dosage_units_other, $frequency, $frequency_other, $duration, $duration_units, $duration_units_other, $notes);
        } else {
            $stmt = $this->con->prepare("INSERT INTO treatments(consult_id, diagnosis_id, type, other, strength, strength_units, strength_units_other, conc_part_one, conc_part_one_units, conc_part_one_units_other, conc_part_two, conc_part_two_units, conc_part_two_units_other, quantity, quantity_units, quantity_units_other, route, route_other, prn, dosage, dosage_units, dosage_units_other, frequency, frequency_other, duration, duration_units, duration_units_other, notes) value(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssssssssssssssssssss", $consult_id, $diagnosis_id, $type, $other, $strength, $strength_units, $strength_units_other, $conc_part_one, $conc_part_one_units, $conc_part_one_units_other, $conc_part_two, $conc_part_two_units, $conc_part_two_units_other, $quantity, $quantity_units, $quantity_units_other, $route, $route_other, $prn, $dosage, $dosage_units, $dosage_units_other, $frequency, $frequency_other, $duration, $duration_units, $duration_units_other, $notes);
            $result = $stmt->execute();
            $stmt->close();
            if($result) {
                return $consult_id;
            } else {
                return -1;
            }
        }
    }

    public function updateTreatment($treatment_id, $other, $strength, $strength_units, $strength_units_other, $conc_part_one, $conc_part_one_units, $conc_part_one_units_other, $conc_part_two, $conc_part_two_units, $conc_part_two_units_other, $quantity, $quantity_units, $quantity_units_other, $route, $route_other, $prn, $dosage, $dosage_units, $dosage_units_other, $frequency, $frequency_other, $duration, $duration_units, $duration_units_other, $notes) {
        $stmt = $this->con->prepare("UPDATE treatments SET other = ?, strength = ?, strength_units = ?, strength_units_other = ?, conc_part_one = ?, conc_part_one_units = ?, conc_part_one_units_other = ?, conc_part_two = ?, conc_part_two_units = ?, conc_part_two_units_other = ?, quantity = ?, quantity_units = ?, quantity_units_other = ?, route = ?, route_other = ?, prn = ?, dosage = ?, dosage_units = ?, dosage_units_other = ?, frequency = ?, frequency_other = ?, duration = ?, duration_units = ?, duration_units_other = ?, notes = ? WHERE id = ?");
        $stmt->bind_param("ssssssssssssssssssssssssss", $other, $strength, $strength_units, $strength_units_other, $conc_part_one, $conc_part_one_units, $conc_part_one_units_other, $conc_part_two, $conc_part_two_units, $conc_part_two_units_other, $quantity, $quantity_units, $quantity_units_other, $route, $route_other, $prn, $dosage, $dosage_units, $dosage_units_other, $frequency, $frequency_other, $duration, $duration_units, $duration_units_other, $notes, $treatment_id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return $treatment_id;
        } else {
            return -2;
        }
    }

    public function deleteTreatment($id) {
        $stmt = $this->con->prepare("DELETE FROM treatments WHERE id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
    }

    public function createNewFollowup($consult_id, $is_needed, $is_type_custom, $type, $is_reason_custom, $reason, $notes) {
        if($this->hasExistingFollowup($consult_id)) {
            return $this->updateExistingFollowup($consult_id, $is_needed, $is_type_custom, $type, $is_reason_custom, $reason, $notes);
        } else {
            $stmt = $this->con->prepare("INSERT INTO followups(consult_id, is_needed, is_type_custom, type, is_reason_custom, reason, notes) value(?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $consult_id, $is_needed, $is_type_custom, $type, $is_reason_custom, $reason, $notes);
            $result = $stmt->execute();
            $stmt->close();
            if($result) {
                return $consult_id;
            } else {
                return -1;
            }
        } 
    }

    public function updateExistingFollowup($consult_id, $is_needed, $is_type_custom, $type, $is_reason_custom, $reason, $notes) {
        $stmt = $this->con->prepare("UPDATE followups SET is_needed = ?, is_type_custom = ?, type = ?, is_reason_custom = ?, reason = ?, notes = ? WHERE consult_id = ?");
        $stmt->bind_param("sssssss", $is_needed, $is_type_custom, $type, $is_reason_custom, $reason, $notes, $consult_id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return $consult_id;
        } else {
            return -2;
        }
    }

    public function hasExistingFollowup($consult_id) {
        $stmt = $this->con->prepare("SELECT id FROM followups WHERE consult_id = ?");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0; 
    }

    public function getFollowup($consult_id) {
        $stmt = $this->con->prepare("SELECT * FROM followups WHERE consult_id = ?");
        $stmt->bind_param("s", $consult_id);
        $stmt->execute();
        $followup = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $followup;
    }

    public function createNewHistoryAllergy($patient_id, $allergy_id, $name, $notes, $date) {
        if ($this->hasExistingHistoryAllergy($allergy_id)) {
            return $this->updateHistoryAllergy($allergy_id, $name, $notes, $date);
        } else {
            if($name) {
                $stmt = $this->con->prepare("DELETE FROM history_allergies WHERE patient_id = ? AND name IS NULL");
                $stmt->bind_param("s", $patient_id);
                $result = $stmt->execute();
                $stmt->close();
            }
            $stmt = $this->con->prepare("INSERT INTO history_allergies(patient_id, name, notes, datetime_created, datetime_last_updated) values(?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $patient_id, $name, $notes, $date, $date);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return $patient_id;
            } else {
                return -1;
            }
        }
    }

    public function updateHistoryAllergy($allergy_id, $name, $notes, $date) {
        $stmt = $this->con->prepare("UPDATE history_allergies SET name = ?, notes = ?, datetime_last_updated = ? WHERE id = ?");
        $stmt->bind_param("ssss", $name, $notes, $date, $allergy_id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return $allergy_id;
        } else {
            return -2;
        }
    }

    public function hasExistingHistoryAllergies($patient_id) {
        $stmt = $this->con->prepare("SELECT id FROM history_allergies WHERE patient_id = ?");
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function hasExistingHistoryAllergy($id) {
        $stmt = $this->con->prepare("SELECT id FROM history_allergies WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getHistoryAllergies($patient_id) {
        $stmt = $this->con->prepare("SELECT * FROM history_allergies WHERE patient_id = ? ORDER BY datetime_created DESC");
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $allergies = $stmt->get_result();
        $stmt->close();
        return $allergies;
    }

    public function getHistoryAllergy($id) {
        $stmt = $this->con->prepare("SELECT * FROM history_allergies WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $allergy = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $allergy;
    }

    public function deleteHistoryAllergy($id) {
        $stmt = $this->con->prepare("DELETE FROM history_allergies WHERE id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
    }

      public function createNewHistoryIllness($patient_id, $illness_id, $is_chronic, $type, $other, $start_date, $end_date, $notes, $datetime) {
        if ($this->hasExistingHistoryIllness($illness_id)) {
            return $this->updateHistoryIllness($illness_id, $is_chronic, $type, $other, $start_date, $end_date, $notes, $datetime);
        } else {
            $stmt = $this->con->prepare("INSERT INTO diagnoses_illnesses_conditions(patient_id, is_chronic, type, other, start_date, end_date, notes, datetime_created, datetime_last_updated) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $patient_id, $is_chronic, $type, $other, $start_date, $end_date, $notes, $datetime, $datetime);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return $patient_id;
            } else {
                return -1;
            }
        }
    }

    public function updateHistoryIllness($illness_id, $is_chronic, $type, $other, $start_date, $end_date, $notes, $datetime) {
        $stmt = $this->con->prepare("UPDATE diagnoses_illnesses_conditions SET is_chronic = ?, type = ?, other = ?, start_date = ?, end_date = ?, notes = ?, datetime_last_updated = ? WHERE id = ?");
        $stmt->bind_param("ssssssss", $is_chronic, $type, $other, $start_date, $end_date, $notes, $datetime, $illness_id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return $illness_id;
        } else {
            return -2;
        }
    }

    public function hasExistingHistoryIllness($id) {
        $stmt = $this->con->prepare("SELECT id FROM diagnoses_illnesses_conditions WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getHistoryIllnesses($patient_id) {
        $stmt = $this->con->prepare("SELECT * FROM diagnoses_illnesses_conditions WHERE patient_id = ? ORDER BY is_chronic DESC, datetime_created DESC");
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $consults = $stmt->get_result();
        $stmt->close();
        return $consults;
    }

    public function getHistoryIllness($id) {
        $stmt = $this->con->prepare("SELECT * FROM diagnoses_illnesses_conditions WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $consult = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $consult;
    }

    public function deleteHistoryIllness($id) {
        $stmt = $this->con->prepare("DELETE FROM diagnoses_illnesses_conditions WHERE id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
    }

    public function createNewHistorySurgery($patient_id, $surgery_id, $is_name_custom, $name, $date, $notes, $datetime) {
        if ($this->hasExistingHistorySurgery($surgery_id)) {
            return $this->updateHistorySurgery($surgery_id, $is_name_custom, $name, $date, $notes, $datetime);
        } else {
            $stmt = $this->con->prepare("INSERT INTO history_surgeries(patient_id, is_name_custom, name, date, notes, datetime_created, datetime_last_updated) values(?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $patient_id, $is_name_custom, $name, $date, $notes, $datetime, $datetime);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return $patient_id;
            } else {
                return -1;
            }
        }
    }

    public function updateHistorySurgery($surgery_id, $is_name_custom, $name, $date, $notes, $datetime) {
        $stmt = $this->con->prepare("UPDATE history_surgeries SET is_name_custom = ?, name = ?, date = ?, notes = ?, datetime_last_updated = ? WHERE id = ?");
        $stmt->bind_param("ssssss", $is_name_custom, $name, $date, $notes, $datetime, $surgery_id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return $surgery_id;
        } else {
            return -2;
        }
    }

    public function hasExistingHistorySurgery($id) {
        $stmt = $this->con->prepare("SELECT id FROM history_surgeries WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getHistorySurgeries($patient_id) {
        $stmt = $this->con->prepare("SELECT * FROM history_surgeries WHERE patient_id = ? ORDER BY date DESC");
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $consults = $stmt->get_result();
        $stmt->close();
        return $consults;
    }

    public function getHistorySurgery($id) {
        $stmt = $this->con->prepare("SELECT * FROM history_surgeries WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $consult = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $consult;
    }

    public function deleteHistorySurgery($id) {
        $stmt = $this->con->prepare("DELETE FROM history_surgeries WHERE id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
    }

    public function createNewHistoryMedication($patient_id, $medication_id, $name, $quantity, $start_date, $end_date, $is_self_reported, $is_recommended, $notes, $datetime) {
        if ($this->hasExistingHistoryMedication($medication_id)) {
            return $this->updateHistoryMedication($medication_id, $name, $quantity, $start_date, $end_date, $is_self_reported, $notes, $datetime);
        } else {
            $stmt = $this->con->prepare("INSERT INTO history_medications(patient_id, name, quantity, start_date, end_date, is_self_reported, is_recommended, notes, datetime_created, datetime_last_updated) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $patient_id, $name, $quantity, $start_date, $end_date, $is_self_reported, $is_recommended, $notes, $datetime, $datetime);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return $patient_id;
            } else {
                return -1;
            }
        }
    }

    public function updateHistoryMedication($medication_id, $name, $quantity, $start_date, $end_date, $is_self_reported, $notes, $datetime_last_updated) {
        $stmt = $this->con->prepare("UPDATE history_medications SET name = ?, quantity = ?, start_date = ?, end_date = ?, is_self_reported = ?, notes = ?, datetime_last_updated = ? WHERE id = ?");
        $stmt->bind_param("ssssssss", $name, $quantity, $start_date, $end_date, $is_self_reported, $notes, $datetime_last_updated, $medication_id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return $medication_id;
        } else {
            return -2;
        }
    }

    public function hasExistingHistoryMedication($id) {
        $stmt = $this->con->prepare("SELECT id FROM history_medications WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getHistoryMedications($patient_id) {
        $stmt = $this->con->prepare("SELECT * FROM history_medications WHERE patient_id = ? ORDER BY end_date IS NULL DESC, end_date DESC");
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $consults = $stmt->get_result();
        $stmt->close();
        return $consults;
    }

    public function getHistoryMedication($id) {
        $stmt = $this->con->prepare("SELECT * FROM history_medications WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $consult = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $consult;
    }

    public function deleteHistoryMedication($id) {
        $stmt = $this->con->prepare("DELETE FROM history_medications WHERE id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
    }

    public function getCommunityById($id) {
        $stmt = $this->con->prepare("SELECT * FROM communities WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $community = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $community;
    }

    public function getCommunityByName($name) {
        $stmt = $this->con->prepare("SELECT * FROM communities WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $community = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $community;
    }

    public function getPatientById($id) {
        $stmt = $this->con->prepare("SELECT * FROM patients WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $patient = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $patient;
    }

    public function getPatientByInformation($name, $sex, $community_id, $date_of_birth, $exact_date_of_birth_known, $datetime_registered) {
        $stmt = $this->con->prepare("SELECT * FROM patients WHERE name = ? AND sex = ? AND community_id = ? AND date_of_birth = ? AND exact_date_of_birth_known = ? AND datetime_registered = ?");
        $stmt->bind_param("ssssss", $name, $sex, $community_id, $date_of_birth, $exact_date_of_birth_known, $datetime_registered);
        $stmt->execute();
        $patient = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $patient;
    }
    
    public function createPatient($community_id, $name, $sex, $date_of_birth, $exact_date_of_birth_known, $datetime) {
        $stmt = $this->con->prepare("INSERT INTO patients(community_id, name, sex, date_of_birth, exact_date_of_birth_known, datetime_registered, datetime_last_updated) values(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $community_id, $name, $sex, $date_of_birth, $exact_date_of_birth_known, $datetime, $datetime);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return $this->getPatientByInformation($name, $sex, $community_id, $date_of_birth, $exact_date_of_birth_known, $datetime)["id"];   
        } else {
            return -1;
        }
    }

    public function updatePatient($patient_id, $community_id, $name, $sex, $date_of_birth, $exact_date_of_birth_known, $datetime) {
        $stmt = $this->con->prepare("UPDATE patients SET community_id = ?, name = ?, sex = ?, date_of_birth = ?, exact_date_of_birth_known = ?, datetime_last_updated = ? WHERE id = ?");
        $stmt->bind_param("sssssss", $community_id, $name, $sex, $date_of_birth, $exact_date_of_birth_known, $datetime, $patient_id);
        $result = $stmt->execute();
        $stmt->close();
        return $patient_id;
    }

    public function hasSimilarPatient($name, $sex, $date_of_birth, $exact_date_of_birth_known) {
        if($exact_date_of_birth_known == 2) {
            $stmt = $this->con->prepare("SELECT id from patients WHERE name = ? OR (sex = ? AND date_of_birth = ? AND exact_date_of_birth_known = ?)");
            $stmt->bind_param("ssss", $name, $sex, $date_of_birth, $exact_date_of_birth_known);
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->num_rows;
            $stmt->close();
            return $num_rows > 0; 
        } else {
            $stmt = $this->con->prepare("SELECT id from patients WHERE name = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->num_rows;
            $stmt->close();
            return $num_rows > 0; 
        }
    }

    public function getSimilarPatients($name, $sex, $date_of_birth, $exact_date_of_birth_known) {
        if($exact_date_of_birth_known == 'yes') {
            $stmt = $this->con->prepare("SELECT * from patients WHERE name = ? OR (sex = ? AND date_of_birth =  AND exact_date_of_birth_known = ?) ORDER BY name, date_of_birth");
            $stmt->bind_param("ssss", $name, $sex, $date_of_birth, $exact_date_of_birth_known);
            $stmt->execute();
            $similar_patients = $stmt->get_result();
            $stmt->close();
            return $similar_patients;
        } else {
            $stmt = $this->con->prepare("SELECT * from patients WHERE name = ? ORDER BY name, date_of_birth");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $similar_patients = $stmt->get_result();
            $stmt->close();
            return $similar_patients;
        }
    }

    public function createCommunity($name) {
        if(!$this->isCommunityExists($name)) {
            $stmt = $this->con->prepare("INSERT INTO communities(name) values(?)");
            $stmt->bind_param("s", $name);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return $this->getCommunityByName($name)["id"];
            } else {
                return -1;
            }
        } else {
            return getCommunityByName($name)["id"];
        }
    }

    public function isCommunityExists($name) {
        $stmt = $this->con->prepare("SELECT id from communities WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

     //Method to fetch all communities from database
    public function getAllCommunities(){
        $stmt = $this->con->prepare("SELECT * FROM communities ORDER BY LOWER(name)");
        $stmt->execute();
        $communities = $stmt->get_result();
        $stmt->close();
        return $communities;
    }

    //Method to fetch all patients within a specific community from database
    public function getPatientsInCommunity($community_id) {
        $stmt = $this->con->prepare("SELECT * FROM patients WHERE community_id = ? ORDER BY LOWER(name)");
        $stmt->bind_param("s", $community_id);
        $stmt->execute();
        $patients = $stmt->get_result();
        $stmt->close();
        return $patients;
    }

    public function searchPatients($text) {
        $text = '%' . $text . '%';
        $stmt = $this->con->prepare("SELECT * FROM patients WHERE name LIKE ? ORDER BY LOWER(name)");
        $stmt->bind_param("s", $text);
        $stmt->execute();
        $patients = $stmt->get_result();
        $stmt->close();
        return $patients;
    }

}