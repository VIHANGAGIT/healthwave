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

        public function add_hospital($data){
            $this->db->query('INSERT INTO hospital (Hospital_Name, Address, Region, Charge, Mng_ID, Contact_No) VALUES (:H_name, :H_address, :Region, :H_charge, :M_ID, :C_num)');

            // Binding parameters for the prepaired statement
            $this->db->bind(':H_name', $data['H_name']);
            $this->db->bind(':H_address', $data['H_address']);
            $this->db->bind(':Region', $data['Region']);
            $this->db->bind(':H_charge', $data['H_charge']);
            $this->db->bind(':M_ID', $data['M_ID']);
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
            $this->db->query('UPDATE hospital SET Hospital_Name = :H_name, Address = :H_address, Region = :Region, Charge = :H_charge, Mng_ID = :M_ID, Contact_No = :C_num WHERE Hospital_ID = :H_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':H_name', $data['H_name']);
            $this->db->bind(':H_address', $data['H_address']);
            $this->db->bind(':Region', $data['Region']);
            $this->db->bind(':H_charge', $data['H_charge']);
            $this->db->bind(':M_ID', $data['M_ID']);
            $this->db->bind(':H_ID', $data['H_ID']);
            $this->db->bind(':C_num', $data['C_num']);

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

        public function findHospitalByName()
        {
            $this->db->query('SELECT Hospital_Name FROM hospital WHERE Hospital_Name = :H_name');
            $this->db->bind(':H_name', $_POST['hname']);
            $row = $this->db->singleRow();

            if($this->db->rowCount() > 0){
                return true;
            } else{
                return false;
            }
        }
    }        