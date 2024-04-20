<?php 
class Doctors{
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function getAllDoctors(){
        $this->db->query('SELECT * FROM doctor');

        $doctors = $this->db->resultSet();
        return $doctors;
    }

    public function doctor_data_fetch($id){
        $this->db->query('SELECT * FROM doctor WHERE Doctor_ID = :id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':id', $id);
        $doctorRow = $this->db->singleRow();

        // Execute query
        if($this->db->execute()){
            return $doctorRow;
        } else{
            return false;
        }
    }

    public function get_no_of_hospitals($id){
        $this->db->query('SELECT COUNT(DISTINCT Hospital_ID) AS NoOfHospitals FROM schedule WHERE Doctor_ID = :id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':id', $id);
        $noOfHospitals = $this->db->singleRow();

        // Execute query
        if($this->db->execute()){
            return $noOfHospitals;
        } else{
            return false;
        }
    }

    public function search_doctors($doctorId, $hospitalId, $specialization){
        if($hospitalId === null){
            $this->db->query('SELECT doctor.* FROM doctor
            WHERE doctor.Doctor_ID LIKE :doctorId AND doctor.Specialization LIKE :specialization');

            $this->db->bind(':doctorId', $doctorId === null ? '%' : $doctorId);
            $this->db->bind(':specialization', $specialization === null ? '%' : $specialization);

        }else{
            $this->db->query('SELECT DISTINCT doctor.* FROM doctor
            INNER JOIN schedule ON doctor.Doctor_ID = schedule.Doctor_ID
            WHERE schedule.Doctor_ID LIKE :doctorId AND doctor.Specialization LIKE :specialization AND schedule.Hospital_ID = :hospitalId');
            
            $this->db->bind(':doctorId', $doctorId === null ? '%' : $doctorId);
            $this->db->bind(':specialization', $specialization === null ? '%' : $specialization);
            $this->db->bind(':hospitalId', $hospitalId === null ? '%' : $hospitalId);
        }


        $doctors = $this->db->resultSet();
        if($this->db->execute()){
            return $doctors;
        } else{
            return false;
        }
        
    }

    public function delete_reservation($id){
        $this->db->query('DELETE FROM doctor_reservation WHERE Doc_Res_ID = :id');

        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else{
            return false;
        }
    }

    public function get_reservations($id){
                
        $this->db->query('SELECT schedule.*, hospital.Hospital_Name, room.Room_Name FROM schedule
        INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
        INNER JOIN room ON schedule.Room_ID = room.Room_ID
        WHERE schedule.Doctor_ID = :id');

        $this->db->bind(':id', $id);

        $reservations = $this->db->resultSet();
        
        date_default_timezone_set('Asia/Colombo');
        $currentDate = date('Y-m-d'); 
        $currentTime = date('H:i:s');
        $currentDayOfWeek = date('D', strtotime($currentDate));

        // Loop through the reservations and set the date and time
        foreach($reservations as $reservation) {
            $reservationDayOfWeek = $reservation->Day_of_Week;

            $nextReservationDate = date('Y-m-d', strtotime('next ' . $reservationDayOfWeek, strtotime($currentDate)));

            if ($reservationDayOfWeek === $currentDayOfWeek && $reservation->End_Time < $currentTime) {
                $reservation->Date = $currentDate; 
            } else {
                $reservation->Date = $nextReservationDate; 
            }

            $reservation->Time_Start = date('H:i', strtotime($reservation->Time_Start));
            $reservation->Time_End = date('H:i', strtotime($reservation->Time_End));

            $this->db->query('SELECT COUNT(doctor_reservation.Doc_Res_ID) AS NoOfReservations FROM doctor_reservation
            WHERE doctor_reservation.Schedule_ID = :schedule_id');

            $this->db->bind(':schedule_id', $reservation->Schedule_ID);
            $noOfReservations = $this->db->singleRow();
            $reservation->NoOfReservations = $noOfReservations->NoOfReservations;

        }
        // Check if any rows were returned
        if ($this->db->rowCount() > 0) {
            return $reservations;
        } else {
            return false;
        }
    }

    public function get_current_schedule($id){
        date_default_timezone_set('Asia/Colombo');
        $currentDate = date('Y-m-d'); 
        $currentTime = date('H:i:s');
        $currentDayOfWeek = date('D', strtotime($currentDate));
                
        $this->db->query('SELECT schedule.*, hospital.Hospital_Name FROM Schedule 
        INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
        WHERE Doctor_ID = :id AND Day_of_Week = :currentDayOfWeek AND Time_Start < :currentTime AND Time_End > :currentTime');

        $this->db->bind(':id', $id);
        $this->db->bind(':currentDayOfWeek', $currentDayOfWeek);
        $this->db->bind(':currentTime', $currentTime);

        $schedule = $this->db->singleRow();
        if($this->db->rowCount()>0){
            $schedule->Date = $currentDate;
            $startTimestamp = strtotime($schedule->Time_Start);
            $endTimestamp = strtotime($schedule->Time_End);
            
            $timeDiffInSeconds = $endTimestamp - $startTimestamp;
            $schedule->No_Of_Total_Slots = ceil($timeDiffInSeconds / 900);;

            $schedule->Time_Start = date('H:i', strtotime($schedule->Time_Start));
            $schedule->Time_End = date('H:i', strtotime($schedule->Time_End));
            
            return $schedule;
        } else{
            return false;
        }

    }

    public function get_ongoing_reservations($schedule_id, $schedule_start_time,$schecule_end_time){

        date_default_timezone_set('Asia/Colombo');
        $currentDate = date('Y-m-d'); 
        $schedule_start_time = date('H:i:s', strtotime($schedule_start_time));
        $schecule_end_time = date('H:i:s', strtotime($schecule_end_time));

        $this->db->query('SELECT doctor_reservation.*, patient.First_Name, patient.Last_Name, patient.Gender, patient.DOB FROM doctor_reservation 
        INNER JOIN patient ON doctor_reservation.Patient_ID = patient.Patient_ID
        WHERE doctor_reservation.Schedule_ID = :ScheduleId AND doctor_reservation.Date = :currentDate AND doctor_reservation.Start_Time >= :startTime AND doctor_reservation.End_Time <= :endTime AND doctor_reservation.Status = "Pending"
        ORDER BY doctor_reservation.Start_Time ASC');

        $this->db->bind(':ScheduleId', $schedule_id);
        $this->db->bind(':currentDate', $currentDate);
        $this->db->bind(':startTime', $schedule_start_time);
        $this->db->bind(':endTime', $schecule_end_time);

        $reservations = $this->db->resultSet();
        
        // Loop through the reservations and set the date and time
        foreach($reservations as $reservation) {
            $reservation->Start_Time = date('H:i', strtotime($reservation->Start_Time));
            $reservation->End_Time = date('H:i', strtotime($reservation->End_Time));

            // $reservationDayOfWeek = $reservation->Day_of_Week;

            // $nextReservationDate = date('Y-m-d', strtotime('next ' . $reservationDayOfWeek, strtotime($currentDate)));

            // if ($reservationDayOfWeek === $currentDayOfWeek && $reservation->Time_End < $currentTime) {
            //     $reservation->Date = $currentDate; 
            // } else {
            //     $reservation->Date = $nextReservationDate; 
            // }

            // $this->db->query('SELECT COUNT(doctor_reservation.Doc_Res_ID) AS NoOfReservations FROM doctor_reservation
            // WHERE doctor_reservation.Schedule_ID = :schedule_id');

            // $this->db->bind(':schedule_id', $reservation->Schedule_ID);
            // $noOfReservations = $this->db->singleRow();
            // $reservation->NoOfReservations = $noOfReservations->NoOfReservations;

        }
        
        if ($this->db->execute()) {
            return $reservations;
        } else {
            return false;
        }
        
    }


}