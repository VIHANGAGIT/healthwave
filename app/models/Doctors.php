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

    public function doctor_profile_update($data){
        $this->db->query('UPDATE doctor SET First_Name = :F_name, Last_Name = :L_name, NIC = :NIC, Contact_No = :C_num, Username = :Uname, Password = :Pass WHERE Doctor_ID = :Doctor_ID');

        // Binding parameters for the prepaired statement
        $this->db->bind(':F_name', $data['First_Name']);
        $this->db->bind(':L_name', $data['Last_Name']);
        $this->db->bind(':NIC', $data['NIC']);
        $this->db->bind(':C_num', $data['C_Num']);
        $this->db->bind(':Uname', $data['Email']);
        $this->db->bind(':Pass', $data['Pass']);
        $this->db->bind(':Doctor_ID', $data['ID']);

        // Execute query
        if($this->db->execute()){
            return true;
        } else{
            return false;
        }
    }

    public function doctor_profile_delete($id){
        $this->db->query('DELETE FROM doctor WHERE Doctor_ID = :id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':id', $id);

        // Execute query
        if($this->db->execute()){
            return true;
        } else{
            return false;
        }
    }

}