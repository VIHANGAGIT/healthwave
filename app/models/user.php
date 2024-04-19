<?php 
    class User{
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }


        // Register User
        public function register_patient($data){
            $this->db->query('INSERT INTO patient (First_Name, Last_Name, Gender, NIC, Contact_No, DOB, Age, Height, Weight, Blood_Group, Allergies, Username, Password) VALUES (:F_name, :L_name, :Gender, :NIC, :C_num, :DOB, :Age, :Height, :Weight, :B_group, :Allergies, :Uname, :Pass)');

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
            $this->db->bind(':Uname', $data['Uname']);
            $this->db->bind(':Pass', $data['Pass']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function register_doctor($data){
            $this->db->query('INSERT INTO doctor (First_Name, Last_Name, Gender, NIC, Contact_No, SLMC_Reg_No, Specialization, Availability, Username, Password) VALUES (:F_name, :L_name, :Gender, :NIC, :C_num, :SLMC, :Spec, :Avail, :Uname, :Pass)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['F_name']);
            $this->db->bind(':L_name', $data['L_name']);
            $this->db->bind(':Gender', $data['Gender']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_num']);
            $this->db->bind(':SLMC', $data['SLMC']);
            $this->db->bind(':Spec', $data['Spec']);
            $this->db->bind(':Avail', $data['Avail']);
            $this->db->bind(':Uname', $data['Uname']);
            $this->db->bind(':Pass', $data['Pass']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function register_hospital_staff($data){
            $this->db->query('INSERT INTO hospital_staff (First_Name, Last_Name, Gender, NIC, Contact_No, Hospital, Role, Username, Password, Employed_Date, Staff_ID) VALUES (:F_name, :L_name, :Gender, :NIC, :C_num, :Hospital, :Role, :Uname, :Pass, :employeddate, :staffid)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['F_name']);
            $this->db->bind(':L_name', $data['L_name']);
            $this->db->bind(':Gender', $data['Gender']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_num']);
            $this->db->bind(':Hospital', $data['Hospital']);
            $this->db->bind(':Role', $data['Role']);
            $this->db->bind(':Uname', $data['Uname']);
            $this->db->bind(':Pass', $data['Pass']);
            $this->db->bind(':employeddate', $data['Employment_Date']);
            $this->db->bind(':staffid', $data['Staff_ID']);
            

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
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
            $this->db->query('SELECT Username FROM patient WHERE Username = :uname UNION SELECT Username FROM doctor WHERE Username = :uname UNION SELECT Username FROM admin WHERE Username = :uname UNION SELECT Username FROM hospital_staff WHERE Username = :uname');
            
             // Binding parameters for the prepaired statement
            $this->db->bind(':uname', $uname);

            $row = $this->db->singleRow();

            if($this->db->rowCount() > 0){
                return true;
            } else{
                return false;
            }
        }

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
                return true;
            } else{
                return false;
            }
        }

        

        public function staff_data_fetch($id){
            $this->db->query('SELECT * FROM hospital_staff WHERE HS_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);
            $managerRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $managerRow;
            } else{
                return false;
            }
        }


        //update hospital manager profile query 
        public function manager_profile_update($data){
            
            $this->db->query('UPDATE hospital_staff SET First_Name = :F_name, Last_Name = :L_name, NIC = :NIC, Contact_No = :C_num, Username = :Uname, Password = :Pass WHERE HS_ID = :HS_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['First_Name']);
            $this->db->bind(':L_name', $data['Last_Name']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['Contact_No']);
            $this->db->bind(':Uname', $data['Username']);
            $this->db->bind(':Pass', $data['Pass']);
            $this->db->bind(':HS_ID', $data['HS_ID']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
            
            
        }

    }