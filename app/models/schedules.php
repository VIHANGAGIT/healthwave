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

    public function fetch_booked_slots($schedule_id, $date){
        $this->db->query('SELECT Time_Start, Time_End FROM schedule
        WHERE Schedule_ID = :schedule_id');
        $this->db->bind(':schedule_id', $schedule_id);
        $time_duration = $this->db->singleRow();

        $startTime = $time_duration->Time_Start;
        $endTime = $time_duration->Time_End;

        if($this->db->execute()){
            // date_default_timezone_set('Asia/Colombo');
            $todayDate = date('Y-m-d');
            $this->db->query('SELECT doctor_reservation.Start_Time, doctor_reservation.Date, doctor_reservation.Appointment_No FROM doctor_reservation
            WHERE DATE(doctor_reservation.Date) >= :todayDate AND doctor_reservation.Date = :date AND doctor_reservation.Status = "Pending"
            AND doctor_reservation.Start_Time BETWEEN :startTime AND :endTime');

            // Binding parameters for the prepared statement
            $this->db->bind(':todayDate', $todayDate);
            $this->db->bind(':startTime', $startTime);
            $this->db->bind(':endTime', $endTime);
            $this->db->bind(':date', $date);
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