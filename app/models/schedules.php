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
        $hospitals = $this->db->resultSet();
        
        if($this->db->execute()){
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

    public function fetch_booked_slots($schedule_id){
        $this->db->query('SELECT Time_Start, Time_End FROM schedule
        WHERE Schedule_ID = :schedule_id');
        $this->db->bind(':schedule_id', $schedule_id);
        $time_duration = $this->db->singleRow();

        $startTime = $time_duration->Time_Start;
        $endTime = $time_duration->Time_End;

        if($this->db->execute()){
            $this->db->query('SELECT doctor_reservation.Start_Time FROM doctor_reservation
            WHERE doctor_reservation.Start_Time between :startTime and :end_time');
    
            // Binding parameters for the prepaired statement
            $this->db->bind(':startTime', $startTime);
            $this->db->bind(':end_time', $endTime);
            $booked_slots = $this->db->resultSet();
            
            if($this->db->execute()){
                return $booked_slots;
            } else{
                return false;
            }
        } else{
            return false;
        }

        
    }


}