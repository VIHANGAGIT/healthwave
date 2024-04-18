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
    
    public function getReservations($id){
                
        $this->db->query('SELECT * FROM schedule WHERE Doctor_ID = :id');
        $this->db->bind(':id', $id);

        // Fetch all the rows from the result set
        $reservations = $this->db->resultSet();

        // Check if any rows were returned
        if ($this->db->rowCount() > 0) {
            return $reservations;
        } else {
            return false;
        }
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