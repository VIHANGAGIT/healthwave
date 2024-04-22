<?php
    class Doctor extends Controller{
        public function __construct(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->doctorModel = $this->model('doctors');
            $this->testModel = $this->model('tests');
        }
        public function index(){
            
            $data = [];
            $schedule = $this->doctorModel->get_reservations($_SESSION['userID']);
            $data = [
                'schedule' => $schedule
            ];            
            $this->view('doctor/schedules', $data);
        }

        public function schedules(){
            $data = [];
            $schedule = $this->doctorModel->get_reservations($_SESSION['userID']);
            $data = [
                'schedule' => $schedule
            ];
            $this->view('doctor/schedules', $data);
        }

        public function consultations(){
            $doctorId = $_SESSION['userID'];
            $consultations = $this->doctorModel->get_past_consultations($doctorId);
            $data = [
                'consultations' => $consultations
            ];
            $this->view('doctor/consultations', $data);
        }

        public function ongoing_consults(){
            $doctorId = $_SESSION['userID'];
            $remaining_patients = 0;
            $schedule = $this->doctorModel->get_current_schedule($doctorId);
            $reservations = [];
            if($schedule){
                $reservations = $this->doctorModel->get_ongoing_reservations($schedule->Schedule_ID,$schedule->Time_Start,$schedule->Time_End);
                foreach($reservations as $reservation){
                    $Age = date_diff(date_create($reservation->DOB), date_create('now'))->y;
                    $reservation->Age = $Age;
                    $remaining_patients++;
                }
            }
            $data = [
                'schedule' => $schedule,
                'reservations' => $reservations,
                'remaining_patients' => $remaining_patients
            ];
            $this->view('doctor/ongoing_consults', $data);
        }

        public function get_patient_details(){
            $patient_id = $_POST['patient_id'];
            $type = $_POST['type'];
            $patient = $this->doctorModel->get_patient_details($patient_id, $type);
            $patient->Age = date_diff(date_create($patient->DOB), date_create('now'))->y;
            $patient->Name = $patient->First_Name . ' ' . $patient->Last_Name;
            echo json_encode($patient);
        }

        public function prescription(){
            if(isset($_GET['patient_id']) && isset($_GET['res_id'])){
                $patient_id = $_GET['patient_id'];
                $res_id = $_GET['res_id'];
                $patient = $this->doctorModel->get_patient_details($patient_id, 'patient');
                $patient->Age = date_diff(date_create($patient->DOB), date_create('now'))->y;
                $tests = $this->testModel->get_all_tests();
                $durations = ['1 Day', '2 Days', '3 Days', '4 Days', '5 Days', '6 Days', '1 Week', '2 Weeks', '3 Weeks', '1 Month', '2 Months', '3 Months', '4 Months', '5 Months', '6 Months', '1 Year'];
                $data = [
                    'patient' => $patient,
                    'tests' => $tests,
                    'durations' => $durations,
                    'res_id' => $res_id
                ];
                $this->view('doctor/prescription', $data);
            }else{
                redirect('page/not_found');
            }
            
        }

        public function add_prescription(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $patientId = $_POST['patient_id'];
                $resId = $_POST['res_id'];
                $diagnosis = $_POST['diagnosis'];
                $remarks = $_POST['remarks'];
                $referral = $_POST['referals'];

                // Process drug details
                $drugDetails = [];
                $numberOfDrugs = count($_POST['drug_name']);
                for ($i = 0; $i < $numberOfDrugs; $i++) {
                    $drugDetails[] = [
                        'drug_name' => $_POST['drug_name'][$i],
                        'amount' => $_POST['amount'][$i],
                        'amount_unit' => $_POST['amount_unit'][$i],
                        'frequency' => $_POST['frequency'][$i],
                        'duration' => $_POST['duration'][$i]
                    ];
                }

                $drugDetails = json_encode($drugDetails);
                $testDetails = json_encode($_POST['tests']);

                $consultationId = $this->doctorModel->add_consultation($resId, null, null);

                $this->doctorModel->add_prescription($consultationId, $diagnosis, $remarks, $referral, $drugDetails, $testDetails);

                // redirect('doctor/ongoing_consults');

                
            }else{
                redirect('page/not_found');
            }
            
        }
        
        public function profile(){
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
                    // Load view
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