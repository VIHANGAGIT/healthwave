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
            $data = [
                'tests' => $this->adminModel->getTests()
            ];
            $this->view('admin/test_management', $data);
        }

        public function hospital_management(){
            $data = [
                'hospitals' => $this->adminModel->getHospitals()

            ];
            $this->view('admin/hospital_management', $data);
        }

        public function reservations(){
            $data = [];
            $this->view('admin/reservations', $data);
        }

        public function add_hospital(){
             // Check for POST request
             if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize strings
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Register user
                $data = [
                    'H_name' => $_POST['hname'],
                    'H_address' => $_POST['haddress'],
                    'Region' => trim($_POST['region']),
                    'H_charge' => trim($_POST['hcharge']),
                    //'M_ID' => trim($_POST['managerid']),
                    'C_num' => trim($_POST['cnum']),
                    'H_name_err' => '',
                    'H_address_err' => '',
                    'Region_err' => '',
                    'H_charge_err' => '',
                    'M_ID_err' => '',
                    'C_num_err' => ''
                ];

                // Validate Hospital Name
                if (empty($data['H_name'])) {
                    $data['H_name_err'] = 'Please enter hospital name';
                } else {
                    // Check for duplicate hospital names
                    if ($this->adminModel->findHospitalByName($data['H_name'])) {
                        $data['H_name_err'] = 'Hospital name already exists';
                    }
                }

                // Validate Hospital Address
                if (empty($data['H_address'])) {
                    $data['H_address_err'] = 'Please enter hospital address';
                } else {
                    // Check if the hospital address already exists in the database
                    if ($this->adminModel->findHospitalByAddress($data['H_address'])) {
                        $data['H_address_err'] = 'This hospital address is already taken';
                    }
                }

                // Validate Region
                if(empty($data['Region'])){
                    $data['Region_err'] = 'Please enter region';
                }

                // Validate Hospital Charge
                if(empty($data['H_charge'])){
                    $data['H_charge_err'] = 'Please enter hospital charge';
                }

                // Validate Manager ID
                // if(empty($data['M_ID'])){
                //     $data['M_ID_err'] = 'Please enter manager ID';
                // }

                // Validate Contact Number
                if(empty($data['C_num'])){
                    $data['C_num_err'] = 'Please enter contact number';
                } else {
                    // Remove any non-numeric characters from the input
                    $cleaned_number = preg_replace('/[^0-9]/', '', $data['C_num']);

                    // Check if the cleaned number is not exactly 10 digits long
                    if(strlen($cleaned_number) !== 10){
                        $data['C_num_err'] = 'Invalid Number';
                    } else {
                        // Proceed with other validations if needed
                    }
                }


                // Check whether errors are empty
                if(empty($data['H_name_err']) && empty($data['H_address_err']) && empty($data['Region_err']) && empty($data['H_charge_err']) && empty($data['C_num_err'])){
                    // Register user
                    if($this->adminModel->add_hospital($data)){
                        redirect('admin/hospital_management');
                    } else{
                        die("Couldn't register the hospital! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('admin/add_hospital', $data);
                }


            }else{
                // Get data
                $data = [
                    'H_name' => '',
                    'H_address' => '',
                    'Region' => '',
                    'H_charge' => '',
                    //'M_ID' => '',
                    'C_num' => '',
                    'H_name_err' => '',
                    'H_address_err' => '',
                    'Region_err' => '',
                    'H_charge_err' => '',
                    'M_ID_err' => '',
                    'C_num_err' => ''
                ];

                // Load view
                $this->view('admin/add_hospital', $data);
            }
        }

        public function add_doctor(){
            // Check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize strings
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Register user
                $data = [
                    'F_name' => trim($_POST['fname']),
                    'L_name' => trim($_POST['lname']),
                    'Gender' => trim($_POST['gender']),
                    'NIC' => trim($_POST['nic']),
                    'C_num' => $_POST['cnum'],
                    'DOB' => $_POST['dob'],
                    'Spec' => $_POST['spec'],
                    'SLMC' => $_POST['slmc'],
                    'Avail' => 1,
                    'Uname' => trim($_POST['email']),
                    'Pass' => trim($_POST['pass']),
                    'C_pass' => trim($_POST['cpass']),
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'C_num_err' => '',
                    'DOB_err' => '',
                    'SLMC_err' => '',
                    'NIC_err' => ''
                ];
                // Validate Contact Number
                if(empty($data['C_num'])){
                    $data['C_num_err'] = 'Please enter contact number';
                } else {
                    // Remove any non-numeric characters from the input
                    $cleaned_number = preg_replace('/[^0-9]/', '', $data['C_num']);

                    // Check if the cleaned number is not exactly 10 digits long
                    if(strlen($cleaned_number) !== 10){
                        $data['C_num_err'] = 'Invalid Number';
                    } else {
                        // Proceed with other validations if needed
                    }
                }

                //validate date of birth
                $dob = $data['DOB'];
                $today = date("Y-m-d");
                $diff = date_diff(date_create($dob), date_create($today));
                if($diff->format('%y') < 18){
                    $data['DOB_err'] = 'Doctor must be atleast 18 years old';
                }

                //validate SLMC number
                if(empty($data['SLMC'])){
                    $data['SLMC_err'] = 'Please enter SLMC number';
                }else{
                    if (!preg_match('/^\d{5}$/', $data['SLMC'])) {
                        // Invalid SLMC Number
                        $data['SLMC_err'] = "SLMC number must be a 5-digit number.";
                    } 
                }

                // Validate NIC number
                if (empty($data['NIC'])) {
                    $data['NIC_err'] = 'Please enter NIC number';
                } else {
                    // Remove any spaces or hyphens from the NIC number
                    $nic = str_replace([' ', '-'], '', $data['NIC']);

                    // Define regex patterns for the two NIC formats
                    $pattern1 = '/^\d{9}[VX]$/i';  // Format: 9 digits followed by 'V' or 'X'
                    $pattern2 = '/^\d{12}$/';       // Format: 12 digits

                    // Check if the NIC number matches either pattern
                    if (!preg_match($pattern1, $nic) && !preg_match($pattern2, $nic)) {
                        $data['NIC_err'] = 'Invalid NIC number';
                    }
                }

                




                // Validate Email
                if(empty($data['Uname'])){
                    $data['Uname_err'] = 'Please enter your email';
                } else{
                    // Check for duplicates
                    if($this->adminModel->findUserByUname($data['Uname'])){
                        $data['Uname_err'] = 'Another account already has this email';
                    }
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
                if(empty($data['Uname_err']) && empty($data['Pass_err']) && empty($data['C_pass_err'])&& empty($data['C_num_err'])&& empty($data['DOB_err'])&& empty($data['SLMC_err'])&& empty($data['NIC_err'])){
                    // Hashing password
                    $data['Pass'] = hash('sha256',$data['Pass']);

                    // Register user
                    if($this->adminModel->add_doctor($data)){
                        redirect('admin/doc_management');
                    } else{
                        die("Couldn't register the doctor! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('admin/add_doctor', $data);
                }


            }else{
                // Get data
                $data = [
                    'F_name' => '',
                    'L_name' => '',
                    'Gender' => '',
                    'DOB' => '',
                    'NIC' => '',
                    'C_num' => '',
                    'Spec' => '',
                    'SLMC' => '',
                    'Avail' => '',
                    'Uname' => '',
                    'Pass' => '',
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'C_num_err' => '',
                    'DOB_err' => '',
                    'SLMC_err' => '',
                    'NIC_err' => ''
                ];

                // Load view
                $this->view('admin/add_doctor', $data);
            }
        }

        public function add_test(){
           // Check for POST request
           if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Sanitize strings
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Register user
            $data = [
                'T_name' => trim($_POST['testname']),
                'T_type' => trim($_POST['testtype']),
                'T_name_err' => '',
                'T_type_err' => ''

              ];

            // Validate Test Name
            if(empty($data['T_name'])){
                $data['T_name_err'] = 'Please enter test name';
            }

            // Validate Test Type
            if(empty($data['T_type'])){
                $data['T_type_err'] = 'Please enter test type';
            }

            // Check whether errors are empty
            if(empty($data['T_name_err']) && empty($data['T_type_err'])){
                // Register user
                if($this->adminModel->add_test($data)){
                    redirect('admin/test_management');
                } else{
                    die("Couldn't register the test! ");
                }
            } else {
                // Load view with errors
                $this->view('admin/add_test', $data);
            }
            $this->view('admin/add_test', $data);

        }else{
            // Get data
            $data = [
                'T_name' => '',
                'T_type' => '',
                'T_name_err' => '',
                'T_type_err' => ''
            ];

            // Load view
            $this->view('admin/add_test', $data);
        }
        }

        public function update_test() {
            

             //check for POST request
             if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //add test
                $data = [
                    'ID' => $_POST['testid'],
                    'T_name' => trim($_POST['testname']),
                    'T_type' => trim($_POST['testtype']),
                    'T_name_err' => '',
                    'T_type_err' => ''
                ];

                // Validate Test Name
                if(empty($data['T_name'])){
                    $data['Test_Name_err'] = 'Please enter test name';
                }

                // Validate Test Type
                if(empty($data['T_type'])){
                    $data['T_type_err'] = 'Please enter test type';
                }

                // Check whether errors are empty
                if(empty($data['Test_Name_err']) && empty($data['T_type_err'])){
                    // Register user
                    if($this->adminModel->update_test($data)){
                        redirect('admin/test_management');
                    } else{
                        die("Couldn't update the test! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('admin/update_test', $data);
                }

            }else{
                $test_id = $_GET['test_id'];

                $test_data = $this->adminModel->test_data_fetch($test_id);
                
                $data = [
                    'ID' => $test_data->Test_ID,
                    'T_name' => $test_data->Test_Name,
                    'T_type' => $test_data->Test_Type
                ];
                
                // Load view
                $this->view('admin/update_test', $data);
            }

            // Load view
            $this->view('admin/update_test', $data);
        }
    
        public function edit_hospital(){
            //check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //add test
                $data = [
                    'H_ID' => $_POST['hid'],
                    'H_name' => trim($_POST['hname']),
                    'H_address' => trim($_POST['haddress']),
                    'Region' => trim($_POST['region']),
                    'H_charge' => trim($_POST['hcharge']),
                    //'M_ID' => trim($_POST['managerid']),
                    'C_num' => trim($_POST['cnum']),
                    'H_name_err' => '',
                    'H_address_err' => '',
                    'Region_err' => '',
                    'H_charge_err' => '',
                    'M_ID_err' => '',
                    'C_num_err' => ''
                ];

                // Validate Hospital Name
                if(empty($data['H_name'])){
                    $data['H_name_err'] = 'Please enter hospital name';
                }

                // Validate Hospital Address
                if(empty($data['H_address'])){
                    $data['H_address_err'] = 'Please enter hospital address';
                }

                // Validate Region
                if(empty($data['Region'])){
                    $data['Region_err'] = 'Please enter region';
                }

                // Validate Hospital Charge
                if(empty($data['H_charge'])){
                    $data['H_charge_err'] = 'Please enter hospital charge';
                }

                // Validate Manager ID
                // if(empty($data['M_ID'])){
                //     $data['M_ID_err'] = 'Please enter manager ID';
                // }

                 // Validate Contact Number
                 if(empty($data['C_num'])){
                    $data['C_num_err'] = 'Please enter contact number';
                } else {
                    // Remove any non-numeric characters from the input
                    $cleaned_number = preg_replace('/[^0-9]/', '', $data['C_num']);

                    // Check if the cleaned number is not exactly 10 digits long
                    if(strlen($cleaned_number) !== 10){
                        $data['C_num_err'] = 'Invalid Number';
                    } else {
                        // Proceed with other validations if needed
                    }
                }

                // Check whether errors are empty
                if(empty($data['H_name_err']) && empty($data['H_address_err']) && empty($data['Region_err']) && empty($data['H_charge_err']) && empty($data['C_num_err'])){
                    // Register user
                    if($this->adminModel->edit_hospital($data)){
                        redirect('admin/hospital_management');
                    } else{
                        die("Couldn't register the hospital! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('admin/edit_hospital', $data);
                }

            }else{
                
                $hospital_id = $_GET['hospital_id'];

                $hospital_data = $this->adminModel->hospital_data_fetch($hospital_id);
                
                $data = [
                    'H_ID' => $hospital_data->Hospital_ID,
                    'H_name' => $hospital_data->Hospital_Name,
                    'H_address' => $hospital_data->Address,
                    'Region' => $hospital_data->Region,
                    'H_charge' => $hospital_data->Charge,
                    //'M_ID' => $hospital_data->Mng_ID,
                    'C_num' => $hospital_data->Contact_No,
                    'C_num_err' => '',
                    'H_name_err' => '',
                    'H_address_err' => '',
                    'Region_err' => '',
                    'H_charge_err' => '',
                    'M_ID_err' => '',

                ];
                
                // Load view
                $this->view('admin/edit_hospital', $data);
            }
         
           }
           
           public function remove_test(){
            $test_id = $_GET['test_id'];
            if($this->adminModel->remove_test($test_id)){
                redirect('admin/test_management');
            } else{
                die("Couldn't remove the test! ");
            }    
    }

        public function remove_doctor(){
            $doc_id = $_GET['doc_id'];
            if($this->adminModel->remove_doctor($doc_id)){
                redirect('admin/doc_management');
            } else{
                die("Couldn't remove the doctor! ");
            }    
        }

        public function remove_hospital(){
            $hospital_id = $_GET['hospital_id'];
            if($this->adminModel->remove_hospital($hospital_id)){
                redirect('admin/hospital_management');
            } else{
                die("Couldn't remove the hospital! ");
            }    
        }
    }
?>