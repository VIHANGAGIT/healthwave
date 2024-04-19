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

    public function test_schedule_hospital($id){
        $this->db->query('SELECT DISTINCT hospital_test.Hospital_ID, hospital.Hospital_Name, hospital_test.Price FROM hospital_test
        INNER JOIN hospital ON hospital_test.Hospital_ID = hospital.Hospital_ID
        WHERE hospital_test.Test_ID = :id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':id', $id);
        $hospitals = $this->db->resultSet();
        
        if($this->db->execute()){
            return $hospitals;
        } else{
            return false;
        }
    }

    public function get_prices($test_id, $hospital_id){
        $this->db->query('SELECT Price FROM hospital_test WHERE Test_ID = :test_id AND Hospital_ID = :hospital_id');

        $this->db->bind(':test_id', $test_id);
        $this->db->bind(':hospital_id', $hospital_id);
        $price = $this->db->singleRow();
        
        if($this->db->execute()){
            return $price;
        } else{
            return false;
        }

    }

    public function fetch_booked_slots($hospital_id, $date){
        $this->db->query('SELECT Start_Time, End_Time FROM test_reservation WHERE Hospital_ID = :hospital_id AND Date = :date');

        $this->db->bind(':hospital_id', $hospital_id);
        $this->db->bind(':date', $date);
        $booked_slots = $this->db->resultSet();

        foreach($booked_slots as $slot){
            $slot->Start_Time = date('h:i', strtotime($slot->Start_Time));
            $slot->End_Time = date('h:i', strtotime($slot->End_Time));
        }

        if($this->db->execute()){
            return $booked_slots;
        } else{
            return false;
        }
    }

    public function test_data_fetch($id){
        $this->db->query('SELECT * FROM test WHERE Test_ID = :id');

        // Binding parameters for the prepaired statement
        $this->db->bind(':id', $id);
        $testRow = $this->db->singleRow();

        // Execute query
        if($this->db->execute()){
            return $testRow;
        } else{
            return false;
        }
    }

    public function add_reservation($data){
        $this->db->query('INSERT INTO payment (Bill_Amount, Payment_Method) VALUES (:Bill_Amount, :Payment_Method)');

        $this->db->bind(':Bill_Amount', $data['Total_Price']);
        $this->db->bind(':Payment_Method', "Online");
        $this->db->execute();


        $this->db->query('SELECT * FROM payment ORDER BY Payment_ID DESC LIMIT 1;');
        $lastRow = $this->db->singleRow();
        $payment_id = $lastRow->Payment_ID;

        $this->db->query('INSERT INTO test_reservation (Patient_ID, Hospital_ID, Test_ID, Payment_ID, Date, Start_Time, End_Time, Contact_Number, Email) VALUES (:Patient_ID, :Hospital_ID, :Test_ID, :Payment_ID, :Date, :Start_Time, :End_Time, :Contact_Number, :Email)');
        // Binding parameters for the prepaired statement
        $this->db->bind(':Patient_ID', $data['Patient_ID']);
        $this->db->bind(':Hospital_ID', $data['Hospital_ID']);
        $this->db->bind(':Test_ID', $data['Test_ID']);
        $this->db->bind(':Payment_ID', $payment_id);
        $this->db->bind(':Date', $data['Selected_Date']);
        $this->db->bind(':Start_Time', $data['Start_Time']);
        $this->db->bind(':End_Time', $data['End_Time']);
        $this->db->bind(':Contact_Number', $data['Contact_No']);
        $this->db->bind(':Email', $data['Email']);

        // Execute query
        if($this->db->execute()){
            return true;
        } else{
            return false;
        }
    }
}