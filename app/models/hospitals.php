<?php 
class Hospitals{
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function getAllHospitals(){
        $this->db->query('SELECT * FROM hospital');

        $hospitals = $this->db->resultSet(); // Assuming resultSet() fetches multiple rows

        return $hospitals;
    }


}