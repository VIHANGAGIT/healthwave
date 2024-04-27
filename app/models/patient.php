<?php 
    class User{
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }


        // Register User
        public function patient_data_fetch($data){
            $this->db->query('SELECT * FROM patient WHERE Username = :uname');

            // Binding parameters for the prepaired statement
            $this->db->bind(':Uname', $data['Uname']);
            $patientRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $patientRow;
            } else{
                return false;
            }
        }
        
    }