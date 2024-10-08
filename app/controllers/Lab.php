<?php
    class Lab extends Controller{
        public function __construct(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->labModel = $this->model('labs');
            $this->userModel = $this->model('user');
            $this->testModel = $this->model('tests');
        }
        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [];
            
            $this->view('lab/test_appt_management', $data);
        }

        /*public function test_management(){
            $data = [];
            $this->view('lab/test_management', $data);
        }*/

        /*public function test_result_upload(){
            $data = [];
            $this->view('lab/test_result_upload', $data);
        }*/

        /*public function completed_tests(){
            $data = [];
            $this->view('lab/completed_tests', $data);
        }*/

       /* public function lab_test_details(){
            $data = [];
            $this->view('lab/lab_test_details', $data);
        }*/
        
        
       public function profile(){
    
            // Get user data from session
            $data = [
                'Uname' => $_SESSION['userEmail'],
                'Name' => $_SESSION['userName'],
                'Type' => $_SESSION['userType'],
                'ID' => $_SESSION['userID']
            ];
    
    
            $lab_data = $this->userModel->hospital_staff_data_fetch($data['ID']);
    
            $data = [
                'ID' => $lab_data->HS_ID,
                'First_Name' => $lab_data->First_Name,
                'Last_Name' => $lab_data->Last_Name,
                'Hospital_ID' => $lab_data->Hospital_ID,
                'Gender' => $lab_data->Gender,
                'NIC' => $lab_data->NIC,
                'C_Num' => $lab_data->Contact_No,
                'Hospital' => $lab_data->Hospital_Name,
                'Role' => $lab_data->Role,
                'Email' => $lab_data->Username,
                'Password' => $lab_data->Password
            ];
    
            $this->view("lab/profile", $data);
        }

        public function profile_update(){
            
            $lab_data = $this->userModel->hospital_staff_data_fetch($_SESSION['userID']);
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
            
                        'ID' => $_SESSION['userID'],
                        'First_Name' => $lab_data->First_Name,
                        'Last_Name' => $lab_data->Last_Name,
                        'Gender' => $lab_data->Gender,
                        'NIC' => $lab_data->NIC,
                        'C_Num' => trim($_POST['cnum']),
                        'Hospital' => $lab_data->Hospital_Name,
                        'Role' => $lab_data->Role,
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
                        redirect('lab/profile');
                    } else{
                        die("Couldn't update the profile!");
                    }
                } else {
                    // Load view with errors
                    $this->view('lab/profile_update', $data);
                }
            }
            else{
                $data = [
                    'ID' => $_SESSION['userID'],
                    'First_Name' => $lab_data->First_Name,
                    'Last_Name' => $lab_data->Last_Name,
                    'Gender' => $lab_data->Gender,
                    'NIC' => $lab_data->NIC,
                    'C_Num' => $lab_data->Contact_No,
                    'Role' => $lab_data->Role,
                    'Username' => $lab_data->Username,
                    'Pass' => '',
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => '',
                    'C_num_err' => ''
                ];
                $this->view("lab/profile_update", $data);
            }
        }

        public function test_management(){
            
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $hospital_data = $this->labModel->hospital_data_fetch($data['ID']);
            $hospital_id = $hospital_data->Hospital_ID;
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
                // Get search parameters from the form
                $T_Name = isset($_POST['T_Name']) ? $_POST['T_Name'] : null;
                $T_ID = isset($_POST['T_ID']) ? $_POST['T_ID'] : null;
                $T_Type = isset($_POST['T_Type']) ? $_POST['T_Type'] : null;
        
                // Perform the search based on the parameters
                $tests = $this->labModel->search_tests_with_id_hospital($T_Name, $T_ID, $T_Type, $hospital_id);
        
            } else {
                $tests = $this->labModel->labassistant_labtest_data_fetch($hospital_id);
    
            }
    
            $types = [];
    
            if($tests){
                foreach ($tests as $test) {
                    if (!in_array($test->Test_Type, $types)) {
                        $types[] = $test->Test_Type;
                    }
                    if($this->labModel->get_appointments_test_hospital($test->Test_ID, $hospital_id)){
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
            $this->view('lab/test_management', $data);
        }

        public function remove_test() {
            $hospital_data = $this->labModel->hospital_data_fetch($_SESSION['userID']);
            $hospital_id = $hospital_data->Hospital_ID;
            if($this->labModel->remove_test($_GET['test_id'], $hospital_id)){
                redirect('manager/test_management');
            } else{
                die("Couldn't delete the test! ");
            }
        }




        /*public function add_lab_test() {
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
                    if ($this->labModel->add_test($data)) {
                        redirect('lab/add_lab_test');
                    } else {
                        die("Couldn't add the test! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('lab/add_lab_test', $data);
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
                $this->view('lab/add_lab_test', $data);
            }
        }      */ 
        

        public function profile_delete(){

            // Get user data from session
            $data = [
                'Uname' => $_SESSION['userEmail'],
                'Name' => $_SESSION['userName'],
                'Type' => $_SESSION['userType'],
                'ID' => $_SESSION['userID']
            ];

            if($this->labModel->lab_profile_delete($data['ID'])){
                redirect('users/logout');
            } else{
                die("Couldn't delete the Lab assistant! ");
            }
        }

        /*public function add_lab_test(){
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
                if($this->labModel->add_lab_test($data)){
                    redirect('admin/test_management');
                } else{
                    die("Couldn't register the test! ");
                }
            } else {
                // Load view with errors
                $this->view('lab/add_lab_test', $data);
            }
            $this->view('lab/add_lab_test', $data);

        }else{
            // Get data
            $data = [
                'T_name' => '',
                'T_type' => '',
                'T_name_err' => '',
                'T_type_err' => ''
            ];

            // Load view
            $this->view('lab/add_lab_test', $data);
        }
        }*/

        /*public function add_lab_test(){
            $data = [];
            $this->view('lab/add_lab_test', $data);
        }*/

        /*// Controller function to handle adding new lab test
        public function add_lab_test() {
            // Check if the form is submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


                // Extract form data
                $data = [
                    'T_name' => trim($_POST['T_name']),
                    'T_type' => trim($_POST['T_type']),
                    'Price' => trim($_POST['Price']),
                    'ID' => $_SESSION['userID'] // Assuming you have the hospital ID stored in session
                ];

                // Validate form data
                if (empty($data['T_name']) || empty($data['T_type']) || empty($data['Price'])) {
                    // Handle validation errors
                    $error = "Please fill in all fields.";
                    // You can redirect or render the form again with error message
                } else {
                    // Call model method to add lab test
                    if ($this->labModel->add_lab_test($data)) {
                        // Lab test added successfully
                        // You can redirect to a success page or render a success message
                    } else {
                        // Failed to add lab test
                        $error = "Failed to add lab test.";
                        // You can redirect or render the form again with error message
                    }
                }
            } else {
                // Render the form view
                $this->view('lab/add_lab_test');
            }
        }*/

        public function add_lab_test() {
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $hospital_data = $this->labModel->hospital_data_fetch($data['ID']);
            $hospital_id = $hospital_data->Hospital_ID;
    
            
            $all_tests = $this->testModel->get_all_tests();
                
            $hospital_tests = $this->labModel->labassistant_labtest_data_fetch($hospital_id);
    
            // Initialize an empty array to hold test data
            $test_names_types = [];
    
            // Iterate through all_tests to filter out unwanted tests
            foreach ($all_tests as $key => $test) {
                $keep_test = true;
    
                foreach ($hospital_tests as $hospital_test) {
                    if ($test->Test_ID == $hospital_test->Test_ID) {
                        $keep_test = false;
                        break; 
                    }
                }
    
                
                if ($keep_test) {
                    $test_names_types[] = [
                        'Test_Name_Test_Type' => $test->Test_Name . ' - ' . $test->Test_Type,
                        'Test_ID' => $test->Test_ID
                    ];
                }
            }
            // Check for POST request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
                // Sanitize strings
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
                // Register user
                $data = [
                    'Tests' => $test_names_types,
                    'T_ID' => $_POST['test_id'],
                    'T_price' => $_POST['test_price'],
                    'T_price_err' => ''
    
                ];
    
                // Validate Test Type
                if(empty($data['T_price'])){
                    $data['T_price_err'] = 'Please enter test price';
                }else{
                    if($data['T_price'] > 50000){
                        $data['T_price_err'] = 'Price should be below LKR 50,000.00';
                    }
                }
    
                // Check whether errors are empty
                if(empty($data['T_price_err'])){
                    // Register user
                    if($this->labModel->add_test($data, $hospital_id)){
                        redirect('lab/test_management');
                    } else{
                        die("Couldn't register the test! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('lab/add_lab_test', $data);
                }
                $this->view('lab/add_lab_test', $data);
    
            }else{
    
    
                // Assign the test data array to $data['Tests']
                $data['Tests'] = $test_names_types;
                $data['T_price_err'] = '';
                $data['T_price'] = '';
    
    
                // Load view
                $this->view('lab/add_lab_test', $data);
            }
        }

        public function test_appt_management(){
            
            // Get user data from session
            $data = [
                'ID' => $_SESSION['userID']
            ];
        
            // Fetch lab data
            $lab_data = $this->labModel->reservation_data_fetch($data['ID']);

            // Prepare an array to hold all lab test details
            $reservationDetails = [];

            // Check if data is fetched successfully
            if ($lab_data) {
                // Iterate over each row of lab data
                
                    // Prepare data for each row
                    $data = [
                        'reservations' => $lab_data
                    ];
                
            } else {
                // Handle case where no data is fetched
                echo "No reservation data found.";
                return;
            }

            
            // Pass the test details to the view
            $this->view("lab/test_appt_management", $data);
        }

        public function lab_test_details(){
            // Check if the user is logged in
            if (!isset($_SESSION['userID'])) {
                header("Location: /login");
                exit;
            }
            
            // Get the logged-in user's ID
            $user_id = $_SESSION['userID'];
        
            // Get the Patient_ID and Date from the URL parameters
            $patient_id = $_GET['patient_id'] ?? null;
            $date = $_GET['date'] ?? null;
        
            // Check if both Patient_ID and Date are provided
            if (!$patient_id || !$date) {
                // Handle the case where the required parameters are missing
                echo "Patient ID or date is missing.";
                return;
            }
        
            // Fetch lab data
            $lab_data = $this->labModel->reservation_date_data_fetch($user_id, $patient_id, $date);

            if($lab_data){
                foreach($lab_data as $data){
                    $data->Start_Time = date('H:i', strtotime($data->Start_Time));
                    $data->End_Time = date('H:i', strtotime($data->End_Time));
                }
            }
        
            // Check if data is fetched successfully
            if ($lab_data) {
                // Prepare data to pass to the view
                $data = [
                    'reservations' => $lab_data
                ];
        
                // Pass the test details to the view
                $this->view("lab/lab_test_details", $data);
            } else {
                // Handle case where no data is fetched
                echo "No reservation data found.";
                return;
            }
        }

        public function collected(){
            $test_res_id = $_GET['test_id'];

            if($this->labModel->collected($test_res_id)){
                redirect('lab/test_appt_management');
            }else{
                die("Couldn't update the status! ");
            }
            
        }


        public function updateStatus(){
            // Check if the user is logged in
            if (!isset($_SESSION['userID'])) {
                // Redirect or handle the case where the user is not logged in
                // For example:
                header("Location: /login");
                exit;
            }
        
            // Get the logged-in user's ID
            $user_id = $_SESSION['userID'];

            // Get the Patient_ID and Date from the URL parameters
            $patient_id = $_GET['patient_id'] ?? null;
            $date = $_GET['date'] ?? null;
        
            // Check if both Patient_ID and Date are provided
            if (!$patient_id || !$date) {
                // Handle the case where the required parameters are missing
                echo "Patient ID or date is missing.";
                return;
            }
        
            // Get the Test_Res_ID and new status from the POST data
            $test_res_id = $_POST['test_res_id'] ?? null;
            $new_status = $_POST['new_status'] ?? null;;
        
            // Check if both Test_Res_ID and new status are provided
            if (!$test_res_id || !$new_status) {
                // Handle the case where the required parameters are missing
                echo "Test reservation ID or new status is missing.";
                return;
            }
        
            // Call the model function to update the status
            $update_status = $this->labModel->updateReservationStatus($test_res_id, $new_status, $patient_id, $date);
        
            // Check if the status is updated successfully
            if ($update_status) {
                // Redirect the user back to the lab_test_details page
                header("Location:/lab/lab_test_details?patient_id={$patient_id}&date={$date}");
                exit;
            } else {
                // Handle case where status update fails
                echo "Failed to update status.";
                return;
            }
        }


        public function test_result_upload(){
            $data = [];
            // Check if the user is logged in
            if (!isset($_SESSION['userID'])) {
                // Redirect or handle the case where the user is not logged in
                // For example:
                header("Location: /login");
                exit;
            }
            
            // Get the logged-in user's ID
            $user_id = $_SESSION['userID'];
        
            // Fetch lab data
            $lab_data = $this->labModel->pending_test_data_fetch($user_id);
        
            // Check if data is fetched successfully
            if ($lab_data) {
                // Prepare data to pass to the view
                $data = [
                    'reservations' => $lab_data
                ];
        
                // Pass the test details to the view
                $this->view("lab/test_result_upload", $data);
            } else {
                $this->view("lab/test_result_upload", $data);
            }
        }

        public function completed_tests(){
            // Check if the user is logged in
            if (!isset($_SESSION['userID'])) {
                // Redirect or handle the case where the user is not logged in
                // For example:
                header("Location: /login");
                exit;
            }
            
            // Get the logged-in user's ID
            $user_id = $_SESSION['userID'];
        
            // Fetch lab data
            $lab_data = $this->labModel->completed_test_data_fetch($user_id);
        
            // Check if data is fetched successfully
            if ($lab_data) {
                // Prepare data to pass to the view
                $data = [
                    'reservations' => $lab_data
                ];
        
                // Pass the test details to the view
                $this->view("lab/completed_tests", $data);
            } else {
                // Handle case where no data is fetched
                echo "No reservation data found.";
                return;
            }
        }

        /*public function test_management(){
            
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $hospital_data = $this->labModel->lab_data_fetch($data['ID']);
            $hospital_id = $hospital_data->Hospital_ID;
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
                // Get search parameters from the form
                $T_Name = isset($_POST['T_Name']) ? $_POST['T_Name'] : null;
                $T_ID = isset($_POST['T_ID']) ? $_POST['T_ID'] : null;
                $T_Type = isset($_POST['T_Type']) ? $_POST['T_Type'] : null;
        
                // Perform the search based on the parameters
                $tests = $this->labModel->search_tests_with_id_hospital($T_Name, $T_ID, $T_Type, $hospital_id);
        
            } else {
                $tests = $this->labModel->labassistant_labtest_data_fetch($hospital_id);
    
            }
    
            $types = [];
    
            if($tests){
                foreach ($tests as $test) {
                    if (!in_array($test->Test_Type, $types)) {
                        $types[] = $test->Test_Type;
                    }
                    if($this->labModel->get_appointments_test_hospital($test->Test_ID, $hospital_id)){
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
            $this->view('lab/test_management', $data);
        }*/


        public function upload_file(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
                $data = [
                    'patientName' => $_POST['patientName'],
                    'testName' => $_POST['testName'],
                    'testType' => $_POST['testType'],
                    'Res_ID' => $_POST['resId'],
                    'file' => $_FILES['file'],
                    'file_err' => ''
                ];
    
                // Validate File
                if (empty($_FILES['file']['name'])) {
                    $data['file_err'] = 'Please select a file';
                } else {
                    // Check file type
                    $file_name = $_FILES['file']['name'];
                    $file_tmp = $_FILES['file']['tmp_name'];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
                    $allowed_exts = array('pdf');
            
                    if (!in_array($file_ext, $allowed_exts)) {
                        $data['file_err'] = 'File type not allowed. Please upload a PDF file.';
                    }
                }
                
            
                // If file error is empty, proceed with upload
                if (empty($data['file_err'])) {
                    // Get the last name of the patient
                    $first_name = explode(' ', $data['patientName'])[0];
                    $last_name = explode(' ', $data['patientName'])[1];
                    $res_id = $data['Res_ID'];
                    // Sanitize patient name for file name generation
                    $file_name = $first_name . '_' . $last_name . '_Results_' . $res_id . '.pdf';

                    // Process file upload
                    $file_destination = APPROOT . '/results_upload/' . $file_name;
                
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        $data['file'] = $file_name;
                
                        if ($this->labModel->upload_result($data)) {
                            redirect('lab/test_result_upload');
                        } else {
                            die("Couldn't register the test! ");
                        }
                    } else {
                        // Error moving file
                        $data['file_err'] = 'Error uploading the file. Please try again.';
                    }
                }
                
                // Load view with errors if any
                $this->view('lab/upload_file', $data);
    
            }else{
                // Assign the test data array
                
                $res_id = $_GET['test_id'];
                $reservation_data = $this->labModel->get_reservation_data($res_id);
                $data = [
                    'patientName' => $reservation_data->First_Name . ' ' . $reservation_data->Last_Name,
                    'testName' => $reservation_data->Test_Name,
                    'testType' => $reservation_data->Test_Type,
                    'Res_ID' => $res_id,
                    'file_err' => ''
                ];
                // Load view
                $this->view('lab/upload_file', $data);
            }

            $this->view('lab/upload_file', $data);
        }




        
        


    

   
}