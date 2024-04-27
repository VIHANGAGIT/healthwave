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
            WHERE Test_ID = :test_id AND Date >= CURDATE() AND End_Time >= CURTIME() AND Status = "Pending" AND Hospital_ID = :hospital_id');

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

        public function add_lab_test($data) {
            // First, insert data into the 'test' table
            $this->db->query('INSERT INTO test (Test_Name, Type) VALUES (:Test_Name, :Type)');
            $this->db->bind(':Test_Name', $data['Test_Name']);
            $this->db->bind(':Type', $data['Type']);
            
            // Execute the first query
            if (!$this->db->execute()) {
                // Return false if the first query fails
                return false;
            }
            
            // Get the ID of the inserted test from the 'test' table
            $test_id = $this->db->lastInsertId();
            
            // Now, insert data into the 'hospital_test' table
            $this->db->query('INSERT INTO hospital_test (Test_ID, Hospital_ID, Price) VALUES (:Test_ID, :Hospital_ID, :Price)');
            $this->db->bind(':Test_ID', $test_id); // Use the ID of the inserted test
            $this->db->bind(':Hospital_ID', $data['Hospital_ID']);
            $this->db->bind(':Price', $data['Price']);
            
            // Execute the second query
            if ($this->db->execute()) {
                // Return true if both queries are successful
                return true;
            } else {
                // Roll back the first query if the second query fails
                $this->db->query('DELETE FROM test WHERE Test_ID = :Test_ID');
                $this->db->bind(':Test_ID', $test_id);
                $this->db->execute();
                
                return false;
            }
        }
        

        
        



        
        
        
    }


    