<?php 
class Doctors{
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function getAllDoctors(){
        $this->db->query('SELECT * FROM doctor');

        $doctors = $this->db->resultSet();
        return $doctors;
    }


}