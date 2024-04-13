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

    public function doctor_data_fetch($id){
        $this->db->query('SELECT * FROM doctor WHERE Doctor_ID = :id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':id', $id);
        $doctorRow = $this->db->singleRow();

        // Execute query
        if($this->db->execute()){
            return $doctorRow;
        } else{
            return false;
        }
    }


}