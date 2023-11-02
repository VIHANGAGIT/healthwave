<?php
    class Patient extends Controller{
        public function __construct(){
            $this->patientModel = $this->model('user');
        }
        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [];
            
            $this->view('patient/doc_booking', $data);
        }

        public function test_booking(){
            $data = [];
            $this->view('patient/test_booking', $data);
        }

        public function reservations(){
            $data = [];
            $this->view('patient/reservations', $data);
        }

        public function medical_records(){
            $data = [];
            $this->view('patient/medical_records', $data);
        }

        public function profile(){
            session_start();

            // Get user data from session
            $data = [
                'Uname' => $_SESSION['userEmail'],
                'Name' => $_SESSION['userName'],
                'Type' => $_SESSION['userType'],
                'ID' => $_SESSION['userID']
            ];


            $patient_data = $this->patientModel->patient_data_fetch($data['Uname']);

            $data = [
                'Name' => $patient_data->First_Name . ' ' . $patient_data->Last_Name,
                'Gender' => $patient_data->Gender,
                'NIC' => $patient_data->NIC,
                'C_Num' => $patient_data->Contact_No,
                'Email' => $patient_data->Username,
                'Blood_Group' => $patient_data->Blood_Group,
                'Height' => $patient_data->Height,
                'Weight' => $patient_data->Weight
            ];
            
            $this->view("patient/profile", $data);

            
            
        }
    }
?>