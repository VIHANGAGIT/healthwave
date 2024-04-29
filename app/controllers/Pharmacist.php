<?php
    class Pharmacist extends Controller{
        public function __construct(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start(); 
            }   

            // Load the pharmacist model
            $this->pharmacistModel = $this->model('Pharmacists');
            $this->userModel = $this->model('User');
        }
        public function index(){
            
            $data = [];
            
            $this->view('pharmacist/prescription', $data);
        }

        public function prescription(){
            
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $hospital_data = $this->pharmacistModel->hospital_data_fetch($data['ID']);
            $hospital_id = $hospital_data->Hospital_ID;
        
            // Fetch lab data
            $pres_data = $this->pharmacistModel->pending_prescription_data_fetch($hospital_id);

            // echo json_encode($pres_data);
        
            // Check if data is fetched successfully
            if ($pres_data) {
                // Prepare data to pass to the view
                $data = [
                    'prescriptions' => $pres_data
                ];
        
                // Pass the test details to the view
                $this->view("pharmacist/prescription", $data);
            } else {
                $this->view("pharmacist/prescription", $data);
            }
        }

        public function view_prescription(){
            $prescription_id = $_GET['id'];
            $prescription = $this->pharmacistModel->get_prescription_data($prescription_id);
            $Name = $prescription->First_Name . ' ' . $prescription->Last_Name;
            $Age = date_diff(date_create($prescription->DOB), date_create('now'))->y;
            $Doc_Name = $prescription->Doc_First_Name . ' ' . $prescription->Doc_Last_Name;
    
            $data = [
                'Prescription_ID' => $prescription_id,
                'Name' => $Name,
                'Age' => $Age,
                'Gender' => $prescription->Gender,
                'NIC' => $prescription->NIC,
                'Allergies' => $prescription->Allergies,
                'Date' => $prescription->Date,
                'Doc_Name' => $Doc_Name,
                'Diagnosis' => $prescription->Diagnosis,
                'Remarks' => $prescription->Comments,
                'Referral' => $prescription->Referrals,
                'Drugs' => $prescription->Drug_Details,
                'Tests' => $prescription->Test_Details,
                'Hospital_Name' => $prescription->Hospital_Name,
                'Contact_No' => $prescription->Contact_No,
                'Specialization' => $prescription->Specialization,
                'SLMC_Reg_No' => $prescription->SLMC_Reg_No,
            ];
    
    
            try{
                include_once APPROOT.'/helpers/generate_prescription.php';
            }catch(Exception $e){
                echo $e;
    
            }
        }

        public function complete_prescription(){
            $prescription_id = $_GET['id'];
            if($this->pharmacistModel->complete_prescription($prescription_id)){
                redirect('pharmacist/prescription');
            }
        }

        public function profile(){
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $pharm_data = $this->userModel->hospital_staff_data_fetch($data['ID']);
    
            $data = [
                'ID' => $pharm_data->HS_ID,
                'First_Name' => $pharm_data->First_Name,
                'Last_Name' => $pharm_data->Last_Name,
                'Hospital_ID' => $pharm_data->Hospital_ID,
                'Gender' => $pharm_data->Gender,
                'NIC' => $pharm_data->NIC,
                'C_Num' => $pharm_data->Contact_No,
                'Hospital' => $pharm_data->Hospital_Name,
                'Role' => $pharm_data->Role,
                'Email' => $pharm_data->Username,
                'Password' => $pharm_data->Password
            ];
    
            $this->view("pharmacist/profile", $data);
        }

        public function profile_update(){
            
            $pharm_data = $this->userModel->hospital_staff_data_fetch($_SESSION['userID']);
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
            
                        'ID' => $_SESSION['userID'],
                        'First_Name' => $pharm_data->First_Name,
                        'Last_Name' => $pharm_data->Last_Name,
                        'Gender' => $pharm_data->Gender,
                        'NIC' => $pharm_data->NIC,
                        'C_Num' => trim($_POST['cnum']),
                        'Hospital' => $pharm_data->Hospital_Name,
                        'Role' => $pharm_data->Role,
                        'Username' => trim($_POST['email']),
                        'Pass' => trim($_POST['pass']),
                        'C_pass' => trim($_POST['cpass']),
                        'Uname_err' => '',
                        'Pass_err' => '',
                        'C_pass_err' => '',
                        'C_num_err' => ''
                ];

                if(empty($data['C_Num'])){
                    $data['C_num_err'] = 'Please enter contact number';
                } else {
                    // Remove any non-numeric characters from the input
                    $cleaned_number = preg_replace('/[^0-9]/', '', $data['C_Num']);

                    // Check if the cleaned number is not exactly 10 digits long
                    if(strlen($cleaned_number) !== 10){
                        $data['C_num_err'] = 'Invalid Number';
                    }
                }

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
                if(empty($data['Uname_err']) && empty($data['Pass_err']) && empty($data['C_pass_err']) && empty($data['C_num_err'])){
                    // Hashing password
                    $data['Pass'] = hash('sha256',$data['Pass']);
        
                    if($this->userModel->hospital_staff_profile_update($data)){
                        redirect('pharmacist/profile');
                    } else{
                        die("Couldn't update the profile!");
                    }
                } else {
                    // Load view with errors
                    $this->view('pharmacist/profile_update', $data);
                }
            }
            else{
                $data = [
                    'ID' => $_SESSION['userID'],
                    'First_Name' => $pharm_data->First_Name,
                    'Last_Name' => $pharm_data->Last_Name,
                    'Gender' => $pharm_data->Gender,
                    'NIC' => $pharm_data->NIC,
                    'C_Num' => $pharm_data->Contact_No,
                    'Role' => $pharm_data->Role,
                    'Username' => $pharm_data->Username,
                    'Pass' => '',
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'C_num_err' => ''
                ];
                $this->view("pharmacist/profile_update", $data);
            }
        }

    }