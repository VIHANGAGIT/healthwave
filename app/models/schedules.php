<?php 
class Schedules{
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function doctor_schedule_hospital($id){
        $this->db->query('SELECT DISTINCT hospital.Hospital_ID, hospital.Hospital_Name, hospital.Charge FROM schedule
        INNER JOIN hospital ON schedule.hospital_id = hospital.hospital_id
        WHERE schedule.Doctor_ID = :id;');

        // Binding parameters for the prepaired statement
        $this->db->bind(':id', $id);
        $hospitals = $this->db->resultSet();if($this->db->execute()){
            return $hospitals;
        } else{
            return false;
        }
    }

    public function get_schedule_by_hospital_doctor($hospital_id, $doctor_id){
        $this->db->query('SELECT * FROM schedule WHERE hospital_id = :hospital_id AND Doctor_ID = :doctor_id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':hospital_id', $hospital_id);
        $this->db->bind(':doctor_id', $doctor_id);
        $schedule = $this->db->resultSet();
        
        if($this->db->execute()){
            return $schedule;
        } else{
            return false;
        }
    }


}