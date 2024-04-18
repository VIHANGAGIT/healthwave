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

    public function get_no_of_hospitals($id){
        $this->db->query('SELECT COUNT(DISTINCT Hospital_ID) AS NoOfHospitals FROM schedule WHERE Doctor_ID = :id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':id', $id);
        $noOfHospitals = $this->db->singleRow();

        // Execute query
        if($this->db->execute()){
            return $noOfHospitals;
        } else{
            return false;
        }
    }

    public function search_doctors($doctorId, $hospitalId, $specialization){
        if($hospitalId === null){
            $this->db->query('SELECT doctor.* FROM doctor
            WHERE doctor.Doctor_ID LIKE :doctorId AND doctor.Specialization LIKE :specialization');

            $this->db->bind(':doctorId', $doctorId === null ? '%' : $doctorId);
            $this->db->bind(':specialization', $specialization === null ? '%' : $specialization);

        }else{
            $this->db->query('SELECT DISTINCT doctor.* FROM doctor
            INNER JOIN schedule ON doctor.Doctor_ID = schedule.Doctor_ID
            WHERE schedule.Doctor_ID LIKE :doctorId AND doctor.Specialization LIKE :specialization AND schedule.Hospital_ID = :hospitalId');
            
            $this->db->bind(':doctorId', $doctorId === null ? '%' : $doctorId);
            $this->db->bind(':specialization', $specialization === null ? '%' : $specialization);
            $this->db->bind(':hospitalId', $hospitalId === null ? '%' : $hospitalId);
        }


        $doctors = $this->db->resultSet();
        if($this->db->execute()){
            return $doctors;
        } else{
            return false;
        }
        
    }


}