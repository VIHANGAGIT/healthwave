<?php 
    class Labs{
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }

        /*public function hospital_staff_data_fetch($id){
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
        }*/

        /*public function lab_data_fetch($id){
            SELECT test.*, hospital_test.Price 
            FROM hospital_test 
            INNER JOIN test ON hospital_test.Test_ID = test.ID 
            WHERE hospital_test.hospital_ID = 'donet';
        
            // Binding parameters for the prepared statement
            $this->db->bind(':id', $id);
            $testRows = $this->db->resultSet();
        
            // Execute query
            if($this->db->execute()){
                return $testRows; 
            } else{
                return false;
            }
        }*/

        public function lab_data_fetch($id) {
            // Prepare SQL query
            $this->db->query( "SELECT Hospital_ID FROM hospital_staff WHERE HS_ID = :id");

            // Binding parameters for the prepared statement
            $this->db->bind(':id', $id);

            // Execute query
            $hospitalRow = $this->db->singleRow();


            $this->db->query ('SELECT test.*, hospital_test.Price 
                      FROM test 
                      INNER JOIN hospital_test ON hospital_test.Test_ID = test.Test_ID 
                      INNER JOIN hospital_staff ON hospital_staff.Hospital_ID = hospital_test.Hospital_ID 
                      WHERE hospital_test.Hospital_ID = :id AND hospital_staff.HS_ID = :hs_id');
        
           
        
            // Binding parameters for the prepared statement
            $this->db->bind(':id', $hospitalRow->Hospital_ID);
            $this->db->bind(':hs_id', $id);
        
            // Execute query
            $testRows = $this->db->resultSet();
        
            // Check if query executed successfully
            if($testRows) {
                return $testRows; 
            } else {
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