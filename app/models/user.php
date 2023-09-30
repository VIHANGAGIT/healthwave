<?php 
    class User{
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }

        // Check for duplicate Username entries
        public function findUserByUname($uname){
            $this->db->query('SELECT * FROM patient WHERE Username = :Uname');
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