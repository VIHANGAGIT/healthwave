<?php
    class Users extends Controller{ 
        public function __construct(){

        }

        public function register_patient(){
            // Check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize strings
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Register user
                $data = [
                    'F_name' => trim($_POST['fname']),
                    'L_name' => trim($_POST['lname']),
                    'Gender' => trim($_POST['gender']),
                    'DOB' => trim($_POST['dob']),
                    'NIC' => trim($_POST['nic']),
                    'C_num' => $_POST['cnum'],
                    'Height' => $_POST['height'],
                    'Weight' => $_POST['weight'],
                    'B_group' => $_POST['bgroup'],
                    'Allergies' => trim($_POST['allergies']),
                    'Uname' => trim($_POST['email']),
                    'Pass' => trim($_POST['pass']),
                    'C_pass' => trim($_POST['cpass']),
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => ''
                ];

                // Validate Email
                if(empty($data['Uname'])){
                    $data['Uname_err'] = 'Please enter valid email';
                }

                // Validate Password
                $length = strlen($data['Pass']);
                $uppercase = preg_match('@[A-Z]@', $data['Pass']);
                $lowercase = preg_match('@[a-z]@', $data['Pass']);
                $number = preg_match('@[0-9]@', $data['Pass']);
                $spec = preg_match('@[^\w]@', $data['Pass']);

                if(empty($data['Pass'])){
                    $data['Pass_err'] = 'Please enter valid password';
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
                        $data['Pass_err'] = 'Password must not include special characters';
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
                    die('SUCCESS');
                } else {
                    // Load view
                    $this->view('users/register_patient', $data);
                }


            }else{
                // Get data
                $data = [
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'Cpass_err' => ''
                ];

                // Load view
                $this->view('users/register_patient', $data);
            }
        }

        public function login(){
            // Check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Login user

                // Sanitize data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Register user
                $data = [
                    'Uname' => trim($_POST['email']),
                    'Pass' => trim($_POST['pass']),
                    'Uname_err' => '',
                    'Pass_err' => ''
                ];

                // Validate Email
                if(empty($data['Uname'])){
                    $data['Uname_err'] = 'Please enter your email';
                }

                 // Validate Password
                if(empty($data['Pass'])){
                    $data['Pass_err'] = 'Please enter your password';
                }

                // Check whether errors are empty
                if(empty($data['Uname_err']) && empty($data['Pass_err'])){
                    die('SUCCESS');
                } else {
                    // Load view
                    $this->view('users/login', $data);
                }

            }else{
                // Get data
                $data = [
                    'Uname_err' => '',
                    'Pass_err' => ''
                ];

                // Load view
                $this->view('users/login', $data);
            }
        }
    }