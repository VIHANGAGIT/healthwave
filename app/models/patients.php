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

            if ($this->db->execute()) {
                $this->db->query('SELECT * FROM payment ORDER BY Payment_ID DESC LIMIT 1;');
                $lastRow = $this->db->singleRow();
                $payment_id = $lastRow->Payment_ID;

                $this->db->query('SELECT * FROM schedule WHERE Doctor_ID = :Doctor_ID AND Hospital_ID = :Hospital_ID AND Day_of_Week = :Day_of_Week');
                $this->db->bind(':Doctor_ID', $data['Doctor_ID']);
                $this->db->bind(':Hospital_ID', $data['Hospital_ID']);
                $this->db->bind(':Day_of_Week', $data['Selected_Day']);

                $schedule = $this->db->singleRow();
                $schedule_id = $schedule->Schedule_ID;

                $this->db->query('INSERT INTO doctor_reservation (Patient_ID, Schedule_ID, Payment_ID, Date, Appointment_No, Start_Time, End_Time, Contact_Number, Email, Status) VALUES (:Patient_ID, :Schedule_ID, :Payment_ID, :Date, :App_No, :Start_Time, :End_Time, :Contact_Number, :Email, :Status)');
                // Binding parameters for the prepaired statement
                $this->db->bind(':Patient_ID', $data['Patient_ID']);
                $this->db->bind(':Schedule_ID', $schedule_id);
                $this->db->bind(':Payment_ID', $payment_id);
                $this->db->bind(':Date', $data['Selected_Date']);
                $this->db->bind(':App_No', $data['Appointment_No']);
                $this->db->bind(':Start_Time', $data['Start_Time']);
                $this->db->bind(':End_Time', $data['End_Time']);
                $this->db->bind(':Contact_Number', $data['Contact_No']);
                $this->db->bind(':Email', $data['Email']);
                $this->db->bind(':Status', "Pending");

                if($this->db->execute()){
                    $this->db->query('SELECT LAST_INSERT_ID() AS res_id');
                    $row = $this->db->singleRow();
                    $res_id = $row->res_id;

                    $this->db->query('SELECT patient.First_Name, patient.Last_Name, doctor.First_Name AS Doc_First_Name, doctor.Last_Name AS Doc_Last_Name, doctor.Specialization, hospital.Hospital_Name, room.Room_Name FROM doctor_reservation
                    INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
                    INNER JOIN doctor ON schedule.Doctor_ID = doctor.Doctor_ID
                    INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
                    INNER JOIN patient ON doctor_reservation.Patient_ID = patient.Patient_ID
                    INNER JOIN room ON schedule.Room_ID = room.Room_ID
                    WHERE doctor_reservation.Doc_Res_ID = :res_id');

                    $this->db->bind(':res_id', $res_id);
                    $reservation = $this->db->singleRow();
                    return $reservation;
                } else{
                    return false;
                }
                

                // if($this->db->execute()){
                //     return true;
                // } else{
                //     return false;
                // }

            } else {
                return false;
            }

        }

        public function get_doc_reservations($patient_id){
            $this->db->query("SELECT doctor_reservation.*, doctor.First_Name, doctor.Last_Name, doctor.Specialization, hospital.Hospital_Name FROM doctor_reservation
            INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            INNER JOIN doctor ON schedule.Doctor_ID = doctor.Doctor_ID
            INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
            WHERE doctor_reservation.Patient_ID = :patient_id
            AND CONCAT(doctor_reservation.Date, ' ', doctor_reservation.End_Time) > CURRENT_TIMESTAMP() AND doctor_reservation.Status = 'Pending'
            ORDER BY doctor_reservation.Date, doctor_reservation.Start_Time ASC");

            $this->db->bind(':patient_id', $patient_id);
            $doc_reservations = $this->db->resultSet();

            foreach($doc_reservations as $slot){
                $slot->Start_Time = date('H:i', strtotime($slot->Start_Time));
                $slot->End_Time = date('H:i', strtotime($slot->End_Time));
            }

            if($this->db->execute()){
                return $doc_reservations;
            } else{
                return false;
            }
        }

        public function get_test_reservations($patient_id){
            $this->db->query("SELECT test_reservation.*, test.Test_Name, test.Test_Type, hospital.Hospital_Name FROM test_reservation
            INNER JOIN test ON test_reservation.Test_ID = test.Test_ID
            INNER JOIN hospital ON test_reservation.Hospital_ID = hospital.Hospital_ID
            WHERE test_reservation.Patient_ID = :patient_id AND test_reservation.Status = 'Pending'
            AND CONCAT(test_reservation.Date, ' ', test_reservation.End_Time) > CURRENT_TIMESTAMP() ORDER BY test_reservation.Date, test_reservation.Start_Time ASC");
            
            $this->db->bind(':patient_id', $patient_id);
            $test_reservations = $this->db->resultSet();

            foreach($test_reservations as $slot){
                $slot->Start_Time = date('H:i', strtotime($slot->Start_Time));
                $slot->End_Time = date('H:i', strtotime($slot->End_Time));
            }

            if($this->db->execute()){
                return $test_reservations;
            } else{
                return false;
            }
        }

        public function get_consultations($patient_id){
            $this->db->query("SELECT doctor_reservation.*, doctor_consultation.*, doctor.First_Name, doctor.Last_Name, doctor.Specialization, hospital.Hospital_Name FROM doctor_consultation
            INNER JOIN doctor_reservation ON doctor_consultation.Doc_Res_ID = doctor_reservation.Doc_Res_ID
            INNER JOIN schedule ON doctor_reservation.Schedule_ID = schedule.Schedule_ID
            INNER JOIN doctor ON schedule.Doctor_ID = doctor.Doctor_ID
            INNER JOIN hospital ON schedule.Hospital_ID = hospital.Hospital_ID
            WHERE doctor_reservation.Patient_ID = :patient_id
            AND doctor_reservation.Status = 'Consulted' ORDER BY doctor_reservation.Date, doctor_reservation.Start_Time ASC");

            $this->db->bind(':patient_id', $patient_id);
            $doc_reservations = $this->db->resultSet();

            foreach($doc_reservations as $slot){
                $slot->Start_Time = date('h:i', strtotime($slot->Start_Time));
                $slot->End_Time = date('h:i', strtotime($slot->End_Time));
            }

            if($this->db->execute()){
                return $doc_reservations;
            } else{
                return false;
            }
        }

        public function get_past_test_reservations($patient_id){
            $this->db->query("SELECT test_reservation.*, test.Test_Name, test.Test_Type, hospital.Hospital_Name FROM test_reservation
            INNER JOIN test ON test_reservation.Test_ID = test.Test_ID
            INNER JOIN hospital ON test_reservation.Hospital_ID = hospital.Hospital_ID
            WHERE test_reservation.Patient_ID = :patient_id AND (test_reservation.Status = 'Completed' OR test_reservation.Status = 'Collected')
            AND CONCAT(test_reservation.Date, ' ', test_reservation.End_Time) < CURRENT_TIMESTAMP() ORDER BY test_reservation.Date, test_reservation.Start_Time ASC");
            
            $this->db->bind(':patient_id', $patient_id);
            $test_reservations = $this->db->resultSet();

            foreach($test_reservations as $slot){
                $slot->Start_Time = date('h:i', strtotime($slot->Start_Time));
                $slot->End_Time = date('h:i', strtotime($slot->End_Time));
            }

            if($this->db->execute()){
                return $test_reservations;
            } else{
                return false;
            }
        }

        
        
    }