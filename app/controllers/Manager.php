<?php
    class Manager extends Controller{
        public function __construct(){

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
           
            $this->userModel = $this->model('user');
            $this->managerModel = $this->model('managers');
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



        public function reservations(){
            $data = [];
            $this->view('manager/reservations', $data);
        }

        public function schedules(){
            $data = [];
            $this->view('manager/schedules', $data);
        }

        public function room_management(){
            $data = [];
            $this->view('manager/room_management', $data);
        }

        public function addschedules(){
            $data = [];
            $this->view('manager/addschedules', $data);
        }

        public function profile(){
            session_start();
            $data = [
                'Uname' => $_SESSION['userEmail'],
                'Name' => $_SESSION['userName'],
                'Type' => $_SESSION['userType'],
                'ID' => $_SESSION['userID']
            ];

            $manager = $this->managerModel->hospital_staff_data_fetch($data['ID']);


           
            $data = [
                'ID' => $manager->HS_ID,
                'First_Name' => $manager->First_Name,
                'Last_Name' => $manager->Last_Name,
                "Gender" => $manager->Gender,
                "NIC" => $manager->NIC,
                "C_Num" => $manager->Contact_No,
                "Email" => $manager->Username,
                "Password" => $manager->Password,
                //"Staff_ID" => $manager->Staff_ID,
                "Hospital" => $manager->Hospital,
                //"Employed_Date" => $manager->Employed_Date,
            ];
            
            $this->view("manager/profile", $data);
        }
        
        public function profile_update(){
            session_start();
            $manager = $this->userModel->hospital_staff_data_fetch($_SESSION['userID']);
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
    

    public function test_management(){
            
        $data = [
            'ID' => $_SESSION['userID']
        ];

        $hospital_data = $this->managerModel->hospital_data_fetch($data['ID']);
        $hospital_id = $hospital_data->Hospital_ID;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
            // Get search parameters from the form
            $T_Name = isset($_POST['T_Name']) ? $_POST['T_Name'] : null;
            $T_ID = isset($_POST['T_ID']) ? $_POST['T_ID'] : null;
            $T_Type = isset($_POST['T_Type']) ? $_POST['T_Type'] : null;
    
            // Perform the search based on the parameters
            $tests = $this->managerModel->search_tests_with_id_hospital($T_Name, $T_ID, $T_Type, $hospital_id);
    
        } else {
            $tests = $this->managerModel->manager_labtest_data_fetch($hospital_id);

        }

        $types = [];

        if($tests){
            foreach ($tests as $test) {
                if (!in_array($test->Test_Type, $types)) {
                    $types[] = $test->Test_Type;
                }
                if($this->managerModel->get_appointments_test_hospital($test->Test_ID, $hospital_id)){
                    $test->Cancel = 'Not allowed';
                }else{
                    $test->Cancel = 'Allowed';
                }
            }
        }
        $data = [
            'tests' => $tests,
            'types' => $types
        ];
        $this->view('manager/test_management', $data);
    }

    public function add_test() {
        // Check for POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize strings
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            // Prepare data array
            $data = [
                'Test_Name' => trim($_POST['Test_Name']),
                'Type' => trim($_POST['Type']),
                'Price' => trim($_POST['Price']),
                'Test_Name_err' => '',
                'Type_err' => '',
                'Price_err' => ''
            ];
    
            // Validate Test Name
            if (empty($data['Test_Name'])) {
                $data['Test_Name_err'] = 'Please enter test name';
            }
    
            // Validate Test Type
            if (empty($data['Type'])) {
                $data['Type_err'] = 'Please enter test type';
            }
    
            // Validate Price
            if (empty($data['Price'])) {
                $data['Price_err'] = 'Please enter price';
            }
    
            // Check whether errors are empty
            if (empty($data['Test_Name_err']) && empty($data['Type_err']) && empty($data['Price_err'])) {
                // Add test
                if ($this->adminModel->add_lab_test($data)) {
                    redirect('manager/test_management');
                } else {
                    die("Couldn't add the test! ");
                }
            } else {
                // Load view with errors
                $this->view('manager/test_management', $data);
            }
        } else {
            // Load view with empty data
            $data = [
                'Test_Name' => '',
                'Type' => '',
                'Price' => '',
                'Test_Name_err' => '',
                'Type_err' => '',
                'Price_err' => ''
            ];
            $this->view('manager/test_management', $data);
        }
    }       
    
    }



