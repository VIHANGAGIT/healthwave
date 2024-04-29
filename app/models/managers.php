<?php 
    class Managers{
        private $db;
        
        public function __construct(){
            $this->db = new Database;

    
        }

        public function hospital_staff_data_fetch($id){
            $this->db->query('SELECT * FROM hospital_staff WHERE HS_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);
            $hospital_staffRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $hospital_staffRow;
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
    

        public function manager_labtest_data_fetch($id){
            $this->db->query ('SELECT test.*, hospital_test.Price FROM test 
            INNER JOIN hospital_test ON hospital_test.Test_ID = test.Test_ID 
            WHERE hospital_test.Hospital_ID = :id');
        
            $this->db->bind(':id', $id);
        
            
            $testRows = $this->db->resultSet();
        
            if($testRows) {
                return $testRows; 
            } else {
                return false;
            }
        }

        public function get_appointments_test_hospital($test_id, $hospital_id){
            $this->db->query('SELECT Test_Res_ID FROM test_reservation 
            WHERE Test_ID = :test_id AND Date >= CURDATE() AND Status = "Pending" AND Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':test_id', $test_id);
            $this->db->bind(':hospital_id', $hospital_id);
            $appointments = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $appointments;
            } else{
                return false;
            }
        }

        public function search_tests_with_id_hospital($T_Name, $T_ID, $T_Type, $hospital_id){
            $this->db->query('SELECT test.Test_ID, test.Test_Name, test.Test_Type, hospital_test.Price FROM test
            INNER JOIN hospital_test ON test.Test_ID = hospital_test.Test_ID
            WHERE test.Test_Name LIKE :T_Name AND test.Test_ID LIKE :T_ID AND test.Test_Type LIKE :T_Type AND hospital_test.Hospital_ID = :hospital_id');

            $T_Name = ($T_Name == null) ? '%' : '%' . $T_Name . '%';
            $T_Type = ($T_Type == null) ? '%' : $T_Type;
            $T_ID = ($T_ID == null) ? '%' : $T_ID;

            $this->db->bind(':T_Name', $T_Name);
            $this->db->bind(':T_ID', $T_ID);
            $this->db->bind(':T_Type', $T_Type);
            $this->db->bind(':hospital_id', $hospital_id);

            $tests = $this->db->resultSet();

            if($this->db->rowCount()>0){
                return $tests;
            } else{
                return false;
            }   
        }

        public function add_test($data, $hospital_id){
            $this->db->query('INSERT INTO hospital_test (Test_ID, Hospital_ID, Price) VALUES (:T_ID, :Hospital_ID, :T_Price)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':T_ID', $data['T_ID']);
            $this->db->bind(':Hospital_ID', $hospital_id);
            $this->db->bind(':T_Price', $data['T_price']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function get_test($test_id, $hospital_id){
            $this->db->query('SELECT test.*, hospital_test.Price FROM hospital_test 
            INNER JOIN test ON hospital_test.Test_ID = test.Test_ID
            WHERE hospital_test.Test_ID = :test_id AND hospital_test.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':test_id', $test_id);
            $this->db->bind(':hospital_id', $hospital_id);
            $test = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $test;
            } else{
                return false;
            }
        }

        public function edit_test($data, $hospital_id){
            $this->db->query('UPDATE hospital_test SET Price = :T_Price WHERE Test_ID = :T_ID AND Hospital_ID = :Hospital_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':T_ID', $data['T_ID']);
            $this->db->bind(':Hospital_ID', $hospital_id);
            $this->db->bind(':T_Price', $data['T_price']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function remove_test($test_id, $hospital_id){
            $this->db->query('DELETE FROM hospital_test WHERE Test_ID = :test_id AND Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':test_id', $test_id);
            $this->db->bind(':hospital_id', $hospital_id);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function approve_pharmacist($id){
            $this->db->query('UPDATE hospital_staff SET Approval = 1 WHERE HS_ID = :id');
            $this->db->bind(':id', $id);

            // Execute query
            if($this->db->execute()){
                $this->db->query('SELECT First_Name, Last_Name FROM hospital_staff WHERE HS_ID = :id');
                $this->db->bind(':id', $id);
                $pharm = $this->db->singleRow();
                return $pharm;
            } else{
                return false;
            }
        }

        public function approve_lab($id){
            $this->db->query('UPDATE hospital_staff SET Approval = 1 WHERE HS_ID = :id');
            $this->db->bind(':id', $id);

            // Execute query
            if($this->db->execute()){
                $this->db->query('SELECT First_Name, Last_Name FROM hospital_staff WHERE HS_ID = :id');
                $this->db->bind(':id', $id);
                $lab = $this->db->singleRow();
                return $lab;
            } else{
                return false;
            }
        }
        
        public function decline_pharmacist($id){
            $this->db->query('SELECT First_Name, Last_Name FROM hospital_staff WHERE HS_ID = :id');
            $this->db->bind(':id', $id);

            $pharm = $this->db->singleRow();

            $this->db->query('DELETE FROM hospital_staff WHERE HS_ID = :id');

            $this->db->bind(':id', $id);

            // Execute query
            if($this->db->execute()){
                return $pharm;
            } else{
                return false;
            }
        }

        public function decline_lab($id){
            $this->db->query('SELECT First_Name, Last_Name FROM hospital_staff WHERE HS_ID = :id');
            $this->db->bind(':id', $id);

            $lab = $this->db->singleRow();

            $this->db->query('DELETE FROM hospital_staff WHERE HS_ID = :id');

            $this->db->bind(':id', $id);

            // Execute query
            if($this->db->execute()){
                return $lab;
            } else{
                return false;
            }
        }

        public function get_pending_labs($hospital_id){
            $this->db->query('SELECT * FROM hospital_staff WHERE Hospital_ID = :hospital_id AND Approval = 0 AND Role = "Lab Assistant"');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $labs = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $labs;
            } else{
                return false;
            }
        }

        public function get_pending_pharmacists($hospital_id){
            $this->db->query('SELECT * FROM hospital_staff WHERE Hospital_ID = :hospital_id AND Approval = 0 AND Role = "Pharmacist"');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $pharm = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $pharm;
            } else{
                return false;
            }
        }

        public function get_schedule_hospital($hospital_id){
            $this->db->query('SELECT schedule.*, doctor.First_Name, doctor.Last_Name, doctor.Specialization, room.Room_Name FROM schedule
            INNER JOIN doctor ON schedule.Doctor_ID = doctor.Doctor_ID
            INNER JOIN room ON schedule.Room_ID = room.Room_ID
            WHERE schedule.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $schedules = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $schedules;
            } else{
                return false;
            }   
        }

        public function get_all_doctors(){
            $this->db->query('SELECT * FROM doctor WHERE Approval = 1');

            $doctors = $this->db->resultSet();

            if($this->db->execute()){
                return $doctors;
            } else{
                return false;
            }
        }

        public function get_rooms_hospital($hospital_id){
            $this->db->query('SELECT * FROM room WHERE Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $rooms = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $rooms;
            } else{
                return false;
            }   
        }

        public function doctor_schedule_hospital($doctor_id){
            $this->db->query('SELECT * FROM schedule WHERE Doctor_ID = :doctor_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':doctor_id', $doctor_id);
            $schedules = $this->db->resultSet();

            if($this->db->execute()){
                return $schedules;
            } else{
                return false;
            }
        }

        public function get_schedule_by_hospital_room($hospital_id, $room_id){
            $this->db->query('SELECT * FROM schedule WHERE Hospital_ID = :hospital_id AND Room_ID = :room_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $this->db->bind(':room_id', $room_id);
            $schedule = $this->db->resultSet();

            if($this->db->execute()){
                return $schedule;
            } else{
                return false;
            }
        }

        public function add_schedule($data){
            $this->db->query('INSERT INTO schedule (Doctor_ID, Hospital_ID, Room_ID, Day_of_Week, Time_Start, Time_End) VALUES (:doctor_id, :hospital_id, :room_id, :day, :start, :end)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':doctor_id', $data['Doctor_ID']);
            $this->db->bind(':hospital_id', $data['Hospital_ID']);
            $this->db->bind(':room_id', $data['Room_ID']);
            $this->db->bind(':day', $data['Day']);
            $this->db->bind(':start', $data['Time_Start']);
            $this->db->bind(':end', $data['Time_End']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function get_schedule($schedule_id){
            $this->db->query('SELECT schedule.*, doctor.First_Name, doctor.Last_Name, room.Room_Name FROM schedule 
            INNER JOIN doctor ON schedule.Doctor_ID = doctor.Doctor_ID
            INNER JOIN room ON schedule.Room_ID = room.Room_ID
            WHERE Schedule_ID = :schedule_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':schedule_id', $schedule_id);
            $schedule = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $schedule;
            } else{
                return false;
            }
        }

        public function edit_schedule($data){
            $this->db->query('UPDATE schedule SET Room_ID = :room_id, Day_of_Week = :day, Time_Start = :start, Time_End = :end WHERE Schedule_ID = :schedule_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':room_id', $data['Room_ID']);
            $this->db->bind(':day', $data['Day']);
            $this->db->bind(':start', $data['Time_Start']);
            $this->db->bind(':end', $data['Time_End']);
            $this->db->bind(':schedule_id', $data['Schedule_ID']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function get_appointments_schedule_hospital($schedule_id, $hospital_id){
            $this->db->query('SELECT doctor_reservation.Appointment_No FROM doctor_reservation 
            Inner JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            WHERE schedule.Schedule_ID = :schedule_id AND doctor_reservation.Date >= CURDATE() AND doctor_reservation.Status = "Pending" AND schedule.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':schedule_id', $schedule_id);
            $this->db->bind(':hospital_id', $hospital_id);
            $appointments = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $appointments;
            } else{
                return false;
            }
        }

        public function remove_schedule($schedule_id){
            $this->db->query('DELETE FROM schedule WHERE Schedule_ID = :schedule_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':schedule_id', $schedule_id);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function get_room_hospital($hospital_id){
            $this->db->query('SELECT * FROM room 
            INNER JOIN hospital ON room.Hospital_ID = hospital.Hospital_ID
            WHERE room.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $rooms = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $rooms;
            } else{
                return false;
            }   
        }

        public function add_room($data){
            $this->db->query('INSERT INTO room (Room_Name, Hospital_ID) VALUES (:room_name, :hospital_id)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':room_name', $data['Room_Name']);
            $this->db->bind(':hospital_id', $data['Hospital_ID']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function remove_room($room_id, $hospital_id){
            $this->db->query('DELETE FROM room WHERE Room_ID = :room_id AND Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':room_id', $room_id);
            $this->db->bind(':hospital_id', $hospital_id);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function get_doctor_hospital($hospital_id){
            $this->db->query('SELECT DISTINCT doctor.* FROM doctor 
            INNER JOIN schedule ON schedule.Doctor_ID = doctor.Doctor_ID
            INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
            WHERE schedule.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $doctors = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $doctors;
            } else{
                return false;
            }   
        }

        public function add_doctor($data){
            $this->db->query('INSERT INTO doctor (First_Name, Last_Name, Gender, NIC, Contact_No, SLMC_Reg_No, Specialization, Approval, Charges, Username, Password) VALUES (:F_name, :L_name, :Gender, :NIC, :C_num, :SLMC, :Spec, :Approval, :Charges, :Uname, :Pass)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['F_name']);
            $this->db->bind(':L_name', $data['L_name']);
            $this->db->bind(':Gender', $data['Gender']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_num']);
            $this->db->bind(':SLMC', $data['SLMC']);
            $this->db->bind(':Spec', $data['Spec']);
            $this->db->bind(':Approval', 0);
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

        public function remove_doctor($doctor_id, $hospital_id){
            $this->db->query('DELETE FROM doctor WHERE Doctor_ID = :doctor_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':doctor_id', $doctor_id);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function get_appointments_doctor_hospital($doctor_id, $hospital_id){
            $this->db->query('SELECT doctor_reservation.Doc_Res_ID FROM doctor_reservation 
            Inner JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            WHERE schedule.Doctor_ID = :doctor_id AND doctor_reservation.Date >= CURDATE() AND doctor_reservation.Status = "Pending" AND schedule.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':doctor_id', $doctor_id);
            $this->db->bind(':hospital_id', $hospital_id);
            $appointments = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $appointments;
            } else{
                return false;
            }
        }

        public function get_appointments_room_hospital($room_id, $hospital_id){
            $this->db->query('SELECT doctor_reservation.Appointment_No FROM doctor_reservation 
            Inner JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            WHERE schedule.Room_ID = :room_id AND doctor_reservation.Date >= CURDATE() AND doctor_reservation.Status = "Pending" AND schedule.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':room_id', $room_id);
            $this->db->bind(':hospital_id', $hospital_id);
            $appointments = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $appointments;
            } else{
                return false;
            }
        }

        public function get_patients($hospital_id){
            $this->db->query('SELECT DISTINCT patient.Patient_ID, patient.First_Name, patient.Last_Name, NIC FROM patient
            INNER JOIN doctor_reservation ON patient.Patient_ID = doctor_reservation.Patient_ID 
            INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
            WHERE hospital.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $doc_patients = $this->db->resultSet();

            $this->db->query('SELECT DISTINCT patient.Patient_ID, patient.First_Name, patient.Last_Name, NIC FROM patient INNER JOIN test_reservation ON patient.Patient_ID = test_reservation.Patient_ID
            INNER JOIN hospital_test ON test_reservation.Test_ID = hospital_test.Test_ID
            WHERE hospital_test.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            $test_patients = $this->db->resultSet();

            $row['doc_patients'] = $doc_patients;
            $row['test_patients'] = $test_patients;

            // Execute query
            if($this->db->execute()){
                return $row;
            } else{
                return false;
            }   
        }

        public function get_doctors($hospital_id){
            $this->db->query('SELECT DISTINCT doctor.Doctor_ID, doctor.First_Name, doctor.Last_Name, Specialization FROM doctor 
            INNER JOIN schedule ON doctor.Doctor_ID = schedule.Doctor_ID
            INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
            WHERE hospital.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            // Execute the query and fetch the count
            $doctor_count = $this->db->resultSet();

            // Execute query
            if($this->db->execute()){
                return $doctor_count;
            } else{
                return false;
            }   
        }

        public function get_statistic($hospital_id){
            $this->db->query('SELECT doctor_reservation.Date as doc_res_date FROM doctor_reservation 
            INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
            WHERE hospital.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            // Execute the query and fetch the count
            $doc_res = $this->db->resultSet();

            $this->db->query('SELECT test_reservation.Date as test_res_date FROM test_reservation 
            INNER JOIN hospital_test ON test_reservation.Test_ID = hospital_test.Test_ID
            WHERE hospital_test.Hospital_ID = :hospital_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':hospital_id', $hospital_id);
            // Execute the query and fetch the count
            $test_res = $this->db->resultSet();

            $row['doc_res_date'] = $doc_res;
            $row['test_res_date'] = $test_res;

            // Execute query
            if($this->db->execute()){
                return $row;
            } else{
                return false;
            }   
        }

        
    }


    