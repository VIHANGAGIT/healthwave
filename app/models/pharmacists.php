<?php 
class Pharmacists{
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function pending_prescription_data_fetch($hospital_id){
        $this->db->query('SELECT prescription.*, patient.First_Name, patient.Last_Name, doctor.First_Name as Doc_First_Name, doctor.Last_Name as Doc_Last_Name FROM prescription
        INNER JOIN doctor_consultation ON prescription.Doc_Consult_ID = doctor_consultation.Doc_Consult_ID
        INNER JOIN doctor_reservation ON doctor_consultation.Doc_Res_ID = doctor_reservation.Doc_Res_ID
        INNER JOIN patient ON doctor_reservation.Patient_ID = patient.Patient_ID
        INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
        INNER JOIN doctor ON schedule.Doctor_ID = doctor.Doctor_ID
        WHERE schedule.Hospital_ID = :hospital_id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':hospital_id', $hospital_id);
        $prescriptions = $this->db->resultSet();

        if($this->db->execute()){
            return $prescriptions;
        } else{
            return false;
        }
    }

    public function hospital_data_fetch($id){
        $this->db->query('SELECT Hospital_ID FROM hospital_staff WHERE HS_ID = :id');

        $this->db->bind(':id', $id);
        $hospital_id = $this->db->singleRow();

        $this->db->query('SELECT * FROM hospital WHERE Hospital_ID = :id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':id', $hospital_id->Hospital_ID);
        $hospitalRow = $this->db->singleRow();

        // Execute query
        if($this->db->execute()){
            return $hospitalRow;
        } else{
            return false;
        }
    }

    public function get_prescription_data($id){
        $this->db->query('SELECT prescription.*, patient.First_Name, patient.Last_Name, patient.Gender, patient.DOB, patient.Allergies, patient.NIC, doctor_reservation.Date, doctor_consultation.Comments, doctor.First_Name as Doc_First_Name, doctor.Last_Name as Doc_Last_Name, doctor.SLMC_Reg_No, doctor.Specialization, hospital.Hospital_Name, hospital.Contact_No FROM prescription 
        INNER JOIN doctor_consultation ON prescription.Doc_Consult_ID = doctor_consultation.Doc_Consult_ID
        INNER JOIN doctor_reservation ON doctor_consultation.Doc_Res_ID = doctor_reservation.Doc_Res_ID
        INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
        INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
        INNER JOIN doctor ON schedule.Doctor_ID = doctor.Doctor_ID
        INNER JOIN patient ON doctor_reservation.Patient_ID = patient.Patient_ID
        WHERE prescription.Prescription_ID = :id');
        $this->db->bind(':id', $id);
        $prescription = $this->db->singleRow();

        if ($prescription->Drug_Details != null) {
            $drugDetails = json_decode($prescription->Drug_Details, true); 
            
            $prescription->Drug_Details = $drugDetails;
        }

        if ($prescription->Test_Details != null) {
            $testDetails = json_decode($prescription->Test_Details, true);
            foreach ($testDetails as &$test) { // Use reference (&) to modify the array directly
                $this->db->query('SELECT Test_Name FROM test WHERE Test_ID = :test');
                $this->db->bind(':test', $test);
                $testName = $this->db->singleRow();
                if ($testName) {
                    $test = $testName->Test_Name;
                }
            }
            $prescription->Test_Details = $testDetails;
        }


        if ($this->db->execute()) {
            return $prescription;
        } else {
            return false;
        }

    }

    public function complete_prescription($prescription_id){
        $this->db->query('UPDATE prescription SET Status = "Claimed" WHERE Prescription_ID = :id');
        $this->db->bind(':id', $prescription_id);

        if($this->db->execute()){
            return true;
        } else{
            return false;
        }
    }

    public function search_prescription_with_id_hospital($pres_id, $patient_name, $hospital_id){
        $this->db->query('SELECT prescription.*, patient.First_Name, patient.Last_Name, doctor.First_Name as Doc_First_Name, doctor.Last_Name as Doc_Last_Name FROM prescription
        INNER JOIN doctor_consultation ON prescription.Doc_Consult_ID = doctor_consultation.Doc_Consult_ID
        INNER JOIN doctor_reservation ON doctor_consultation.Doc_Res_ID = doctor_reservation.Doc_Res_ID
        INNER JOIN patient ON doctor_reservation.Patient_ID = patient.Patient_ID
        INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
        INNER JOIN doctor ON schedule.Doctor_ID = doctor.Doctor_ID
        WHERE prescription.Prescription_ID LIKE :pres_id AND (patient.First_Name LIKE :patient_name OR patient.Last_Name LIKE :patient_name) AND schedule.Hospital_ID = :hospital_id');

        $pres_id = $pres_id == '' ? '%' : $pres_id;
        $patient_name = $patient_name == '' ? '%' : "%" . $patient_name . "%";
       
        $this->db->bind(':pres_id', $pres_id);
        $this->db->bind(':patient_name', $patient_name);
        $this->db->bind(':hospital_id', $hospital_id);

        $prescriptions = $this->db->resultSet();
        
        if($this->db->execute()){
            return $prescriptions;
        } else{
            return false;
        }
    }


}