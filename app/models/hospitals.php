<?php 
class Hospitals{
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function getAllHospitals(){
        $this->db->query('SELECT * FROM hospital');

        $hospitals = $this->db->resultSet(); // Fetches multiple rows

        return $hospitals;
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

    public function findHospitalByName($name){
        $this->db->query('SELECT * FROM hospital WHERE Hospital_Name = :name');

        // Binding parameters for the prepaired statement
        $this->db->bind(':name', $name);
        $hospital = $this->db->singleRow();

        // Execute query
        if($this->db->execute()){
            return $hospital;
        } else{
            return false;
        }
    }

    public function findHospitalByAddress($address){
        $this->db->query('SELECT * FROM hospital WHERE Address = :address');

        // Binding parameters for the prepaired statement
        $this->db->bind(':address', $address);
        $hospital = $this->db->singleRow();

        // Execute query
        if($this->db->execute()){
            return $hospital;
        } else{
            return false;
        }
    }

    public function search_hospitals($name, $id, $region){

        $this->db->query('SELECT * FROM hospital WHERE Hospital_Name LIKE :hospitalName AND Hospital_ID LIKE :hospitalId AND Region LIKE :region');

        $hospitalName = ($name == null) ? "%" : "%" . $name . "%"; // Do not include === here since it doesnt work sometimes
        $region = ($region == null) ? "%" :$region;
        $hospitalId = ($id == null) ? "%" : "%" . $id . "%"; // Do not include === here  since it doesnt work sometimes

        // Binding parameters for the prepaired statement
        $this->db->bind(':hospitalName', $hospitalName);
        $this->db->bind(':hospitalId', $hospitalId);
        $this->db->bind(':region', $region);

        $hospitals = $this->db->resultSet();

        // Execute query
        if($this->db->execute()){
            return $hospitals;
        } else{
            return false;
        }
    }


}