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

        // Check for duplicate Username entries
        public function findUserByUname($uname){
            $this->db->query('SELECT Username FROM patient WHERE Username = :Uname UNION SELECT Username FROM doctor WHERE Username = :Uname');
            
             // Binding parameters for the prepaired statement
            $this->db->bind(':Uname', $uname);

            $row = $this->db->singleRow();

            if($this->db->rowCount() > 0){
                return true;
            } else{
                return false;
            }
        }

        /*public function getUsers(){
            $this->db->query("SELECT * FROM user");

            return $this->db->resultSet();
        }*/
    }