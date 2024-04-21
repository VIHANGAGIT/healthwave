<?php
    class Admin extends Controller{
        public function __construct(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start(); 
            }
            $this->adminModel = $this->model('admins');
        }
        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [];
            
            $this->view('admin/dashboard', $data);
        }

        public function profile(){
            // Get user data from session
            $data = [
                'Uname' => $_SESSION['userEmail'],
                'Name' => $_SESSION['userName'],
                'Type' => $_SESSION['userType'],
                'ID' => $_SESSION['userID']
            ];

            $admin_data = $this->adminModel->admin_data_fetch($data['ID']);
            $data = [
                'ID' => $data['ID'],
                'First_Name' => $admin_data->First_Name,
                'Last_Name' => $admin_data->Last_Name,
                'Gender' => $admin_data->Gender,
                'NIC' => $admin_data->NIC,
                'C_Num' => $admin_data->Contact_No,
                'Email' => $admin_data->Username,
                'Password' => $admin_data->Password

            ];



            
            $this->view('admin/profile', $data);
        }

        public function profile_update(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            
            $data = [
                'Uname' => $_SESSION['userEmail'],
                'Name' => $_SESSION['userName'],
                'Type' => $_SESSION['userType'],
                'ID' => $_SESSION['userID']
            ];

            $admin_data = $this->adminModel->admin_data_fetch($data['ID']);

            //check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

               //register user
                $data = [
                     'Admin_ID' => $_SESSION['userID'],
                     'First_Name' => trim($_POST['fname']),
                     'Last_Name' => trim($_POST['lname']),
                     'Gender' => $admin_data->Gender,
                     'NIC' => trim($_POST['nic']),
                     'C_Num' => $_POST['cnum'],
                     'Email' => trim($_POST['email']),
                     'Username' => $admin_data->Username,
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
                    if($this->adminModel->admin_profile_update($data)){
                        redirect('admin/profile');
                    } else{
                        die("Couldn't register the doctor! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('admin/profile_update', $data);
                }

            }else{
                // Get data
                $data = [
                    'ID' => $admin_data->Admin_ID,
                    'First_Name' => $admin_data->First_Name,
                    'Last_Name' => $admin_data->Last_Name,
                    'Gender' => $admin_data->Gender,
                    'NIC' => $admin_data->NIC,
                    'C_Num' => $admin_data->Contact_No,
                    'Email' => $admin_data->Username,
                    'Password' => $admin_data->Password,
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => ''
                ];

                // Load view
        
            $this->view('admin/profile_update', $data);
        }

        }
        

        public function approvals(){
            $data = [];
            $this->view('admin/approvals', $data);
        }

        public function doc_management(){
            $data = [
                'doctors' => $this->adminModel->getDoctors()
            ];
            $this->view('admin/doc_management', $data);
        }

        public function test_management(){
            $data = [];
            $this->view('admin/test_management', $data);
        }

        public function hospital_management(){
            $data = [];
            $this->view('admin/hospital_management', $data);
        }

        public function reservations(){
            $data = [];
            $this->view('admin/reservations', $data);
        }

        public function add_hospital(){
            $data = [];
            $this->view('admin/add_hospital', $data);
        }

        public function add_doctor(){
            $data = [];
            $this->view('admin/add_doctor', $data);
        }

        public function add_test(){
            $data = [];
            $this->view('admin/add_test', $data);
        }

        public function update_test(){
            $data = [];
            $this->view('admin/update_test', $data);
        }
        
        

        
    }
?>