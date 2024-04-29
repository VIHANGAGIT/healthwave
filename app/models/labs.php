<?php 
    class Labs{
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }

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
                            AND test_reservation.Status = "Pending"
                            GROUP BY test_reservation.Patient_ID, test_reservation.Date ORDER BY test_reservation.Date');
        
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

        public function collected($test_res_id){
            $this->db->query('UPDATE test_reservation SET Status = "Collected" WHERE Test_Res_ID = :test_res_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':test_res_id', $test_res_id);

            // Execute query
            if($this->db->execute()){
                $this->db->query('INSERT INTO test_result (Test_Res_ID, Collected_Date, Collected_Time) VALUES (:test_res_id, CURDATE(), CURTIME())');

                // Binding parameters for the prepaired statement
                $this->db->bind(':test_res_id', $test_res_id);

                // Execute query
                if($this->db->execute()){
                    return true;
                } else{
                    return false;
                }
            } else{
                return false;
            }
        }

        
        public function upload_result($data){
            $this->db->query('UPDATE test_reservation SET Status = "Completed" WHERE Test_Res_ID = :Test_Res_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':Test_Res_ID', $data['Res_ID']);

            // Execute query
            if($this->db->execute()){
                $this->db->query('UPDATE test_result SET Result = :Result WHERE Test_Res_ID = :Test_Res_ID');

                // Binding parameters for the prepaired statement
                $this->db->bind(':Result', $data['file']);
                $this->db->bind(':Test_Res_ID', $data['Res_ID']);

                // Execute query
                if($this->db->execute()){
                    return true;
                } else{
                    return false;
                }
            } else{
                return false;
            }
        }

        public function get_reservation_data($res_id){
            $this->db->query('SELECT test_reservation.Test_ID, test.Test_Name, test.Test_Type, patient.Patient_ID, patient.First_Name, patient.Last_Name FROM test_reservation
            INNER JOIN test ON test_reservation.Test_ID = test.Test_ID
            INNER JOIN patient ON test_reservation.Patient_ID = patient.Patient_ID
            WHERE test_reservation.Test_Res_ID = :res_id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':res_id', $res_id);
            $reservation = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $reservation;
            } else{
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

        public function updateReservationStatus($test_res_id, $new_status, $patient_id, $date) {
            // Prepare and execute SQL query to update status
            $this->db->query('UPDATE test_reservation SET Status = :new_status 
                            WHERE Test_Res_ID = :test_res_id
                            AND test_reservation.Patient_ID = :patient_id
                            AND test_reservation.Date = :date ');

            $this->db->bind(':new_status', $new_status);
            $this->db->bind(':test_res_id', $test_res_id);
            $this->db->bind(':patient_id', $patient_id);
            $this->db->bind(':date', $date);
            
            // Execute query and return the result
            return $this->db->execute();
        }

        public function pending_test_data_fetch($id) {
            // Prepare SQL query
            $this->db->query("SELECT Hospital_ID FROM hospital_staff WHERE HS_ID = :id");
        
            // Binding parameters for the prepared statement
            $this->db->bind(':id', $id);
        
            // Execute query
            $hospitalRow = $this->db->singleRow();
        
            // Prepare and execute the main query
            $this->db->query('SELECT test_reservation.Test_Res_ID,test.Test_Name, test_reservation.Status, patient.First_Name , patient.Last_Name
                                FROM test_reservation
                                INNER JOIN patient ON test_reservation.Patient_ID = patient.Patient_ID 
                                INNER JOIN hospital_staff ON hospital_staff.Hospital_ID = test_reservation.Hospital_ID 
                                INNER JOIN test ON test.Test_ID = test_reservation.Test_ID
                                WHERE test_reservation.Hospital_ID = :hospital_id 
                                AND hospital_staff.HS_ID = :hs_id 
                                AND test_reservation.Status = "Collected"
                                GROUP BY 
                                test_reservation.Test_Res_ID, 
                                test.Test_Name ');
        
            // Binding parameters for the prepared statement
            $this->db->bind(':hospital_id', $hospitalRow->Hospital_ID);
            $this->db->bind(':hs_id', $id);
            //$this->db->bind(':date', $date);
            //$this->db->bind(':patient_id', $patient_id);

        
            // Execute query
            $reservationRows = $this->db->resultSet();
        
            // Check if query executed successfully
            if ($reservationRows) {
                return $reservationRows;
            } else {
                return false;
            }
        }

        public function completed_test_data_fetch($id) {
            // Prepare SQL query
            $this->db->query("SELECT Hospital_ID FROM hospital_staff WHERE HS_ID = :id");
        
            // Binding parameters for the prepared statement
            $this->db->bind(':id', $id);
        
            // Execute query
            $hospitalRow = $this->db->singleRow();
        
            // Prepare and execute the main query
            $this->db->query('SELECT test_reservation.Test_Res_ID,test.Test_Name, test_reservation.Status, test_result.Collected_Date, patient.Patient_ID ,patient.First_Name , patient.Last_Name, test_result.Result
                                FROM test_reservation
                                INNER JOIN patient ON test_reservation.Patient_ID = patient.Patient_ID 
                                INNER JOIN hospital_staff ON hospital_staff.Hospital_ID = test_reservation.Hospital_ID 
                                INNER JOIN test ON test.Test_ID = test_reservation.Test_ID
                                INNER JOIN test_result ON test_reservation.Test_Res_ID = test_result.Test_Res_ID
                                WHERE test_reservation.Hospital_ID = :hospital_id 
                                AND hospital_staff.HS_ID = :hs_id 
                                AND test_reservation.Status = "Completed"
                                GROUP BY 
                                test_reservation.Test_Res_ID, 
                                test.Test_Name ');
        
            // Binding parameters for the prepared statement
            $this->db->bind(':hospital_id', $hospitalRow->Hospital_ID);
            $this->db->bind(':hs_id', $id);
            //$this->db->bind(':date', $date);
            //$this->db->bind(':patient_id', $patient_id);

        
            // Execute query
            $reservationRows = $this->db->resultSet();
        
            // Check if query executed successfully
            if ($reservationRows) {
                return $reservationRows;
            } else {
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

        public function labassistant_labtest_data_fetch($id){
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

    
}
    