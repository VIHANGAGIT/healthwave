<?php
    class Doctor extends Controller{

        public function __construct(){
            $this->doctorModel = $this->model('user');
            $this->reservationModel = $this->model('reservation');
        }
        public function index(){
           
            if (session_status() == PHP_SESSION_NONE) {
                session_start(); 
            }
            
            $data = $this->reservationModel->getReservations($_SESSION['userID']);
           
            $this->view('doctor/reservations', $data);
        }

        public function consultations(){
            $data = [];
            $this->view('doctor/consultations', $data);
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
    
    
            $doctor_data = $this->doctorModel->doctor_data_fetch($data['ID']);
    
            $data = [
                'ID' => $doctor_data->Doctor_ID,
                'First_Name' => $doctor_data->First_Name,
                'Last_Name' => $doctor_data->Last_Name,
                'Gender' => $doctor_data->Gender,
                'NIC' => $doctor_data->NIC,
                'C_Num' => $doctor_data->Contact_No,
                'SLMC' => $doctor_data->SLMC_Reg_No,
                'Spec' => $doctor_data->Specialization,
                'Email' => $doctor_data->Username,
                'Password' => $doctor_data->Password
            ];
    
            $this->view("doctor/profile", $data);
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


            $doctor_data = $this->doctorModel->doctor_data_fetch($data['ID']);
            // Check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize strings
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Register user
                $data = [
                    'ID'=> $_SESSION['userID'],
                    'First_Name' => trim($_POST['fname']),
                    'Last_Name' => trim($_POST['lname']),
                    'Gender' => $doctor_data->Gender,
                    'NIC' => trim($_POST['nic']),
                    'C_Num' => $_POST['cnum'],
                    'Avail' => 1,
                    'SLMC' => $doctor_data->SLMC_Reg_No,
                    'Spec' => $doctor_data->Specialization,
                    'Email' => trim($_POST['email']),
                    'Pass' => trim($_POST['pass']),
                    'C_pass' => trim($_POST['cpass']),
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => ''
                ];
                // Validate Email
                if(empty($data['Email'])){
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
                    if($this->doctorModel->doctor_profile_update($data)){
                        redirect('doctor/profile');
                    } else{
                        die("Couldn't register the doctor! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('doctor/profile_update', $data);
                }


            }else{
                // Get data
                $data = [
                    'ID' => $doctor_data->Doctor_ID,
                    'First_Name' => $doctor_data->First_Name,
                    'Last_Name' => $doctor_data->Last_Name,
                    'Gender' => $doctor_data->Gender,
                    'NIC' => $doctor_data->NIC,
                    'C_Num' => $doctor_data->Contact_No,
                    'SLMC' => $doctor_data->SLMC_Reg_No,
                    'Spec' => $doctor_data->Specialization,
                    'Email' => $doctor_data->Username,
                    'Password' => $doctor_data->Password,
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => ''
                ];

                // Load view
                $this->view('doctor/profile_update', $data);
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

            if($this->doctorModel->doctor_profile_delete($data['ID'])){
                redirect('users/logout');
            } else{
                die("Couldn't delete the Doctor! ");
            }
        }

    }

    
?>