<?php
    class Pharmacist extends Controller{
        public function __construct(){
            $this->userModel = $this->model('user');
        }
        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [];
            
            $this->view('pharmacist/prescription_view', $data);
        }

            public function profile(){
            session_start();
            $pharmacist = $this->userModel->hospital_staff_data_fetch($_SESSION['userID']);

            $data = [
                'ID' => $pharmacist->HS_ID,
                'First_Name' => $pharmacist->First_Name,
                'Last_Name' => $pharmacist->Last_Name,
                "Gender" => $pharmacist->Gender,
                "NIC" => $pharmacist->NIC,
                "C_Num" => $pharmacist->Contact_No,
                "Email" => $pharmacist->Username,
                "Password" => $pharmacist->Password,
                "Staff_ID" => $pharmacist->Staff_ID,
                "Hospital" => $pharmacist->Hospital,
                //"Employed_Date" => $pharmacist->Employed_Date,
            ];
            

            $this->view("pharmacist/profile", $data);
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


            $pharmacist_data = $this->pharmacistModel->pharmacist_data_fetch($data['ID']);
            // Check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize strings
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Register user
                $data = [
                    'ID'=> $_SESSION['userID'],
                    'First_Name' => trim($_POST['fname']),
                    'Last_Name' => trim($_POST['lname']),
                    'Gender' => $pharmacist_data->Gender,
                    'NIC' => trim($_POST['nic']),
                    'C_Num' => $_POST['cnum'],
                    'DOB' => $pharmacist_data->DOB,
                    'Age' => '',
                    'Height' => $_POST['height'],
                    'Weight' => $_POST['weight'],
                    'Blood_Group' => $pharmacist_data->Blood_Group,
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
                    if($this->pharmacistModel->pharmacist_profile_update($data)){
                        redirect('pharmacist/profile');
                    } else{
                        die("Couldn't register the pharmacist! ");
                    }
                } else {
                    // Load view
                    $this->view('pharmacist/profile_update', $data);
                }


            }else{
                // Get data
                $data = [
                    'First_Name' => $pharmacist_data->First_Name,
                    'Last_Name' => $pharmacist_data->Last_Name,
                    'Gender' => $pharmacist_data->Gender,
                    'NIC' => $pharmacist_data->NIC,
                    'C_Num' => $pharmacist_data->Contact_No,
                    'DOB' => $pharmacist_data->DOB,
                    'Blood_Group' => $pharmacist_data->Blood_Group,
                    'Height' => $pharmacist_data->Height,
                    'Weight' => $pharmacist_data->Weight,
                    'Allergies' => $pharmacist_data->Allergies,
                    'Uname' => $pharmacist_data->Username,
                    'Pass' => $pharmacist_data->Password,
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => ''
                ];

                // Load view
                $this->view('pharmacist/profile_update', $data);
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

            if($this->pharmacistModel->pharmacist_profile_delete($data['ID'])){
                redirect('users/logout');
            } else{
                die("Couldn't delete the pharmacist! ");
            }
        }
    }
    
?>