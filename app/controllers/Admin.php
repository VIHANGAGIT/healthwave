<?php
    class Admin extends Controller{
        public function __construct(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start(); 
            }
            $this->adminModel = $this->model('admins');
            $this->userModel = $this->model('user');
            $this->doctorModel = $this->model('doctors');
            $this->testModel = $this->model('tests');
            $this->hospitalModel = $this->model('hospitals');
            $this->scheduleModel = $this->model('schedules');
        }
        public function index(){
            $data = [];

            $patients = $this->adminModel->get_patients();
            $doctors = $this->adminModel->get_doctors();
            $hospitals = $this->adminModel->get_hospitals();


            $statistic = $this->adminModel->get_statistic();
            $statistic['total_reservations'] = $statistic['total_doc_reservations'] + $statistic['total_test_reservations'];
            $statistic['total_upcoming'] = $statistic['total_upcoming_doc_reservations'] + $statistic['total_upcoming_test_reservations'];

            // Initialize an array to store the total reservations for each month
            $monthlyReservations = [];

            // Loop through the data to calculate the total reservations for each month
            foreach ($statistic['total_res_date'] as $item) {
                $date = new DateTime($item->total_reservations_dates);

                $monthYear = $date->format('Y-m');

                // Check if the month already exists in the array
                if (array_key_exists($monthYear, $monthlyReservations)) {
                    // Increment the count for the existing month
                    $monthlyReservations[$monthYear]++;
                } else {
                    // Initialize the count for a new month
                    $monthlyReservations[$monthYear] = 1;
                }
            }

            // Prepare the data for JavaScript
            $months = [];
            $reservationsCount = [];
            foreach ($monthlyReservations as $monthYear => $count) {
                $months[] = date('F Y', strtotime($monthYear)); // Format the month for display
                $reservationsCount[] = $count;
            }

            $months = implode("', '", $months);
            $reservationsCount = implode(', ', $reservationsCount);

            $data = [
                'statistic' => $statistic,
                'months' => $months,
                'reservationsCount' => $reservationsCount,
                'patients' => $patients,
                'doctors' => $doctors,
                'hospitals' => $hospitals
            ];
            

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {

                // Get search parameters from the form
                $report = isset($_POST['report_name']) ? $_POST['report_name'] : null;
                $doctor_ID = isset($_POST['doctor_name']) ? $_POST['doctor_name'] : null;
                $hospital_ID = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : null;
                $patient_ID = isset($_POST['specialization']) ? $_POST['specialization'] : null;
                $no_of_days = isset($_POST['no_of_days']) ? $_POST['no_of_days'] : null;

                $selectedPeriod = intval($no_of_days); // Get the selected time period as an integer

                // Get the current date
                $currentDate = date('Y-m-d');

                // Calculate the date based on the selected period
                $calculatedDate = date('Y-m-d', strtotime("-$selectedPeriod days", strtotime($currentDate)));

                if($report = "doc"){
                    $data['doc_report'] = $this->adminModel->report_doc_appointments($doctor_ID, $hospital_ID, $patient_ID, $calculatedDate);
                    foreach ($data['doc_report'] as $key => $appointment) {
                        $appointment->Start_Time = date('H:i', strtotime($appointment->Start_Time));
                        $appointment->End_Time = date('H:i', strtotime($appointment->End_Time));
                    }
                    $data['test_report'] = '';
                    $data['payment_report'] = '';
                    $this->view('admin/dashboard', $data);
                }elseif($report = "test"){
                    $data['test_report'] = $this->adminModel->report_test_appointments($hospital_ID, $patient_ID, $calculatedDate);
                    foreach ($data['test_report'] as $key => $appointment) {
                        $appointment->Start_Time = date('H:i', strtotime($appointment->Start_Time));
                        $appointment->End_Time = date('H:i', strtotime($appointment->End_Time));
                    }
                    $data['doc_report'] = '';
                    $data['payment_report'] = '';

                    $this->view('admin/dashboard', $data);
                }elseif($report = "payment"){
                    $data['payment_report'] = $this->adminModel->report_payment_details($doctor_ID, $hospital_ID, $patient_ID, $calculatedDate);
                    $data['doc_report'] = '';
                    $data['test_report'] = '';
                    $this->view('admin/dashboard', $data);
                    
                }else{
                    $this->view('admin/dashboard', $data);
                }
        
        
            }else{
                $this->view('admin/dashboard', $data);
            }

            

        }

        public function dashboard(){
            $data = [];

            $patients = $this->adminModel->get_patients();
            $doctors = $this->adminModel->get_doctors();
            $hospitals = $this->adminModel->get_hospitals();


            $statistic = $this->adminModel->get_statistic();
            $statistic['total_reservations'] = $statistic['total_doc_reservations'] + $statistic['total_test_reservations'];
            $statistic['total_upcoming'] = $statistic['total_upcoming_doc_reservations'] + $statistic['total_upcoming_test_reservations'];

            // Initialize an array to store the total reservations for each month
            $monthlyReservations = [];

            // Loop through the data to calculate the total reservations for each month
            foreach ($statistic['total_res_date'] as $item) {
                $date = new DateTime($item->total_reservations_dates);

                $monthYear = $date->format('Y-m');

                // Check if the month already exists in the array
                if (array_key_exists($monthYear, $monthlyReservations)) {
                    // Increment the count for the existing month
                    $monthlyReservations[$monthYear]++;
                } else {
                    // Initialize the count for a new month
                    $monthlyReservations[$monthYear] = 1;
                }
            }

            // Prepare the data for JavaScript
            $months = [];
            $reservationsCount = [];
            foreach ($monthlyReservations as $monthYear => $count) {
                $months[] = date('F Y', strtotime($monthYear)); // Format the month for display
                $reservationsCount[] = $count;
            }

            $months = implode("', '", $months);
            $reservationsCount = implode(', ', $reservationsCount);

            $data = [
                'statistic' => $statistic,
                'months' => $months,
                'reservationsCount' => $reservationsCount,
                'patients' => $patients,
                'doctors' => $doctors,
                'hospitals' => $hospitals
            ];
            

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {

                // Get search parameters from the form
                $report = isset($_POST['report_name']) ? $_POST['report_name'] : null;
                $doctor_ID = isset($_POST['doctor_name']) ? $_POST['doctor_name'] : null;
                $hospital_ID = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : null;
                $patient_ID = isset($_POST['patient_name']) ? $_POST['patient_name'] : null;
                $no_of_days = isset($_POST['no_of_days']) ? $_POST['no_of_days'] : null;

                $selectedPeriod = intval($no_of_days); // Get the selected time period as an integer

                // Get the current date
                $currentDate = date('Y-m-d');

                // Calculate the date based on the selected period
                $calculatedDate = date('Y-m-d', strtotime("-$selectedPeriod days", strtotime($currentDate)));

                if($report == "doc"){
                    $data['doc_report'] = $this->adminModel->report_doc_appointments($doctor_ID, $hospital_ID, $patient_ID, $calculatedDate);
                    foreach ($data['doc_report'] as $key => $appointment) {
                        $appointment->Start_Time = date('H:i', strtotime($appointment->Start_Time));
                        $appointment->End_Time = date('H:i', strtotime($appointment->End_Time));
                    }
                    $data['test_report'] = '';
                    $data['payment_report'] = '';
                    $this->view('admin/dashboard', $data);
                }elseif($report == "test"){
                    $data['test_report'] = $this->adminModel->report_test_appointments($hospital_ID, $patient_ID, $calculatedDate);
                    foreach ($data['test_report'] as $key => $appointment) {
                        $appointment->Start_Time = date('H:i', strtotime($appointment->Start_Time));
                        $appointment->End_Time = date('H:i', strtotime($appointment->End_Time));
                    }
                    $data['doc_report'] = '';
                    $data['payment_report'] = '';

                    $this->view('admin/dashboard', $data);
                }else{
                    $this->view('admin/dashboard', $data);
                }
        
        
            }else{
                $this->view('admin/dashboard', $data);
            }

        }

        public function profile(){
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
            $doctors = $this->adminModel->get_pending_doctors();
            $managers = $this->adminModel->get_pending_managers();


            if($managers){
                foreach ($managers as $manager) {
                    $current = $this->adminModel->get_current_manager($manager->Hospital_ID);
                    if($current){
                        $manager->Current_Manager = $current->currentID;
                    }else{
                        $manager->Current_Manager = '';
                    }
                }
            }
            

            $data = [
                'doctors' => $doctors,
                'managers' => $managers
            ];
            $this->view('admin/approvals', $data);
        }

        public function approve(){
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                if (isset($_GET['id']) && isset($_GET['email']) && isset($_GET['type'])) {
                    $id = $_GET['id'];
                    $Email = $_GET['email'];
                    $type = $_GET['type'];
                    if ($type == 'doctor') {
                        $mail_data = $this->adminModel->approve_doctor($id);
                        $text = 'your appointments';
                        $role = '<b>Doctor</b>';
                    } else {
                        $current = $_GET['current'];
                        if ($current != null) {
                            $this->adminModel->remove_current_manager($current);
                        }
                        $mail_data = $this->adminModel->approve_manager($id);
                        $text = 'the hospital details';
                        $role = '<b>Hospital Manager</b>';
                    }
                    if ($mail_data) {
                        try {
                            require_once APPROOT.'/helpers/Mail.php';
                            $mail = new Mail();
                    
                            // Prepare the email details
                            $to = $Email;
                            $subject = 'Account Approval Confirmation';
                            $body = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #505050; background-color: #f9f9f9; margin: 0; padding: 0;">';
                            $body .= '<div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">';
                            $body .= '<h1 style="text-align: center; color: #4070f4;">Hello ' . $mail_data->First_Name . ' ' . $mail_data->Last_Name . ',</h1>';
                            $body .= '<p style="font-size: 16px; margin-bottom: 20px; text-align: center;">Your HealthWave account as a '.$role.' has been approved.</p>';
                            $body .= '<div style="margin-bottom: 20px;">';
                            $body .= '</div>';
                            $body .= '<p class="note" style="font-size: 14px; margin-bottom: 10px; text-align: center;">You can now log in to your HealthWave account and start managing '. $text .'</p>';
                            $body .= '<p class="note" style="font-size: 14px; margin-bottom: 10px; text-align: center;">Thank you for joining HealthWave!</p>';
                            $body .= '</div>';
                            $body .= '</body></html>';

                            // Send the email
                            $result = $mail->send($to, $subject, $body);
                    
                            if ($result) {
                                $response =  'Approved. Email sent.';
                            } else {
                                $response = 'Failed to send email. Please contact support.';
                            }
                        } catch (Exception $e) {
                            $response = 'An error occurred. Please try again later.';
                            // Log the exception for debugging
                            error_log($e->getMessage());
                        }
                        echo json_encode($response);
                        redirect('admin/approvals');
                    } else {
                        die('Something went wrong');
                    }
                }
            }
        }

        public function decline(){
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                if (isset($_GET['id']) && isset($_GET['email']) && isset($_GET['type'])){
                    $id = $_GET['id'];
                    $Email = $_GET['email'];
                    $type = $_GET['type'];
                    if ($type == 'doctor') {
                        $mail_data = $this->adminModel->decline_doctor($id);
                        $role = '<b>Doctor</b>';
                    } else {
                        $mail_data = $this->adminModel->decline_manager($id);
                        $role = '<b>Hospital Manager</b>';
                    }
                    if ($mail_data) {
                        try {
                            require_once APPROOT.'/helpers/Mail.php';
                            $mail = new Mail();
                        
                            // Prepare the email details
                            $to = $Email;
                            $subject = 'Account Declined';
                            $body = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #505050; background-color: #f9f9f9; margin: 0; padding: 0;">';
                            $body .= '<div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">';
                            $body .= '<h1 style="text-align: center; color: #f44336;">Hello ' . $mail_data->First_Name . ' ' . $mail_data->Last_Name . ',</h1>';
                            $body .= '<p style="font-size: 16px; margin-bottom: 20px; text-align: center;">We regret to inform you that your HealthWave account as a '.$role.' has been declined.</p>';
                            $body .= '<div style="margin-bottom: 20px;">';
                            $body .= '</div>';
                            $body .= '<p class="note" style="font-size: 14px; margin-bottom: 10px; text-align: center;">If you believe this is a mistake or have any questions, please contact support.</p>';
                            $body .= '<p class="note" style="font-size: 14px; margin-bottom: 10px; text-align: center;">Thank you for considering HealthWave.</p>';
                            $body .= '</div>';
                            $body .= '</body></html>';
                        
                            // Send the email
                            $result = $mail->send($to, $subject, $body);
                        
                            if ($result) {
                                $response = 'Declined. Email sent.';
                            } else {
                                $response = 'Failed to send email. Please contact support.';
                            }
                        } catch (Exception $e) {
                            $response = 'An error occurred. Please try again later.';
                            // Log the exception for debugging
                            error_log($e->getMessage());
                        }
                        
                        echo json_encode($response);
                        redirect('admin/approvals');
                    } else {
                        die('Something went wrong');
                    }
                }
            }
        }

        

        public function doc_management(){
            $data = [];
            //$doctor =  new Doctors();
            //$doctors = $doctor->getAllDoctors();
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
                // Get search parameters from the form
                $doctorName = isset($_POST['doctor_name']) ? $_POST['doctor_name'] : null;
                $hospitalName = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : null;
                $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : null;
        
                // Perform the search based on the parameters
                $doctors = $this->doctorModel->search_doctors($doctorName, $hospitalName, $specialization);
        
            } else {
                $doctors = $this->doctorModel->getAllDoctors();

            }
            $hospitals = $this->adminModel->getHospitals();

            $specializations = [];

            foreach ($doctors as $doctor) {
                if (!in_array($doctor->Specialization, $specializations)) {
                    $specializations[] = $doctor->Specialization;
                }
                if($this->adminModel->get_appointments($doctor->Doctor_ID)){
                    $doctor->Cancel = 'Not allowed';
                }else{
                    $doctor->Cancel = 'Allowed';
                }
            }
            $data = [
                'doctors' => $doctors,
                'hospitals' => $hospitals,
                'specializations' => $specializations
            ];
            $this->view('admin/doc_management', $data);
        }

        public function test_management(){

            $data = [];
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
                // Get search parameters from the form
                $T_Name = isset($_POST['T_Name']) ? $_POST['T_Name'] : null;
                $T_ID = isset($_POST['T_ID']) ? $_POST['T_ID'] : null;
                $T_Type = isset($_POST['T_Type']) ? $_POST['T_Type'] : null;
        
                // Perform the search based on the parameters
                $tests = $this->testModel->search_tests_with_id($T_Name, $T_ID, $T_Type);
        
            } else {
                $tests = $this->testModel->get_all_tests();

            }

            $types = [];

            if($tests){
                foreach ($tests as $test) {
                    if (!in_array($test->Test_Type, $types)) {
                        $types[] = $test->Test_Type;
                    }
                    if($this->adminModel->get_appointments_test($test->Test_ID)){
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
            $this->view('admin/test_management', $data);
        }

        public function hospital_management(){
            $data = [];
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
                // Get search parameters from the form
                $H_name = isset($_POST['H_name']) ? $_POST['H_name'] : null;
                $H_ID = isset($_POST['H_ID']) ? $_POST['H_ID'] : null;
                $H_region = isset($_POST['H_region']) ? $_POST['H_region'] : null;
        
                // Perform the search based on the parameters
                $hospitals = $this->hospitalModel->search_hospitals($H_name, $H_ID, $H_region);
        
            } else {
                $hospitals = $this->hospitalModel->getAllHospitals();

            }

            $regions = [];

            foreach ($hospitals as $hospital) {
                if (!in_array($hospital->Region, $regions)) {
                    $regions[] = $hospital->Region;
                }
                if($this->adminModel->get_appointments_hospital($hospital->Hospital_ID)){
                    $hospital->Cancel = 'Not allowed';
                }else{
                    $hospital->Cancel = 'Allowed';
                }
            }
            $data = [
                'hospitals' => $hospitals,
                'regions' => $regions
            ];
            $this->view('admin/hospital_management', $data);
            
        }

        public function doc_reservations(){
            $data = [];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(isset($_POST['app_search'])){
                    // Get search parameters from the form
                    $patient_name = isset($_POST['patient_name']) ? $_POST['patient_name'] : null;
                    $doctor_name = isset($_POST['doctor_name']) ? $_POST['doctor_name'] : null;
                    $hospital_name = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : null;
                    $date = isset($_POST['date']) ? $_POST['date'] : null;

                    // Perform the search based on the parameters
                    $doc_appointments = $this->adminModel->search_doc_appointments($patient_name, $doctor_name, $hospital_name, $date);

                    foreach ($doc_appointments as $key => $appointment) {
                        if ($appointment->Date == date('Y-m-d') && $appointment->Time_End < date('H:i:s')) {
                            unset($doc_appointments[$key]);
                        }
                        $appointment->Start_Time = date('H:i', strtotime($appointment->Start_Time));
                        $appointment->End_Time = date('H:i', strtotime($appointment->End_Time));
                    }

                    $data = [
                        'doc_appointments' => $doc_appointments
                    ];
                    $this->view('admin/doc_reservations', $data);

                 }
                
            } else {
                $this->view('admin/doc_reservations', $data);
            }
            $this->view('admin/doc_reservations', $data);
        }

        public function test_reservations(){
            $data = [];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(isset($_POST['test_search'])){
                    // Get search parameters from the form
                    $patient_name = isset($_POST['patient_name']) ? $_POST['patient_name'] : null;
                    $test_name = isset($_POST['test_name']) ? $_POST['test_name'] : null;
                    $hospital_name = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : null;
                    $date = isset($_POST['date']) ? $_POST['date'] : null;
            
                    // Perform the search based on the parameters
                    $test_appointments = $this->adminModel->search_test_appointments($patient_name, $test_name, $hospital_name, $date);

                    foreach ($test_appointments as $key => $appointment) {
                        if ($appointment->Date == date('Y-m-d') && $appointment->Start_Time > date('H:i:s')) {
                            unset($test_appointments[$key]);
                        }
                        $appointment->Start_Time = date('H:i', strtotime($appointment->Start_Time));
                        $appointment->End_Time = date('H:i', strtotime($appointment->End_Time));
                    }

                    $data = [
                        'test_appointments' => $test_appointments
                    ];
                    $this->view('admin/test_reservations', $data);
                }
                
            } else {
                $this->view('admin/test_reservations', $data);
            }
            $this->view('admin/test_reservations', $data);
        }

        public function add_hospital(){
            // Check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

               // Sanitize strings
               $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

               // Register user
               $data = [
                   'H_name' => trim($_POST['hname']),
                   'H_address' => trim($_POST['haddress']),
                   'Region' => trim($_POST['region']),
                   'H_charge' => trim($_POST['hcharge']),
                   'C_num' => trim($_POST['cnum']),
                   'H_name_err' => '',
                   'H_address_err' => '',
                   'Region_err' => '',
                   'H_charge_err' => '',
                   'C_num_err' => ''
               ];

               // Validate Hospital Name
               if (empty($data['H_name'])) {
                   $data['H_name_err'] = 'Please enter hospital name';
               } else {
                   // Check for duplicate hospital names
                   if ($this->hospitalModel->findHospitalByName($data['H_name'])) {
                       $data['H_name_err'] = 'Hospital name already exists';
                   }
               }

               // Validate Hospital Address
               if (empty($data['H_address'])) {
                   $data['H_address_err'] = 'Please enter hospital address';
               } else if ($data['H_name_err'] == ''){
                   // Check if the hospital address already exists in the database
                   if ($this->hospitalModel->findHospitalByAddress($data['H_address'])) {
                       $data['H_address_err'] = 'This address is already taken';
                   }
               }

               // Validate Region
               if(empty($data['Region'])){
                   $data['Region_err'] = 'Please enter region';
               }

               // Validate Hospital Charge
               if(empty($data['H_charge'])){
                   $data['H_charge_err'] = 'Please enter hospital charge';
               }else{
                   if($data['H_charge'] > 25000){
                       $data['H_charge_err'] = 'Charge must be less than 25000';
                   }
               }

               // Validate Contact Number
               if(empty($data['C_num'])){
                   $data['C_num_err'] = 'Please enter contact number';
               } else {
                   // Remove any non-numeric characters from the input
                   $cleaned_number = preg_replace('/[^0-9]/', '', $data['C_num']);

                   if(strlen($cleaned_number) !== 10){
                       $data['C_num_err'] = 'Invalid Number';
                   }else{
                    if(substr($cleaned_number, 0, 1) != '0'){
                        $data['C_num_err'] = 'Invalid Number';
                    }
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
                   'C_num' => '',
                   'H_name_err' => '',
                   'H_address_err' => '',
                   'Region_err' => '',
                   'H_charge_err' => '',
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
                    'Spec' => $_POST['spec'],
                    'SLMC' => $_POST['slmc'],
                    'Charges' => $_POST['charges'],
                    'Uname' => trim($_POST['email']),
                    'Pass' => trim($_POST['pass']),
                    'C_pass' => trim($_POST['cpass']),
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'C_num_err' => '',
                    'SLMC_err' => '',
                    'Char_err' => '',
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
                    }
                }

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

                if (empty($data['Charges'])) {
                    $data['Char_err'] = 'Please enter charges';
                } else {
                    $charge = $data['Charges'];
                    if ($charge > 25000 ) {
                        $data['Char_err'] = 'Charges must be less than 25000';
                    }
                }

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
                if(empty($data['Uname_err']) && empty($data['Pass_err']) && empty($data['C_pass_err'])&& empty($data['C_num_err'])&& empty($data['SLMC_err'])&& empty($data['Char_err'])){
                    // Hashing password
                    $data['Pass'] = hash('sha256',$data['Pass']);

                    // Register user
                    if($this->adminModel->add_doctor($data)){
                        try {
                            require_once APPROOT.'/helpers/Mail.php';
                            $mail = new Mail();
                    
                            // Prepare the email details
                            $to = $data['Uname'];
                            $subject = 'Account Activation';
                            $body = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #505050; background-color: #f9f9f9; margin: 0; padding: 0;">';
                            $body .= '<div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">';
                            $body .= '<h1 style="text-align: center; color: #4070f4;">Hello Dr. ' . $data['F_name'] . ' ' . $data['L_name'] . ',</h1>';
                            $body .= '<p style="font-size: 16px; margin-bottom: 20px; text-align: center;">You have been as a Doctor to HealthWave system.</p>';
                            $body .= '<div style="margin-bottom: 20px; text-align: center;">';
                            $body .= '<p style="font-size: 14px; margin-bottom: 10px;">Username: ' .  $data['Uname'] . '</p>';
                            $body .= '<p style="font-size: 14px; margin-bottom: 10px;">Temporary Password: ' .  $data['C_pass'] . '</p>';
                            $body .= '</div>';
                            $body .= '<p class="note" style="font-size: 14px; margin-bottom: 10px; text-align: center;">Please use the provided username and password to log in to your HealthWave account.</p>';
                            $body .= '<p class="note" style="font-size: 14px; margin-bottom: 10px; text-align: center;">After logging in, we recommend changing your password for security reasons.</p>';
                            $body .= '<p class="note" style="font-size: 14px; margin-bottom: 10px; text-align: center;">Thank you for joining HealthWave!</p>';
                            $body .= '</div>';
                            $body .= '</body></html>';

                            // Send the email
                            $result = $mail->send($to, $subject, $body);
                    
                            if ($result) {
                                $response =  'Doctor Added. Email sent.';
                            } else {
                                $response = 'Failed to send email. Please contact support.';
                            }
                        } catch (Exception $e) {
                            $response = 'An error occurred. Please try again later.';
                            // Log the exception for debugging
                            error_log($e->getMessage());
                        }
                        echo json_encode($response);
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
                    'NIC' => '',
                    'C_num' => '',
                    'Spec' => '',
                    'SLMC' => '',
                    'Charges' => '',
                    'Uname' => '',
                    'Pass' => '',
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'C_num_err' => '',
                    'SLMC_err' => '',
                    'Char_err' => '',
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
                }else{
                    // Check for duplicate test names
                    if($this->testModel->findTestByName($data['T_name'])){
                        $data['T_name_err'] = 'Test already exists';
                    }
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

        public function edit_test() {
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
                }else{
                    // Check for duplicate test names
                    $existing_test = $this->testModel->findTestByName($data['T_name']);
                    if($existing_test && $data['T_type'] && $existing_test->Test_Type == $data['T_type']){
                        $data['T_name_err'] = 'Test already exists';
                    }
                }

                // Validate Test Type
                if(empty($data['T_type'])){
                    $data['T_type_err'] = 'Please enter test type';
                }

                // Check whether errors are empty
                if(empty($data['T_name_err']) && empty($data['T_type_err'])){
                    // Register user
                    if($this->adminModel->update_test($data)){
                        redirect('admin/test_management');
                    } else{
                        die("Couldn't update the test! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('admin/edit_test', $data);
                }

            }else{
                $test_id = $_GET['test_id'];

                $test_data = $this->adminModel->test_data_fetch($test_id);
                
                $data = [
                    'ID' => $test_data->Test_ID,
                    'T_name' => $test_data->Test_Name,
                    'T_type' => $test_data->Test_Type,
                    'T_name_err' => '',
                    'T_type_err' => ''
                ];
                
                // Load view
                $this->view('admin/edit_test', $data);
            }

            // Load view
            $this->view('admin/edit_test', $data);
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
                    'C_num' => trim($_POST['cnum']),
                    'H_name_err' => '',
                    'H_address_err' => '',
                    'Region_err' => '',
                    'H_charge_err' => '',
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
                }else{
                    if($data['H_charge'] > 25000){
                        $data['H_charge_err'] = 'Charge must be less than 25000';
                    }
                }

                 // Validate Contact Number
                 if(empty($data['C_num'])){
                    $data['C_num_err'] = 'Please enter contact number';
                } else {
                    // Remove any non-numeric characters from the input
                    $cleaned_number = preg_replace('/[^0-9]/', '', $data['C_num']);

                    if(strlen($cleaned_number) !== 10){
                        $data['C_num_err'] = 'Invalid Number';
                    } else {
                        if(substr($cleaned_number, 0, 1) != '0'){
                            $data['C_num_err'] = 'Invalid Number';
                        }
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

        public function remove_reservation(){
            $res_id = $_GET['res_id'];
            if($this->doctorModel->delete_reservation($res_id)){
                redirect('admin/doc_reservations');
            } else{
                die("Couldn't remove the reservation! ");
            }    
        }

        public function edit_reservation(){
            //check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //add test
                $data = [
                    'res_id' => $_POST['res_id'],
                    'date' => $_POST['date'],
                    'app_no' => $_POST['app_no'],
                    'time' => $_POST['time']
                ];

                $data['start_time'] = substr($data['time'], 0, 8);
                $data['end_time'] = substr($data['time'], 11, 8);
                
                if($this->adminModel->edit_reservation($data)){
                    redirect('admin/doc_reservations');
                }else{
                    die("Couldn't edit the reservation! ");
                }

            }else{
                
                $res_id = $_GET['res_id'];

                $reservation_data = $this->adminModel->reservation_data_fetch($res_id);
                $schedule_data = $this->adminModel->get_schedule_days($reservation_data->Doctor_ID, $reservation_data->Hospital_ID);

                $nextDates = array();


                foreach ($schedule_data as $dayObj) {
                    $dayOfWeek = $dayObj->Day_of_Week;
                
                    $today = new DateTime();
                
                    // Get the current day of the week (numeric representation, 0 for Sunday, 6 for Saturday)
                    $currentDayOfWeek = $today->format('w');
                
                    $providedDayOfWeek = date('w', strtotime($dayOfWeek));
                
                    // Calculate the difference between the current day of the week and the provided day
                    $difference = ($providedDayOfWeek - $currentDayOfWeek + 7) % 7;
                
                    // Modify the date based on the difference
                    $nextDate = $today->modify("+$difference days");
                   
                    $nextDateFormatted = $nextDate->format('Y-m-d');

                    if($nextDateFormatted != $reservation_data->Date){
                        $nextDates[] = $nextDateFormatted;
                    }
                }
                
                
                $data = [
                    'res_id' => $reservation_data->Doc_Res_ID,
                    'patient_name' => $reservation_data->First_Name. ' '. $reservation_data->Last_Name,
                    'nic' => $reservation_data->NIC,
                    'date' => $reservation_data->Date,
                    'app_no' => $reservation_data->Appointment_No,
                    'time' => $reservation_data->Start_Time. ' - '. $reservation_data->End_Time,
                    'next_dates' => $nextDates,
                    'hospital_id' => $reservation_data->Hospital_ID,
                    'doctor_id' => $reservation_data->Doctor_ID
                ];
                
                // Load view
                $this->view('admin/edit_reservation', $data);
            }
        }

        public function get_appointment_data(){
            $hospital_id = $_POST['hospital_id'];
            $doctor_id = $_POST['doctor_id'];
            $date = $_POST['date'];
            
            $scheduleData = $this->scheduleModel->get_schedule_by_hospital_doctor($hospital_id, $doctor_id);

    
            $responseData = array();
    
            foreach ($scheduleData as $schedule) {
                if ($schedule->Day_of_Week != date('D', strtotime($date))) {
                    continue;
                }

                // Fetch booked slots for the current schedule
                $bookedSlots = $this->scheduleModel->fetch_booked_slots($schedule->Schedule_ID, $date);
    
                $lastBookedAppointmentNumber = 0;
    
                // Determine the last booked appointment number
                foreach ($bookedSlots as $bookedSlot) {
                    $lastBookedAppointmentNumber = max($lastBookedAppointmentNumber, $bookedSlot->Appointment_No);
                }
    
                // Generate time slots with 15-minute intervals
                $startTime = strtotime($schedule->Time_Start);
                $endTime = strtotime($schedule->Time_End);
                $timeSlots = array();
                while ($startTime < $endTime) {
                    $timeSlots[] = array(
                        'start_time' => date('H:i:s', $startTime),
                        'end_time' => date('H:i:s', $startTime + 900),
                    );
                    $startTime += 900;
                }
                $nextAppointmentNumber = $lastBookedAppointmentNumber + 1; 
    
                $slotIndex = ceil($nextAppointmentNumber / 2); 
    
                if ($slotIndex <= count($timeSlots)) {
                    $nextTimeSlot = $timeSlots[$slotIndex - 1]; 
                } else {
                    $nextTimeSlot = null;
                }

                $time = $nextTimeSlot['start_time']. ' - '. $nextTimeSlot['end_time'];
    
    
                // Add data to responseData
                $responseData[] = array(
                    'time' => $time,
                    'app_no' => $nextAppointmentNumber
                );
            }
    
            // Send JSON response with schedule data
            echo json_encode($responseData);
            
        }

        public function edit_test_reservation(){
            $data = [];

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //add test
                $data = [
                    'res_id' => $_POST['res_id'],
                    'date' => $_POST['date'],
                    'time' => $_POST['time'],
                    'test_date_err' => ''
                ];

                $data['start_time'] = substr($data['time'], 0, 5). ':00';
                $data['end_time'] = substr($data['time'], 8, 5). ':00';



                // Validate Test Date
                if(empty($data['date'])){
                    $data['test_date_err'] = 'Please enter test date';
                }else{
                    $today = date('Y-m-d');
                    if($data['date'] <= $today){
                        $data['test_date_err'] = 'Test date must be after today';
                    }
                    if(date_diff(date_create($data['date']), date_create($today))->format('%a') > 30){
                        $data['test_date_err'] = 'Test date must be within 30 days from today';
                    }
                }

                if(empty($data['test_date_err'])){
                    if($this->adminModel->edit_test_reservation($data)){
                        redirect('admin/test_reservations');
                    }else{
                        die("Couldn't edit the reservation! ");
                    }
                }else{
                    $reservation_data = $this->adminModel->test_reservation_data_fetch($data['res_id']);
                    $data['patient_name'] = $reservation_data->First_Name. ' '. $reservation_data->Last_Name;
                    $data['nic'] = $reservation_data->NIC;
                    $data['hospital_id'] = $reservation_data->Hospital_ID;
                    $this->view('admin/edit_test_reservation', $data);
                }
            }else{
                    
                $res_id = $_GET['res_id'];

                $reservation_data = $this->adminModel->test_reservation_data_fetch($res_id);

                // $nextDates = array();

                // $Date = $reservation_data->Date;
                // $Date = new DateTime($Date);

                // for ($i=0; $i < 7; $i++) { 
                //     $nextDate = $Date->modify("+1 day");
                //     $nextDateFormatted = $nextDate->format('Y-m-d');
                //     $nextDates[] = $nextDateFormatted;
                // } 


                $data = [
                    'res_id' => $reservation_data->Test_Res_ID,
                    'patient_name' => $reservation_data->First_Name. ' '. $reservation_data->Last_Name,
                    'nic' => $reservation_data->NIC,
                    'date' => $reservation_data->Date,
                    'time' => $reservation_data->Start_Time. ' - '. $reservation_data->End_Time,
                    'hospital_id' => $reservation_data->Hospital_ID,
                    'test_id' => $reservation_data->Test_ID,
                    'test_date_err' => '',
                    // 'next_dates' => $nextDates
                ];

            }

    
                    
            $this->view('admin/edit_test_reservation', $data);
        }

        public function get_reservation_times(){
            $seleted_date = $_POST['date'];
            $hospital_id = $_POST['hospital_id'];

            $startTime1 = strtotime('9:00');
            $endTime1 = strtotime('12:00');
            $startTime2 = strtotime('13:00');
            $endTime2 = strtotime('15:00');

            $timeSlots = array();

            // Loop to generate time slots
            while ($startTime1 < $endTime1) {
                $slotStart = date('H:i', $startTime1);
                $startTime1 += (900); // Add 15 minutes
                $slotEnd = date('H:i', $startTime1);
                $timeSlots[] = array('start_time' => $slotStart, 'end_time' => $slotEnd);
            }

            while ($startTime2 < $endTime2) {
                $slotStart = date('H:i', $startTime2);
                $startTime2 += (900); // Add 15 minutes
                $slotEnd = date('H:i', $startTime2);
                $timeSlots[] = array('start_time' => $slotStart, 'end_time' => $slotEnd);
            }


            $bookedSlots = $this->testModel->fetch_booked_slots($hospital_id, $seleted_date);
            
            foreach ($bookedSlots as $bookedSlot) {
                foreach ($timeSlots as $key => $timeSlot) {
                    if ($timeSlot['start_time'] == $bookedSlot->Start_Time && $timeSlot['end_time'] == $bookedSlot->End_Time) {
                            unset($timeSlots[$key]);
                    }
                }
            }

            // Send JSON response with schedule data
            echo json_encode($timeSlots);
        }

    }