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


            $patient_data = $this->patientModel->patient_data_fetch($data['ID']);

            $data = [
                'ID' => $patient_data->Patient_ID,
                'First_Name' => $patient_data->First_Name,
                'Last_Name' => $patient_data->Last_Name,
                'Gender' => $patient_data->Gender,
                'NIC' => $patient_data->NIC,
                'C_Num' => $patient_data->Contact_No,
                'DOB' => $patient_data->DOB,
                'Blood_Group' => $patient_data->Blood_Group,
                'Height' => $patient_data->Height,
                'Weight' => $patient_data->Weight,
                'Allergies' => $patient_data->Allergies,
                'Email' => $patient_data->Username,
                'Password' => $patient_data->Password
            ];

            $this->view("patient/profile", $data);
        }

        public function profile_update(){

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Get user data from session
            $data = [
                'Uname' => $_SESSION['userEmail'],
                'Name' => $_SESSION['userName'],
                'Type' => $_SESSION['userType'],
                'ID' => $_SESSION['userID']
            ];


            $patient_data = $this->patientModel->patient_data_fetch($data['ID']);
            // Check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize strings
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Register user
                $data = [
                    'ID'=> $_SESSION['userID'],
                    'First_Name' => trim($_POST['fname']),
                    'Last_Name' => trim($_POST['lname']),
                    'Gender' => trim($_POST['gender']),
                    'NIC' => trim($_POST['nic']),
                    'C_Num' => $_POST['cnum'],
                    'DOB' => $_POST['dob'],
                    'Age' => '',
                    'Height' => $_POST['height'],
                    'Weight' => $_POST['weight'],
                    'Blood_Group' => $_POST['bgroup'],
                    'Allergies' => trim($_POST['allergies']),
                    'Uname' => trim($_POST['email']),
                    'Pass' => trim($_POST['pass']),
                    'C_pass' => trim($_POST['cpass']),
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => ''
                ];


                // Calculate age
                $currentDate = new DateTime();
                $birthDate = new DateTime($data['DOB']);
                $data['Age'] = $currentDate->diff($birthDate)->y;


                // Validate Email
                if(empty($data['Uname'])){
                    $data['Uname_err'] = 'Please enter your email';
                }

                // Validate Password
                $length = strlen($data['Pass']);
                $uppercase = preg_match('@[A-Z]@', $data['Pass']);
                $lowercase = preg_match('@[a-z]@', $data['Pass']);
                $number = preg_match('@[0-9]@', $data['Pass']);
                $spec = preg_match('@[^\w]@', $data['Pass']);

                if(empty($data['Pass'])){
                    $data['Pass_err'] = 'Please enter a password';
                } else{
                    if($length < 8){
                        $data['Pass_err'] = 'Password must be atleast 8 characters';
                    }
                    if(!$uppercase){
                        $data['Pass_err'] = 'Password must include atleast 1 uppercase character';
                    }
                    if(!$lowercase){
                        $data['Pass_err'] = 'Password must include atleast 1 lowercase character';
                    }
                    if(!$number){
                        $data['Pass_err'] = 'Password must include atleast 1 number';
                    }
                    if(!$spec){
                        $data['Pass_err'] = 'Password must include atleast 1 special character';
                    }

                } 

                // Validate Confirm Password
                if(empty($data['C_pass'])){
                    $data['C_pass_err'] = 'Please confirm password';
                } else{
                    if($data['Pass'] != $data['C_pass']){
                        $data['C_pass_err'] = 'Confirm password does not match with password';
                    }
                }

                // Check whether errors are empty
                if(empty($data['Uname_err']) && empty($data['Pass_err']) && empty($data['C_pass_err'])){
                    // Hashing password
                    $data['Pass'] = hash('sha256',$data['Pass']);

                    // Register user
                    if($this->patientModel->patient_profile_update($data)){
                        redirect('patient/profile');
                    } else{
                        die("Couldn't register the patient! ");
                    }
                } else {
                    // Load view
                    $this->view('patient/profile_update', $data);
                }


            }else{
                // Get data
                $data = [
                    'First_Name' => $patient_data->First_Name,
                    'Last_Name' => $patient_data->Last_Name,
                    'Gender' => $patient_data->Gender,
                    'NIC' => $patient_data->NIC,
                    'C_Num' => $patient_data->Contact_No,
                    'DOB' => $patient_data->DOB,
                    'Blood_Group' => $patient_data->Blood_Group,
                    'Height' => $patient_data->Height,
                    'Weight' => $patient_data->Weight,
                    'Allergies' => $patient_data->Allergies,
                    'Uname' => $patient_data->Username,
                    'Pass' => $patient_data->Password,
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => ''
                ];

                // Load view
                $this->view('patient/profile_update', $data);
            }
        }

        public function profile_delete(){
            session_start();

            // Get user data from session
            $data = [
                'Uname' => $_SESSION['userEmail'],
                'Name' => $_SESSION['userName'],
                'Type' => $_SESSION['userType'],
                'ID' => $_SESSION['userID']
            ];

            if($this->patientModel->patient_profile_delete($data['ID'])){
                redirect('users/logout');
            } else{
                die("Couldn't delete the patient! ");
            }
        }

    }
?>