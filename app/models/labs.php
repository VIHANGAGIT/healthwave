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

        /*public function add_lab_test($data) {
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
        }*/

        /*// Model function to add new lab test
        public function add_lab_test($data) {

            // Prepare SQL query
            $this->db->query( "SELECT Hospital_ID FROM hospital_staff WHERE HS_ID = :id");

            // Binding parameters for the prepared statement
            $this->db->bind(':id', $id);

            // Execute query
            $hospitalRow = $this->db->singleRow();

            // Prepare SQL query
            $this->db->query("INSERT INTO test (Test_Name, Test_Type) VALUES (:T_name, :T_type)");
            
            // Bind parameters
            $this->db->bind(':T_name', $data['T_name']);
            $this->db->bind(':T_type', $data['T_type']);
            
            // Execute query
            if (!$this->db->execute()) {
                return false;
            }

            // Get the ID of the newly inserted test
            $test_id = $this->db->lastInsertId();

            // Prepare SQL query to insert into hospital_test table
            $this->db->query("INSERT INTO hospital_test (Test_ID, Hospital_ID, Price) VALUES (:T_id, :hospital_id, :Price)");
            
            // Bind parameters
            $this->db->bind(':T_id', $T_id);
            $this->db->bind(':Hospital_ID', $data['Hospital_ID']);
            $this->db->bind(':Price', $data['Price']);
            
            // Execute query
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }*/

        public function add_lab_test($data) {
            // Prepare SQL query to get hospital ID
            $this->db->query("SELECT Hospital_ID FROM hospital_staff WHERE HS_ID = :id");
            $this->db->bind(':id', $data['ID']);
            $hospitalRow = $this->db->singleRow();
            $hospital_id = $hospitalRow->Hospital_ID;
        
            // Prepare SQL query to insert test
            $this->db->query("INSERT INTO test (Test_Name, Test_Type) VALUES (:T_name, :T_type)");
            $this->db->bind(':T_name', $data['T_name']);
            $this->db->bind(':T_type', $data['T_type']);
            if (!$this->db->execute()) {
                return false;
            }
            $test_id = $this->db->lastInsertId();
        
            // Prepare SQL query to insert into hospital_test table
            $this->db->query("INSERT INTO hospital_test (Test_ID, Hospital_ID, Price) VALUES (:T_id, :hospital_id, :Price)");
            $this->db->bind(':T_id', $test_id);
            $this->db->bind(':hospital_id', $hospital_id);
            $this->db->bind(':Price', $data['Price']);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        
        public function lab_profile_delete($id){
            $this->db->query('DELETE FROM hospital_staff WHERE HS_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function reservation_data_fetch($id) {
            // Prepare SQL query
            $this->db->query( "SELECT Hospital_ID FROM hospital_staff WHERE HS_ID = :id");

            // Binding parameters for the prepared statement
            $this->db->bind(':id', $id);

            // Execute query
            $hospitalRow = $this->db->singleRow();

            $this->db->query ('SELECT test_reservation.Patient_ID, test_reservation.Date, patient.First_Name , patient.Last_Name
                            FROM test_reservation
                            INNER JOIN patient ON test_reservation.Patient_ID = patient.Patient_ID 
                            INNER JOIN hospital_staff ON hospital_staff.Hospital_ID = test_reservation.Hospital_ID 
                            WHERE test_reservation.Hospital_ID = :hospital_id AND hospital_staff.HS_ID = :hs_id AND test_reservation.Date >= CURDATE()
                            GROUP BY 
                            test_reservation.Patient_ID, 
                            test_reservation.Date');
        
            // Binding parameters for the prepared statement
            $this->db->bind(':hospital_id', $hospitalRow->Hospital_ID);
            $this->db->bind(':hs_id', $id);
        
            // Execute query
            $reservationRows = $this->db->resultSet();
        
            // Check if query executed successfully
            if($reservationRows) {
                return $reservationRows; 
            } else {
                return false;
            }
        }

        public function reservation_date_data_fetch($id, $patient_id, $date) {
            // Prepare SQL query
            $this->db->query("SELECT Hospital_ID FROM hospital_staff WHERE HS_ID = :id");
        
            // Binding parameters for the prepared statement
            $this->db->bind(':id', $id);
        
            // Execute query
            $hospitalRow = $this->db->singleRow();
        
            // Prepare and execute the main query
            $this->db->query('SELECT test_reservation.Test_Res_ID, test_reservation.Start_Time, test_reservation.End_Time, test.Test_Name, test.Test_Type, hospital_test.Price
                                FROM test_reservation
                                INNER JOIN patient ON test_reservation.Patient_ID = patient.Patient_ID 
                                INNER JOIN hospital_staff ON hospital_staff.Hospital_ID = test_reservation.Hospital_ID 
                                INNER JOIN test ON test.Test_ID = test_reservation.Test_ID
                                INNER JOIN hospital_test ON hospital_test.Test_ID = test.Test_ID
                                WHERE test_reservation.Hospital_ID = :hospital_id 
                                AND hospital_staff.HS_ID = :hs_id 
                                AND test_reservation.Date = :date 
                                AND test_reservation.Patient_ID = :patient_id
                                AND hospital_test.Hospital_ID = :hospital_id
                                GROUP BY 
                                test_reservation.Test_Res_ID, 
                                test.Test_Name, 
                                test.Test_Type, 
                                hospital_test.Price');
        
            // Binding parameters for the prepared statement
            $this->db->bind(':hospital_id', $hospitalRow->Hospital_ID);
            $this->db->bind(':hs_id', $id);
            $this->db->bind(':date', $date);
            $this->db->bind(':patient_id', $patient_id);
        
            // Execute query
            $reservationRows = $this->db->resultSet();
        
            // Check if query executed successfully
            if ($reservationRows) {
                return $reservationRows;
            } else {
                return false;
            }
        }
        

        
}
    