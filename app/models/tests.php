<?php 
class Tests{
    private $db;
    
    public function __construct(){
        $this->db = new Database;
    }

    public function get_all_available_tests(){
        $this->db->query('SELECT DISTINCT ht.Test_ID, t.Test_Name, t.Test_Type FROM hospital_test ht
        INNER JOIN test t ON ht.Test_ID = t.Test_ID');

        $tests = $this->db->resultSet(); // Fetches multiple rows

        return $tests;
    }

    public function get_no_of_hospitals($id){
        $this->db->query('SELECT COUNT(DISTINCT Hospital_ID) AS NoOfHospitals FROM hospital_test WHERE Test_ID = :id');

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

    public function search_tests($testId, $hospitalId, $testType){
        $this->db->query('SELECT test.* FROM test
        INNER JOIN hospital_test ON hospital_test.Test_ID = test.Test_ID
        WHERE hospital_test.Test_ID LIKE :testId AND test.Test_Type LIKE :testType AND hospital_test.Hospital_ID = :hospitalId');

        $this->db->bind(':testId', $testId === null ? '%' : $testId);
        $this->db->bind(':testType', $testType === null ? '%' : $testType);
        $this->db->bind(':hospitalId', $hospitalId === null ? '%' : $hospitalId);

        $tests = $this->db->resultSet();
        if($this->db->execute()){
            return $tests;
        } else{
            return false;
        }
        
    }
}