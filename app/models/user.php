<?php 
    class User{
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }


        //------------------------------ Register Functions ------------------------------------//


        public function register_patient($data){
            $this->db->query('INSERT INTO patient (First_Name, Last_Name, Gender, NIC, Contact_No, DOB, Age, Height, Weight, Blood_Group, Allergies, Approval, Username, Password) VALUES (:F_name, :L_name, :Gender, :NIC, :C_num, :DOB, :Age, :Height, :Weight, :B_group, :Allergies, :Approval, :Uname, :Pass)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['F_name']);
            $this->db->bind(':L_name', $data['L_name']);
            $this->db->bind(':Gender', $data['Gender']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_num']);
            $this->db->bind(':DOB', $data['DOB']);
            $this->db->bind(':Age', $data['Age']);
            $this->db->bind(':Height', $data['Height']);
            $this->db->bind(':Weight', $data['Weight']);
            $this->db->bind(':B_group', $data['B_group']);
            $this->db->bind(':Allergies', $data['Allergies']);
            $this->db->bind(':Approval', 1);
            $this->db->bind(':Uname', $data['Uname']);
            $this->db->bind(':Pass', $data['Pass']);

            // Execute query
            if($this->db->execute()){
                $this->closeDatabaseConnection();
                return true;
            } else{
                $this->closeDatabaseConnection();
                return false;
            }
        }

        public function register_doctor($data){
            $this->db->query('INSERT INTO doctor (First_Name, Last_Name, Gender, NIC, Contact_No, SLMC_Reg_No, Specialization, Charges, Approval, Username, Password) VALUES (:F_name, :L_name, :Gender, :NIC, :C_num, :SLMC, :Spec, :Charges, :Approval, :Uname, :Pass)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['F_name']);
            $this->db->bind(':L_name', $data['L_name']);
            $this->db->bind(':Gender', $data['Gender']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_num']);
            $this->db->bind(':SLMC', $data['SLMC']);
            $this->db->bind(':Spec', $data['Spec']);
            $this->db->bind(':Charges', $data['Charges']);
            $this->db->bind(':Approval', $data['Approval']);
            $this->db->bind(':Uname', $data['Uname']);
            $this->db->bind(':Pass', $data['Pass']);

            // Execute query
            if($this->db->execute()){
                $this->closeDatabaseConnection();
                return true;
            } else{
                $this->closeDatabaseConnection();
                return false;
            }
        }

        public function register_hospital_staff($data){
            $this->db->query('INSERT INTO hospital_staff (First_Name, Last_Name, Gender, NIC, Contact_No, Hospital_ID, Role, Approval, Username, Password) VALUES (:F_name, :L_name, :Gender, :NIC, :C_num, :Hospital, :Role, :Approval, :Uname, :Pass)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['F_name']);
            $this->db->bind(':L_name', $data['L_name']);
            $this->db->bind(':Gender', $data['Gender']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_num']);
            $this->db->bind(':Hospital', $data['Hospital']);
            $this->db->bind(':Role', $data['Role']);
            $this->db->bind(':Approval', 0);
            $this->db->bind(':Uname', $data['Uname']);
            $this->db->bind(':Pass', $data['Pass']);

            // Execute query
            if($this->db->execute()){
                $this->closeDatabaseConnection();
                return true;
            } else{
                $this->closeDatabaseConnection();
                return false;
            }
        }

        // Login user
        public function login($uname, $pass){
            $this->db->query('SELECT * FROM patient WHERE Username = :uname');
            $this->db->bind(':uname', $uname);
            $userRow = $this->db->singleRow();
            $role = 'Patient';

            if (!$userRow) {
                $this->db->query('SELECT * FROM doctor WHERE Username = :uname');
                $this->db->bind(':uname', $uname);
                $userRow = $this->db->singleRow();
                $role = 'Doctor';

                if (!$userRow) {
                    $this->db->query('SELECT * FROM admin WHERE Username = :uname');
                    $this->db->bind(':uname', $uname);
                    $userRow = $this->db->singleRow();
                    $role = 'Admin';

                    if (!$userRow) {
                        $this->db->query('SELECT * FROM hospital_staff WHERE Username = :uname');
                        $this->db->bind(':uname', $uname);
                        $userRow = $this->db->singleRow();
                        $role = $userRow->Role;
                    }
                }
            }

            

            // Create another array to include both user data and role
            $result = [
                'userRow' => $userRow,
                'role' => $role,
            ];
            
            // Get password from db
            $db_pass = $userRow->Password;

            // Get password from login and hash it
            $hashed_pass = hash('sha256',$pass);

            // Check whether db and hashed passwords match
            if($db_pass == $hashed_pass){
                return $result;
            } else {
                return false;
            }

            
        }   

        // Check for duplicate Username entries
        public function findUserByUname($uname){
            $this->db->query('SELECT Username, Approval FROM patient WHERE Username = :uname UNION SELECT Username, Approval FROM doctor WHERE Username = :uname UNION SELECT Username, Approval FROM admin WHERE Username = :uname UNION SELECT Username, Approval FROM hospital_staff WHERE Username = :uname');
            
             // Binding parameters for the prepaired statement
            $this->db->bind(':uname', $uname);

            $row = $this->db->singleRow();

            if($this->db->rowCount() > 0){
                return $row;
            } else{
                return false;
            }
        }

        //------------------------------ Patient Functions ------------------------------------//

        public function patient_data_fetch($id){
            $this->db->query('SELECT * FROM patient WHERE Patient_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);
            $patientRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $patientRow;
            } else{
                return false;
            }
        }

        public function patient_profile_update($data){
            $this->db->query('UPDATE patient SET First_Name = :F_name, Last_Name = :L_name, NIC = :NIC, Contact_No = :C_num, Age = :Age, Height = :Height, Weight = :Weight, Allergies = :Allergies, Username = :Uname, Password = :Pass WHERE Patient_ID = :Patient_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['First_Name']);
            $this->db->bind(':L_name', $data['Last_Name']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_Num']);
            $this->db->bind(':Age', $data['Age']);
            $this->db->bind(':Height', $data['Height']);
            $this->db->bind(':Weight', $data['Weight']);
            $this->db->bind(':Allergies', $data['Allergies']);
            $this->db->bind(':Uname', $data['Uname']);
            $this->db->bind(':Pass', $data['Pass']);
            $this->db->bind(':Patient_ID', $data['ID']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function patient_profile_delete($id){
            $this->db->query('DELETE FROM patient WHERE Patient_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);

            // Execute query
            if($this->db->execute()){
                $this->closeDatabaseConnection();
                return true;
            } else{
                $this->closeDatabaseConnection();
                return false;
            }
        }

        //------------------------------ Doctor Functions ------------------------------------//

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

        

        public function doctor_profile_delete($id){
            $this->db->query('DELETE FROM doctor WHERE Doctor_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);

            // Execute query
            if($this->db->execute()){
                $this->closeDatabaseConnection();
                return true;
            } else{
                $this->closeDatabaseConnection();
                return false;
            }
        }

        //------------------------------ Hospital Functions ------------------------------------//

        public function getHospitalNames() {
            $this->db->query('SELECT Hospital_ID, Hospital_Name FROM hospital');
        
            // Execute query
            $this->db->execute();
        
            // Fetch all rows as associative array
            $hospitalNames = $this->db->resultSet();
        
            // Check if there are results
            if($this->db->execute()){
                return $hospitalNames;
            } else{
                return false;
            }
        }

        public function hospital_staff_data_fetch($id){
            $this->db->query('SELECT hospital_staff.*, hospital.Hospital_Name FROM hospital_staff 
            INNER JOIN hospital ON hospital_staff.Hospital_ID = hospital.Hospital_ID
            WHERE HS_ID = :id');

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

        public function hospital_staff_profile_update($data){
            $this->db->query('UPDATE hospital_staff SET Contact_No = :C_num, Username = :Uname, Password = :Pass WHERE HS_ID = :HS_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':C_num', $data['C_Num']);
            $this->db->bind(':Uname', $data['Username']);
            $this->db->bind(':Pass', $data['Pass']);
            $this->db->bind(':HS_ID', $data['ID']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function get_prescription_code(){
            $this->db->query('SELECT Prescription_ID, Diagnosis FROM prescription');
            $prescription_code = $this->db->resultSet();

            if($this->db->execute()){
                return $prescription_code;
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
        
        
        private function closeDatabaseConnection()
        {
            $this->db->closeConnection();
        }
        /*public function getUsers(){
            $this->db->query("SELECT * FROM user");

            return $this->db->resultSet();
        }*/
    }