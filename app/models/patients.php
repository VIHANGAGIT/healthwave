<?php 
    class Patients{
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }


        public function patient_data_fetch($id){
            $this->db->query('SELECT * FROM patient WHERE Patient_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);
            $patientRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $patientRow;
            } else{
                return false;
            }
        }

        public function patient_profile_update($data){
            $this->db->query('UPDATE patient SET First_Name = :F_name, Last_Name = :L_name, NIC = :NIC, Contact_No = :C_num, Age = :Age, Height = :Height, Weight = :Weight, Allergies = :Allergies, Username = :Uname, Password = :Pass WHERE Patient_ID = :Patient_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['First_Name']);
            $this->db->bind(':L_name', $data['Last_Name']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_Num']);
            $this->db->bind(':Age', $data['Age']);
            $this->db->bind(':Height', $data['Height']);
            $this->db->bind(':Weight', $data['Weight']);
            $this->db->bind(':Allergies', $data['Allergies']);
            $this->db->bind(':Uname', $data['Uname']);
            $this->db->bind(':Pass', $data['Pass']);
            $this->db->bind(':Patient_ID', $data['ID']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        public function patient_profile_delete($id){
            $this->db->query('DELETE FROM patient WHERE Patient_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);

            // Execute query
            if($this->db->execute()){
                return true;
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

            $this->db->query('SELECT * FROM schedule WHERE Doctor_ID = :Doctor_ID AND Hospital_ID = :Hospital_ID AND Day_of_Week = :Day_of_Week');
            $this->db->bind(':Doctor_ID', $data['Doctor_ID']);
            $this->db->bind(':Hospital_ID', $data['Hospital_ID']);
            $this->db->bind(':Day_of_Week', $data['Selected_Day']);

            $schedule = $this->db->singleRow();
            $schedule_id = $schedule->Schedule_ID;

            $this->db->query('INSERT INTO doctor_reservation (Patient_ID, Schedule_ID, Payment_ID, Date, Start_Time, End_Time) VALUES (:Patient_ID, :Schedule_ID, :Payment_ID, :Date, :Start_Time, :End_Time)');
            // Binding parameters for the prepaired statement
            $this->db->bind(':Patient_ID', $data['Patient_ID']);
            $this->db->bind(':Schedule_ID', $schedule_id);
            $this->db->bind(':Payment_ID', $payment_id);
            $this->db->bind(':Date', $data['Selected_Date']);
            $this->db->bind(':Start_Time', $data['Start_Time']);
            $this->db->bind(':End_Time', $data['End_Time']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }

        
        
    }