<?php
    class Manager extends Controller{
        public function __construct(){
            $this->userModel = $this->model('user');
        }
        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [];
            
            $this->view('manager/dashboard', $data);
        }

        public function approvals(){
            $data = [];
            $this->view('manager/approvals', $data);
        }

        public function doc_management(){
            $data = [];
            $this->view('manager/doc_management', $data);
        }

        public function test_management(){
            $data = [];
            $this->view('manager/test_management', $data);
        }

        public function reservations(){
            $data = [];
            $this->view('manager/reservations', $data);
        }

        public function profile(){
            session_start();
            $manager = $this->userModel->staff_data_fetch($_SESSION['userID']);
           
            $data = [
                'ID' => $manager->HS_ID,
                'First_Name' => $manager->First_Name,
                'Last_Name' => $manager->Last_Name,
                "Gender" => $manager->Gender,
                "NIC" => $manager->NIC,
                "C_Num" => $manager->Contact_No,
                "Email" => $manager->Username,
                "Password" => $manager->Password,
                "Staff_ID" => $manager->Staff_ID,
                "Hospital" => $manager->Hospital,
                "Employed_Date" => $manager->Employed_Date,
            ];
            
            $this->view("manager/profile", $data);
        }
        
        public function profile_update(){
            session_start();
            $manager = $this->userModel->staff_data_fetch($_SESSION['userID']);
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
            
                        'HS_ID' => $_SESSION['userID'],
                        'First_Name' => trim($_POST['fname']),
                        'Last_Name' => trim($_POST['lname']),
                        'Gender' => $manager->Gender,
                        'NIC' => trim($_POST['nic']),
                        'Contact_No' => trim($_POST['cnum']),
                        'Hospital' => $manager->Hospital,
                        'Employed_Date' => $manager->Employed_Date,
                        'Role' => $manager->Role,
                        'Username' => trim($_POST['email']),
                        'Staff_ID' => $manager->Staff_ID,
                        'Pass' => trim($_POST['pass']),
                        'C_pass' => trim($_POST['cpass']),
                        'Uname_err' => '',
                        'Pass_err' => '',
                        'C_pass_err' => ''
                ];

                if(empty($data['Username'])){
                    $data['Uname_err'] = 'Please enter your email';
                }
        
                $length = strlen($data['Pass']);
                $uppercase = preg_match('@[A-Z]@', $data['Pass']);
                $lowercase = preg_match('@[a-z]@', $data['Pass']);
                $number = preg_match('@[0-9]@', $data['Pass']);
                $spec = preg_match('@[^\w]@', $data['Pass']);
        
                if(empty($data['Pass'])){
                    $data['Pass_err'] = 'Please enter a password';
                } else{
                    if($length < 8){
                        $data['Pass_err'] = 'Password must be at least 8 characters';
                    }
                    if(!$uppercase){
                        $data['Pass_err'] = 'Password must include at least 1 uppercase character';
                    }
                    if(!$lowercase){
                        $data['Pass_err'] = 'Password must include at least 1 lowercase character';
                    }
                    if(!$number){
                        $data['Pass_err'] = 'Password must include at least 1 number';
                    }
                    if(!$spec){
                        $data['Pass_err'] = 'Password must include at least 1 special character';
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
        
                    if($this->userModel->manager_profile_update($data)){
                        redirect('manager/profile');
                    } else{
                        die("Couldn't update the profile!");
                    }
                } else {
                    // Load view with errors
                    $this->view('manager/profile_update', $data);
                }
            }
            else{
                $data = [
                    'HS_ID' => $_SESSION['userID'],
                    'First_Name' => $manager->First_Name,
                    'Last_Name' => $manager->Last_Name,
                    'Gender' => $manager->Gender,
                    'NIC' => $manager->NIC,
                    'Contact_No' => $manager->Contact_No,
                    'Hospital' => $manager->Hospital,
                    'Employed_Date' => $manager->Employed_Date,
                    'Role' => $manager->Role,
                    'Username' => $manager->Username,
                    'Staff_ID' => $manager->Staff_ID,
                    'Pass' => '',
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => ''
                ];
                $this->view("manager/profile_update", $data);
            }
        }
        
    }
?>