<?php

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
        $stmt = $this->con->prepare("SELECT * FROM diagnoses_illnesses_conditions WHERE patient_id = ? ORDER BY end_date IS NULL DESC, end_date DESC");
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

?>