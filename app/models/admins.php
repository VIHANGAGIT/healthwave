<?php 
    class Admins{
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }

        public function admin_data_fetch($id){
            $this->db->query('SELECT * FROM admin WHERE Admin_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);
            $adminRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $adminRow;
            } else{
                return false;
            }
        }

        public function admin_profile_update($data){
            $this->db->query('UPDATE admin SET First_Name = :F_name, Last_Name= :L_name, NIC = :NIC, Contact_No = :C_num, Username = :Uname, Password = :Pass WHERE Admin_ID = :Admin_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['First_Name']);
            $this->db->bind(':L_name', $data['Last_Name']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_Num']);
            $this->db->bind(':Uname', $data['Username']);
            $this->db->bind(':Pass', $data['Pass']);
            $this->db->bind(':Admin_ID', $data['Admin_ID']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function getDoctors(){
            $this->db->query('SELECT * FROM doctor');
            $doctors = $this->db->resultSet();

            // Check if any rows were returned
            if ($this->db->rowCount() > 0) {
                return $doctors;
            } else {
                return false;
            }
        }

        public function getHospitals(){
            $this->db->query('SELECT * FROM hospital');
            $hospitals = $this->db->resultSet();

            // Check if any rows were returned
            if ($this->db->rowCount() > 0) {
                return $hospitals;
            } else {
                return false;
            }
        }

        public function getTests(){
            $this->db->query('SELECT * FROM test');
            $tests = $this->db->resultSet();

            // Check if any rows were returned
            if ($this->db->rowCount() > 0) {
                return $tests;
            } else {
                return false;
            }
        }
   
        public function add_doctor($data){
            $this->db->query('INSERT INTO doctor (First_Name, Last_Name, Gender, NIC, Contact_No, SLMC_Reg_No, Specialization, Availability, Charges, Username, Password) VALUES (:F_name, :L_name, :Gender, :NIC, :C_num, :SLMC, :Spec, :Avail, :Charges, :Uname, :Pass)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['F_name']);
            $this->db->bind(':L_name', $data['L_name']);
            $this->db->bind(':Gender', $data['Gender']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_num']);
            $this->db->bind(':SLMC', $data['SLMC']);
            $this->db->bind(':Spec', $data['Spec']);
            $this->db->bind(':Avail', $data['Avail']);
            $this->db->bind(':Charges', $data['Charges']);
            $this->db->bind(':Uname', $data['Uname']);
            $this->db->bind(':Pass', $data['Pass']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function add_hospital($data){
            $this->db->query('INSERT INTO hospital (Hospital_Name, Address, Region, Charge, Contact_No) VALUES (:H_name, :H_address, :Region, :H_charge, :C_num)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':H_name', $data['H_name']);
            $this->db->bind(':H_address', $data['H_address']);
            $this->db->bind(':Region', $data['Region']);
            $this->db->bind(':H_charge', $data['H_charge']);
            $this->db->bind(':C_num', $data['C_num']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function add_test($data){
            $this->db->query('INSERT INTO test (Test_Name, Test_Type) VALUES (:T_name, :T_type)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':T_name', $data['T_name']);
            $this->db->bind(':T_type', $data['T_type']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

      
        public function test_data_fetch($id){
            $this->db->query('SELECT * FROM test WHERE Test_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);
            $testRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $testRow;
            } else{
                return false;
            }
        }

        public function update_test($data){
            $this->db->query('UPDATE test SET Test_Name = :T_name, Test_Type = :T_type WHERE Test_ID = :Test_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':T_name', $data['T_name']);
            $this->db->bind(':T_type', $data['T_type']);
            $this->db->bind(':Test_ID', $data['ID']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function hospital_data_fetch($id){
            $this->db->query('SELECT * FROM hospital WHERE Hospital_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);
            $hospitalRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $hospitalRow;
            } else{
                return false;
            }
        }

        public function edit_hospital($data){
            $this->db->query('UPDATE hospital SET Hospital_Name = :H_name, Address = :H_address, Region = :Region, Charge = :H_charge, Contact_No = :C_num WHERE Hospital_ID = :H_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':H_name', $data['H_name']);
            $this->db->bind(':H_address', $data['H_address']);
            $this->db->bind(':Region', $data['Region']);
            $this->db->bind(':H_charge', $data['H_charge']);
            $this->db->bind(':H_ID', $data['H_ID']);
            $this->db->bind(':C_num', $data['C_num']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function get_appointments($doc_id){
            $this->db->query('SELECT doctor_reservation.Doc_Res_ID FROM doctor_reservation 
            INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            WHERE schedule.Doctor_ID = :doc_id AND doctor_reservation.Date >= CURDATE() AND doctor_reservation.End_Time >= CURTIME()');

            // Binding parameters for the prepaired statement
            $this->db->bind(':doc_id', $doc_id);
            $appointments = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $appointments;
            } else{
                return false;
            }
        }

        public function get_appointments_hospital($hospital_id){
            $this->db->query('SELECT doctor_reservation.Doc_Res_ID FROM doctor_reservation 
            INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            WHERE schedule.Hospital_ID = :hospital_id AND doctor_reservation.Date >= CURDATE() AND doctor_reservation.End_Time >= CURTIME()');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $appointments = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $appointments;
            } else{
                return false;
            }
        }

        public function get_appointments_test($test_id){
            $this->db->query('SELECT Test_Res_ID FROM test_reservation 
            WHERE Test_ID = :test_id AND Date >= CURDATE() AND End_Time >= CURTIME()');

            // Binding parameters for the prepaired statement
            $this->db->bind(':test_id', $test_id);
            $appointments = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $appointments;
            } else{
                return false;
            }
        }

        public function search_doc_appointments($patient_name, $doctor_name, $hospital_name, $date){
            $this->db->query('SELECT doctor_reservation.*, patient.First_Name, patient.Last_Name, 
            doctor.First_Name AS Doc_First_Name, doctor.Last_Name AS Doc_Last_Name, 
            doctor.Specialization, hospital.Hospital_Name, schedule.Time_Start, schedule.Time_End
            FROM doctor_reservation 
            INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            INNER JOIN doctor ON schedule.Doctor_ID = doctor.Doctor_ID
            INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
            INNER JOIN patient ON doctor_reservation.Patient_ID = patient.Patient_ID
            WHERE (patient.First_Name LIKE :patient_name OR patient.Last_Name LIKE :patient_name) 
            AND (doctor.First_Name LIKE :doctor_name OR doctor.Last_Name LIKE :doctor_name) 
            AND hospital.Hospital_Name LIKE :hospital_name AND doctor_reservation.Date LIKE :date
            AND doctor_reservation.Date >= CURDATE() AND doctor_reservation.Status = "Pending"');
  
            // Sanitize and set default values for parameters
            $patient_name = ($patient_name === null) ? "%" : "%" . $patient_name . "%";
            $doctor_name = ($doctor_name === null) ? "%" : "%" . $doctor_name . "%";
            $hospital_name = ($hospital_name === null) ? "%" : "%" . $hospital_name . "%"; 
            $date = ($date == null) ? "%" : $date;

            // Binding parameters for the prepaired statement
            $this->db->bind(':patient_name', $patient_name);
            $this->db->bind(':doctor_name', $doctor_name);
            $this->db->bind(':hospital_name', $hospital_name);
            $this->db->bind(':date', $date);
            $appointments = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $appointments;
            } else{
                return false;
            }
        }

        public function search_test_appointments($patient_name, $test_name, $hospital_name, $date){
            $this->db->query('SELECT test_reservation.*, patient.First_Name, patient.Last_Name, 
            test.Test_Name, hospital.Hospital_Name
            FROM test_reservation 
            INNER JOIN test ON test_reservation.Test_ID = test.Test_ID
            INNER JOIN hospital ON test_reservation.Hospital_ID = hospital.Hospital_ID
            INNER JOIN patient ON test_reservation.Patient_ID = patient.Patient_ID
            WHERE (patient.First_Name LIKE :patient_name OR patient.Last_Name LIKE :patient_name) 
            AND test.Test_Name LIKE :test_name AND hospital.Hospital_Name LIKE :hospital_name 
            AND test_reservation.Date LIKE :date AND test_reservation.Date >= CURDATE() AND test_reservation.Status = "Pending"');
  
            // Sanitize and set default values for parameters
            $patient_name = ($patient_name === null) ? "%" : "%" . $patient_name . "%";
            $test_name = ($test_name === null) ? "%" : "%" . $test_name . "%";
            $hospital_name = ($hospital_name === null) ? "%" : "%" . $hospital_name . "%"; 
            $date = ($date == null) ? "%" : $date;

            // Binding parameters for the prepaired statement
            $this->db->bind(':patient_name', $patient_name);
            $this->db->bind(':test_name', $test_name);
            $this->db->bind(':hospital_name', $hospital_name);
            $this->db->bind(':date', $date);
            $appointments = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $appointments;
            } else{
                return false;
            }
        }

        public function reservation_data_fetch($res_id){
            $this->db->query('SELECT doctor_reservation.*, patient.First_Name, patient.Last_Name, patient.NIC, schedule.Doctor_ID, hospital.Hospital_ID FROM doctor_reservation 
            INNER JOIN patient ON doctor_reservation.Patient_ID = patient.Patient_ID
            INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
            WHERE doctor_reservation.Doc_Res_ID = :res_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':res_id', $res_id);
            $reservationRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $reservationRow;
            } else{
                return false;
            }
        }

        public function get_schedule_days($Doctor_ID, $Hospital_ID){
            $this->db->query('SELECT Day_of_Week FROM schedule WHERE Doctor_ID = :doc_id AND Hospital_ID = :hospital_id');
            $this->db->bind(':doc_id', $Doctor_ID);
            $this->db->bind(':hospital_id', $Hospital_ID);
            $days = $this->db->resultSet();
            if ($this->db->rowCount() > 0) {
                return $days;
            } else {
                false;
            }
        }

        public function get_appointment_data($schedule_id, $date){
            $this->db->query('SELECT doctor_reservation.Appointment_No, schedule.Time_Start, schedule.Time_End FROM doctor_reservation 
            INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            WHERE Schedule_ID = :schedule_id AND Date = :date');
            $this->db->bind(':schedule_id', $schedule_id);
            $this->db->bind(':date', $date);
            $appointments = $this->db->resultSet();
            if ($this->db->rowCount() > 0) {
                return $appointments;
            } else {
                false;
            }
        }

        public function edit_reservation($data){
            $this->db->query('UPDATE doctor_reservation SET Date = :date, Start_Time = :start_time, End_Time = :end_time, Appointment_No = :app_no WHERE Doc_Res_ID = :res_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':date', $data['date']);
            $this->db->bind(':start_time', $data['start_time']);
            $this->db->bind(':end_time', $data['end_time']);
            $this->db->bind(':app_no', $data['app_no']);
            $this->db->bind(':res_id', $data['res_id']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }


        public function remove_test(){
            $this->db->query('DELETE FROM test WHERE Test_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $_GET['test_id']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function remove_doctor(){
            $this->db->query('DELETE FROM doctor WHERE Doctor_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $_GET['doc_id']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function remove_hospital(){
            $this->db->query('DELETE FROM hospital WHERE Hospital_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $_GET['hospital_id']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }
    }        