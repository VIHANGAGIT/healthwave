<?php 
class Doctors{
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function getAllDoctors(){
        $this->db->query('SELECT * FROM doctor WHERE Approval = 1');

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

    public function search_doctors($doctorName, $hospitalId, $specialization){
        if($hospitalId === null){
            $this->db->query('SELECT doctor.* FROM doctor
            WHERE (doctor.First_Name LIKE :doctor_name OR doctor.Last_Name LIKE :doctor_name) AND doctor.Specialization LIKE :specialization');

            $doctorNameValue = ($doctorName === null) ? '%' : '%' . $doctorName . '%'; // not including === here is recommended since it doesnt work sometimes
            $specialization = ($specialization === null) ? '%' : $specialization; // not including === here is recommended

            $this->db->bind(':doctor_name', $doctorNameValue);
            $this->db->bind(':specialization', $specialization);

        }else{
            $this->db->query('SELECT DISTINCT doctor.* FROM doctor
            INNER JOIN schedule ON doctor.Doctor_ID = schedule.Doctor_ID
            WHERE (doctor.First_Name LIKE :doctor_name OR doctor.Last_Name LIKE :doctor_name) AND doctor.Specialization LIKE :specialization AND schedule.Hospital_ID = :hospitalId');
            
            $doctorNameValue = ($doctorName === null) ? '%' : '%' . $doctorName . '%'; // not including === here is recommended
            $specialization = ($specialization === null) ? '%' : $specialization; // not including === here is recommended

            $this->db->bind(':doctor_name', $doctorNameValue);
            $this->db->bind(':specialization', $specialization);
            $this->db->bind(':hospitalId', $hospitalId);
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

    public function cancel_reservation($id){
        $this->db->query('UPDATE doctor_reservation SET Status = "Cancelled" WHERE Doc_Res_ID = :id');

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

            if ($reservationDayOfWeek === $currentDayOfWeek && $reservation->Time_End > $currentTime) {
                $reservation->Date = $currentDate; 
            } else {
                $reservation->Date = $nextReservationDate; 
            }

            $this->db->query('SELECT COUNT(doctor_reservation.Doc_Res_ID) AS NoOfReservations FROM doctor_reservation
            WHERE doctor_reservation.Schedule_ID = :schedule_id AND doctor_reservation.Date = :Date AND doctor_reservation.Status = "Pending"');

            $this->db->bind(':schedule_id', $reservation->Schedule_ID);
            $this->db->bind(':Date', $reservation->Date);
            
            $noOfReservations = $this->db->singleRow();
            $reservation->NoOfReservations = $noOfReservations->NoOfReservations;

            $reservation->Time_Start = date('H:i', strtotime($reservation->Time_Start));
            $reservation->Time_End = date('H:i', strtotime($reservation->Time_End));

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
            // $startTimestamp = strtotime($schedule->Time_Start);
            // $endTimestamp = strtotime($schedule->Time_End);
            
            // $timeDiffInSeconds = $endTimestamp - $startTimestamp;
            // $schedule->No_Of_Total_Slots = ceil($timeDiffInSeconds / 900);;

            $schedule->Time_Start = date('H:i', strtotime($schedule->Time_Start));
            $schedule->Time_End = date('H:i', strtotime($schedule->Time_End));
            
            return $schedule;
        } else{
            return false;
        }

    }

    public function get_total_reservations($schedule_id){
        $this->db->query('SELECT COUNT(Doc_Res_ID) AS NoOfReservations FROM doctor_reservation WHERE Schedule_ID = :schedule_id AND Date = :curretnDate');

        $this->db->bind(':schedule_id', $schedule_id);
        $this->db->bind(':curretnDate', date('Y-m-d'));
        $noOfReservations = $this->db->singleRow();

        if($this->db->execute()){
            return $noOfReservations;
        } else{
            return false;
        }
    }

    public function get_ongoing_reservations($schedule_id, $schedule_start_time,$schecule_end_time){

        date_default_timezone_set('Asia/Colombo');
        $currentDate = date('Y-m-d'); 
        $schedule_start_time = date('H:i:s', strtotime($schedule_start_time));
        $schecule_end_time = date('H:i:s', strtotime($schecule_end_time));

        $this->db->query('SELECT doctor_reservation.*, patient.First_Name, patient.Last_Name, patient.Gender, patient.DOB, patient.Patient_ID FROM doctor_reservation 
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
        }
        
        if ($this->db->execute()) {
            return $reservations;
        } else {
            return false;
        }
        
    }

    public function get_past_consultations($doctorId){
        $this->db->query('SELECT doctor_reservation.*, patient.First_Name, patient.Last_Name, hospital.Hospital_Name, doctor_consultation.Comments, doctor_consultation.Prescription_ID FROM doctor_reservation
        INNER JOIN patient ON doctor_reservation.Patient_ID = patient.Patient_ID
        INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
        INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
        LEFT JOIN doctor_consultation ON doctor_reservation.Doc_Res_ID = doctor_consultation.Doc_Res_ID
        WHERE schedule.Doctor_ID = :doctorId AND doctor_reservation.Status = "Consulted" ORDER BY doctor_reservation.Date, doctor_reservation.Start_Time ASC');

        $this->db->bind(':doctorId', $doctorId);
        $consultations = $this->db->resultSet();

        // Loop through the reservations and set the date and time
        foreach($consultations as $consultation) {
            $consultation->Start_Time = date('H:i', strtotime($consultation->Start_Time));
            $consultation->End_Time = date('H:i', strtotime($consultation->End_Time));
        }

        if ($this->db->execute()) {
            return $consultations;
        } else {
            return false;
        }
    }

    public function get_patient_details($id, $type){
        if($type == 'past'){
            $this->db->query('SELECT patient.Patient_ID, patient.First_Name, patient.Last_Name, patient.Gender, patient.DOB, patient.Blood_Group, patient.Allergies FROM doctor_reservation 
            INNER JOIN patient ON doctor_reservation.Patient_ID = patient.Patient_ID
            WHERE doctor_reservation.Doc_Res_ID = :res_id');

            $this->db->bind(':res_id', $id);
            $patient = $this->db->singleRow();

            $this->db->query('SELECT doctor_consultation.Comments FROM doctor_consultation WHERE doctor_consultation.Doc_Res_ID = :res_id');

            $this->db->bind(':res_id', $id);
            $comment = $this->db->singleRow();

            $patient->Remarks = $comment->Comments;
            
        }else{
            $this->db->query('SELECT Patient_ID, First_Name, Last_Name, Gender, DOB, Blood_Group, Allergies FROM patient WHERE Patient_ID = :patient_id');
            $this->db->bind(':patient_id', $id);

            $patient = $this->db->singleRow();
        }

        
        // echo json_encode($patient);

        if ($this->db->execute()) {
            return $patient;
        } else {
            return 'false';
        }
    }

    public function add_consultation($res_id, $prescription_id, $comments){
        $this->db->query('UPDATE doctor_reservation SET Status = "Consulted" WHERE Doc_Res_ID = :res_id');

        $this->db->bind(':res_id', $res_id);

        if($this->db->execute()){
            $this->db->query('INSERT INTO doctor_consultation(Doc_Res_ID, Prescription_ID, Comments) VALUES(:res_id, :prescription_id, :comments)');

            $this->db->bind(':res_id', $res_id);
            $this->db->bind(':prescription_id', $prescription_id);
            $this->db->bind(':comments', $comments);

            if($this->db->execute()){
                $this->db->query('SELECT LAST_INSERT_ID() AS consultation_id');
                $row = $this->db->singleRow();
                return $row->consultation_id;
            } else{
                return false;
            }
        }else{
            return false;
        }
        
    }

    public function add_prescription($consultationId, $diagnosis, $remarks, $referral, $drugDetails, $testDetails){
        
        $this->db->query('INSERT INTO prescription(Doc_Consult_ID, Diagnosis, Referrals, Drug_Details, Test_Details, Status) VALUES(:consultationId, :diagnosis, :referral, :drugDetails, :testDetails, :status)');

        $this->db->bind(':consultationId', $consultationId);
        $this->db->bind(':diagnosis', $diagnosis);
        $this->db->bind(':referral', $referral);
        $this->db->bind(':drugDetails', $drugDetails);
        $this->db->bind(':testDetails', $testDetails);
        $this->db->bind(':status', 'Not Claimed');

        if($this->db->execute()){
            $this->db->query('SELECT LAST_INSERT_ID() AS prescription_id');
            $row = $this->db->singleRow();

            $this->db->query('UPDATE doctor_consultation SET Prescription_ID = :prescription_id, Comments = :comments WHERE Doc_Consult_ID = :consultationId');

            $this->db->bind(':prescription_id', $row->prescription_id);
            $this->db->bind(':comments', $remarks);
            $this->db->bind(':consultationId', $consultationId);

            if($this->db->execute()){
                $this->db->query('SELECT LAST_INSERT_ID() AS prescription_id');
                $row = $this->db->singleRow();
                return $row->prescription_id;
            } else{
                return false;
            }
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

    public function doctor_profile_update($data){
        $this->db->query('UPDATE doctor SET Contact_No = :C_num, Charges = :Charges, Username = :Uname, Password = :Pass WHERE Doctor_ID = :Doctor_ID');

        // Binding parameters for the prepaired statement
        $this->db->bind(':Charges', $data['Charges']);
        $this->db->bind(':C_num', $data['C_Num']);
        $this->db->bind(':Uname', $data['Email']);
        $this->db->bind(':Pass', $data['Pass']);
        $this->db->bind(':Doctor_ID', $data['ID']);

        // Execute query
        if($this->db->execute()){
            return true;
        } else{
            return false;
        }
    }

    public function findDoctorBySLMC($slmc){
        $this->db->query('SELECT * FROM doctor WHERE SLMC_Reg_No = :slmc');

        // Binding parameters for the prepaired statement
        $this->db->bind(':slmc', $slmc);
        $doctorRow = $this->db->singleRow();

        // Execute query
        if($this->db->execute()){
            return $doctorRow;
        } else{
            return false;
        }
    }


}