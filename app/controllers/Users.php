<?php
    class Users extends Controller{ 
        public function __construct(){
            $this->userModel = $this->model('user');
            $this->doctorModel = $this->model('doctors');
        }

        public function landing(){
            $data=[];
            $this->view('pages/landing', $data);
        }
        public function about_patient_management(){
            $data=[];
            $this->view('pages/about_patient_management', $data);
        }

        public function about_doctor_mgt(){
            $data=[];
            $this->view('pages/about_doctor_mgt', $data);
        }

        public function about_hospital_mgt(){
            $data=[];
            $this->view('pages/about_hospital_mgt', $data);
        }

        public function about_pharmacy_mgt(){
            $data=[];
            $this->view('pages/about_pharmacy_mgt', $data);
        }

        public function terms_and_cond(){
            $data=[];
            $this->view('pages/terms_and_cond', $data);
        }

        public function about_us(){
            $data=[];
            $this->view('pages/about_us', $data);
        }

        public function prescription_validate(){
            
            $id = $_GET['id'];

            $prescription_data = $this->userModel->get_prescription_code();

            $is_valid = false;

            foreach($prescription_data as $prescription){
                $hash = hash('sha256', $prescription->Prescription_ID.$prescription->Diagnosis);
                if($hash == $id){
                    $is_valid = true;
                    $prescription_row = $this->userModel->get_prescription_data($prescription->Prescription_ID);
                    $Name = $prescription_row->First_Name . ' ' . $prescription_row->Last_Name;
                    $Age = date_diff(date_create($prescription_row->DOB), date_create('now'))->y;
                    $Doc_Name = $prescription_row->Doc_First_Name . ' ' . $prescription_row->Doc_Last_Name;
                    $prescription_id = $prescription_row->Prescription_ID;
                    $code = $hash;
            
                    $data = [
                        'Prescription_ID' => $prescription_id,
                        'Name' => $Name,
                        'Age' => $Age,
                        'Gender' => $prescription_row->Gender,
                        'NIC' => $prescription_row->NIC,
                        'Allergies' => $prescription_row->Allergies,
                        'Date' => $prescription_row->Date,
                        'Doc_Name' => $Doc_Name,
                        'Diagnosis' => $prescription_row->Diagnosis,
                        'Remarks' => $prescription_row->Comments,
                        'Referral' => $prescription_row->Referrals,
                        'Drugs' => $prescription_row->Drug_Details,
                        'Tests' => $prescription_row->Test_Details,
                        'Hospital_Name' => $prescription_row->Hospital_Name,
                        'Contact_No' => $prescription_row->Contact_No,
                        'Specialization' => $prescription_row->Specialization,
                        'SLMC_Reg_No' => $prescription_row->SLMC_Reg_No,
                        'Code' => $code
                    ];
            
            
                    try{
                        include_once APPROOT.'/helpers/generate_prescription.php';
                    }catch(Exception $e){
                        echo $e;
                    }
                    break;
                }
            }

            if(!$is_valid){
                redirect('users/invalid_prescription');
            }

            
        }

        public function invalid_prescription(){
            $data=[];
            $this->view('pages/invalid_prescription', $data);
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
                    'NIC' => trim($_POST['nic']),
                    'C_num' => $_POST['cnum'],
                    'DOB' => $_POST['dob'],
                    'Age' => '',
                    'Height' => $_POST['height'],
                    'Weight' => $_POST['weight'],
                    'B_group' => $_POST['bgroup'],
                    'Allergies' => trim($_POST['allergies']),
                    'Uname' => trim($_POST['email']),
                    'Pass' => trim($_POST['pass']),
                    'C_pass' => trim($_POST['cpass']),
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'DOB_err' => '',
                    'NIC_err' => '',
                    'C_num_err' => '',
                    'Height_err' => '',
                    'Weight_err' => ''
                ];


                // Calculate age
                $currentDate = new DateTime();
                $birthDate = new DateTime($data['DOB']);
                $data['Age'] = $currentDate->diff($birthDate)->y;

                // Validate DOB
                $dob = $data['DOB'];
                $today = date("Y-m-d");
                $diff = date_diff(date_create($dob), date_create($today));
                if($diff->format('%y') < 16){
                    $data['DOB_err'] = 'Patient must be atleast 16 years old';
                }

                //validate NIC
                if (empty($data['NIC'])) {
                    $data['NIC_err'] = 'Please enter NIC number';
                } else {
                    $nic = $data['NIC'];
                    if (strlen($nic)!=10 && strlen($nic)!=12){
                        $data['NIC_err'] = 'Invalid NIC number';
                    }
                    if (strlen($nic) == 10){
                        $lastChar = strtoupper(substr($nic, 9, 1)); // Get the last character and convert to uppercase

                        if ($lastChar !== 'V') {
                            $data['NIC_err'] = 'Invalid NIC number';
                        }
                        if(!is_numeric(substr($nic, 0, 9))){
                            $data['NIC_err'] = 'Invalid NIC number';
                        }
                    }
                    // }
                    if (strlen($nic) == 12 && !is_numeric($nic)){
                        $data['NIC_err'] = 'Invalid NIC number';
                    }
                }

                // Validate Contact Number
                if(empty($data['C_num'])){
                    $data['C_num_err'] = 'Please enter contact number';
                } else {
                    // Remove any non-numeric characters from the input
                    $cleaned_number = preg_replace('/[^0-9]/', '', $data['C_num']);

                    // Check if the cleaned number is not exactly 10 digits long
                    if(strlen($cleaned_number) !== 10){
                        $data['C_num_err'] = 'Invalid Number';
                    }
                }

                //validate height
                if(empty($data['Height'])){
                    $data['Height_err'] = 'Please enter your height';
                } else{
                    $height = intval($data['Height']); // Convert to integer for comparison
                    if($height < 50 || $height > 250){
                        $data['Height_err'] = 'Should be between 50 cm and 250 cm';
                    }
                }

                //validate weight
                if(empty($data['Weight'])){
                    $data['Weight_err'] = 'Please enter your weight';
                } else{
                    $weight = intval($data['Weight']); // Convert to integer for comparison
                    if($weight < 20 || $weight > 250){
                        $data['Weight_err'] = 'Should be between 20 kg and 250 kg';
                    }
                }



                // Validate Email
                if(empty($data['Uname'])){
                    $data['Uname_err'] = 'Please enter your email';
                } else{
                    // Check for duplicates
                    if($this->userModel->findUserByUname($data['Uname'])){
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
                if(empty($data['Uname_err']) && empty($data['Pass_err']) && empty($data['C_pass_err']) && empty($data['DOB_err'])&& empty($data['NIC_err'])&& empty($data['C_num_err'])&& empty($data['Height_err'])&& empty($data['Weight_err'])){
                    
                    // Hashing password
                    $data['Pass'] = hash('sha256',$data['Pass']);

                    // Register user
                    if($this->userModel->register_patient($data)){
                        redirect('users/login');
                    } else{
                        die("Couldn't register the patient! ");
                    }
                } else {
                    // Load view
                    $this->view('users/register_patient', $data);
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
                    'Height' => '',
                    'Weight' => '',
                    'B_group' => '',
                    'Allergies' => '',
                    'Uname' => '',
                    'Pass' => '',
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'DOB_err' => '',
                    'NIC_err' => '',
                    'C_num_err' => '',
                    'Height_err' => '',
                    'Weight_err' => ''
                ];

                // Load view
                $this->view('users/register_patient', $data);
            }
        }

        public function register_doctor(){
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
                    'Spec' => $_POST['spec'],
                    'SLMC' => $_POST['slmc'],
                    'Charges' => $_POST['charges'],
                    'Approval' => 0,
                    'Uname' => trim($_POST['email']),
                    'Pass' => trim($_POST['pass']),
                    'C_pass' => trim($_POST['cpass']),
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'C_num_err' => '',
                    'SLMC_err' => '',
                    'NIC_err' => '',
                    'Char_err' => ''
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
                    }
                }

                //validate NIC
                if (empty($data['NIC'])) {
                    $data['NIC_err'] = 'Please enter NIC number';
                } else {
                    $nic = $data['NIC'];
                    if (strlen($nic)!=10 && strlen($nic)!=12){
                        $data['NIC_err'] = 'Invalid NIC number';
                    }
                    if (strlen($nic) == 10){
                        $lastChar = strtoupper(substr($nic, 9, 1)); // Get the last character and convert to uppercase

                        if ($lastChar !== 'V') {
                            $data['NIC_err'] = 'Invalid NIC number';
                        }
                        if(!is_numeric(substr($nic, 0, 9))){
                            $data['NIC_err'] = 'Invalid NIC number';
                        }
                    }
                    if (strlen($nic) == 12 && !is_numeric($nic)){
                        $data['NIC_err'] = 'Invalid NIC number';
                    }
                }
                // Validate SLMC
                if (empty($data['SLMC'])) {
                    $data['SLMC_err'] = 'Please enter SLMC registration number';
                } else {
                    $slmc = $data['SLMC'];
                    if (strlen($slmc) < 4 || strlen($slmc) > 5) {
                        $data['SLMC_err'] = 'SLMC registration number must be between 4 and 5 digits';
                    }
                    if($this->doctorModel->findDoctorBySLMC($slmc)){
                        $data['SLMC_err'] = 'Another doctor already has this SLMC';
                    }
                }
                
                //validate charges
                if (empty($data['Charges'])) {
                    $data['Char_err'] = 'Please enter charges';
                } else {
                    $charge = $data['Charges'];
                    if ($charge > 25000 ) {
                        $data['Char_err'] = 'Charges must be less than 25000';
                    }
                }

                // Validate Email
                if(empty($data['Uname'])){
                    $data['Uname_err'] = 'Please enter your email';
                } else{
                    // Check for duplicates
                    if($this->userModel->findUserByUname($data['Uname'])){
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
                if(empty($data['Uname_err']) && empty($data['Pass_err']) && empty($data['C_pass_err'])&& empty($data['NIC_err'])&& empty($data['C_num_err'])&& empty($data['SLMC_err'])&& empty($data['Char_err'])){
                    // Hashing password
                    $data['Pass'] = hash('sha256',$data['Pass']);

                    // Register user
                    if($this->userModel->register_doctor($data)){
                        redirect('users/login');
                    } else{
                        die("Couldn't register the doctor! ");
                    }
                } else {
                    // Load view
                    $this->view('users/register_doctor', $data);
                }


            }else{
                // Get data
                $data = [
                    'F_name' => '',
                    'L_name' => '',
                    'Gender' => '',
                    'NIC' => '',
                    'C_num' => '',
                    'Spec' => '',
                    'SLMC' => '',
                    'Charges' => '',
                    'Approval' => '',
                    'Uname' => '',
                    'Pass' => '',
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'C_num_err' => '',
                    'SLMC_err' => '',
                    'NIC_err' => '',
                    'Char_err' => ''
                ];

                // Load view
                $this->view('users/register_doctor', $data);
            }
        }

        public function register_hospital_staff(){

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
                    'Hospital' => $_POST['hospital'],
                    'Role' => $_POST['role'],
                    'Uname' => trim($_POST['email']),
                    'Pass' => trim($_POST['pass']),
                    'C_pass' => trim($_POST['cpass']),
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'NIC_err' => '',
                    'C_num_err' => ''
                ];


                // Validate Email
                if(empty($data['Uname'])){
                    $data['Uname_err'] = 'Please enter your email';
                } else{
                    // Check for duplicates
                    if($this->userModel->findUserByUname($data['Uname'])){
                        $data['Uname_err'] = 'Another account already has this email';
                    }
                }

                //validate NIC
                if (empty($data['NIC'])) {
                    $data['NIC_err'] = 'Please enter NIC number';
                } else {
                    $nic = $data['NIC'];
                    if (strlen($nic)!=10 && strlen($nic)!=12){
                        $data['NIC_err'] = 'Invalid NIC number';
                    }
                    if (strlen($nic) == 10){
                        $lastChar = strtoupper(substr($nic, 9, 1)); // Get the last character and convert to uppercase

                        if ($lastChar !== 'V') {
                            $data['NIC_err'] = 'Invalid NIC number';
                        }
                        if(!is_numeric(substr($nic, 0, 9))){
                            $data['NIC_err'] = 'Invalid NIC number';
                        }
                    }
                    // }
                    if (strlen($nic) == 12 && !is_numeric($nic)){
                        $data['NIC_err'] = 'Invalid NIC number';
                    }
                }

                // Validate Contact Number
                if(empty($data['C_num'])){
                    $data['C_num_err'] = 'Please enter contact number';
                } else {
                    // Remove any non-numeric characters from the input
                    $cleaned_number = preg_replace('/[^0-9]/', '', $data['C_num']);

                    // Check if the cleaned number is not exactly 10 digits long
                    if(strlen($cleaned_number) !== 10){
                        $data['C_num_err'] = 'Invalid Number';
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
                if(empty($data['Uname_err']) && empty($data['Pass_err']) && empty($data['C_pass_err'])&& empty($data['NIC_err'])&& empty($data['C_num_err'])){
                    // Hashing password
                    $data['Pass'] = hash('sha256',$data['Pass']);

                    // Register user
                    if($this->userModel->register_hospital_staff($data)){
                        redirect('users/login');
                    } else{
                        die("Couldn't register the doctor! ");
                    }
                } else {
                    // Load view
                    $this->view('users/register_hospital_staff', $data);
                }


            }else{
                // Get data
                $data = [
                    'F_name' => '',
                    'L_name' => '',
                    'Gender' => '',
                    'NIC' => '',
                    'C_num' => '',
                    'Hospital' => '',
                    'Role' => '',
                    'Uname' => '',
                    'Pass' => '',
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'NIC_err' => '',
                    'C_num_err' => '',
                    'hospitalNames' => $this->userModel->getHospitalNames()
                ];
                
                // Load the view with the fetched data
                $this->view('users/register_hospital_staff', $data);
            }
            
        }

        public function login(){
            // Check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                session_start();

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

                // Look for Email
                if(!empty($data['Uname'])){
                    $uname = $this->userModel->findUserByUname($data['Uname']);
                    if($uname){
                        if($uname->Approval == 0){
                            $data['Uname_err'] = 'Your account is not approved yet';
                        }
                    } else{
                        $data['Uname_err'] = 'No user found for this email';
                    }
                }

                // Check whether errors are empty
                if(empty($data['Uname_err']) && empty($data['Pass_err'])){
                    // Login the user and check password
                    $loginData = $this->userModel->login($data['Uname'], $data['Pass']);

                    if($loginData){
                        // Session for login
                        $this->createUserSession($loginData);
                    } else{
                        $data['Pass_err'] = 'Username and Password does not match';
                        $this->view('users/login', $data);
                    }
                } else{
                    // Load view with errors
                    $this->view('users/login', $data);
                }

            }else{
                // Get data
                $data = [
                    'Uname' => '',
                    'Pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => ''
                ];

                // Load view
                $this->view('users/login', $data);
            }
        }

        public function createUserSession($loginData){
            $userData = $loginData['userRow'];
            $role = $loginData['role'];

            $_SESSION['userName'] = $userData->First_Name . ' ' . $userData->Last_Name;
            $_SESSION['userEmail'] = $userData->Username;
            $_SESSION['userType'] = $role;
            switch($role){
                case 'Patient':
                    $_SESSION['userID'] = $userData->Patient_ID;
                    break;
                case 'Doctor':
                    $_SESSION['userID'] = $userData->Doctor_ID;
                    break;
                case 'Manager':
                    $_SESSION['userID'] = $userData->HS_ID;
                    break;
                case 'Lab Assistant':
                    $_SESSION['userID'] = $userData->HS_ID;
                    break;
                case 'Pharmacist':
                    $_SESSION['userID'] = $userData->HS_ID;
                    break;
                case 'Admin':
                    $_SESSION['userID'] = $userData->Admin_ID;
                    break;
            }
            if($_SESSION['userType'] == 'Patient'){
                redirect('patient/doc_booking');
            }elseif($_SESSION['userType'] == 'Doctor'){
                redirect('doctor/reservations');
            }elseif($_SESSION['userType'] == 'Admin'){
                redirect('admin/dashboard');
            }elseif($_SESSION['userType'] == 'Manager'){
                redirect('manager/dashboard');
            }elseif($_SESSION['userType'] == 'Lab Assistant'){
                redirect('lab/test_appt_management');
            }elseif($_SESSION['userType'] == 'Pharmacist'){
                redirect('pharmacist/prescription');
            }else{
                redirect('pages/index');
            }
            
        }

        public function logout(){
            session_start();
            // Remove session variables
            session_unset();
            session_destroy();
            redirect('users/login');
        }

    }