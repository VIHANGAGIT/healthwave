<?php
    class Lab extends Controller{
        protected $userModel;
        protected $labModel;
        public function __construct(){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->labModel = $this->model('labs');
            $this->userModel = $this->model('user');
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

        public function test_result_upload(){
            $data = [];
            $this->view('lab/test_result_upload', $data);
        }

        /*public function profile(){
            $data = [];
            $this->view('lab/profile', $data);
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
                'Hospital' => $lab_data->Hospital,
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
                        //'First_Name' => trim($_POST['fname']),
                        //'Last_Name' => trim($_POST['lname']),
                        'First_Name' => $lab_data->First_Name,
                        'Last_Name' => $lab_data->Last_Name,
                        'Gender' => $lab_data->Gender,
                        //'NIC' => trim($_POST['nic']),
                        'NIC' => $lab_data->NIC,
                        'C_Num' => trim($_POST['cnum']),
                        'Hospital' => $lab_data->Hospital,
                        'Role' => $lab_data->Role,
                        'Username' => trim($_POST['email']),
                        /*'Staff_ID' => $lab_data->Staff_ID,*/
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
                    //'Staff_ID' => $lab_data->Staff_ID,
                    'Pass' => '',
                    'C_pass' => '',
                    'Uname_err' => '',
                    'Pass_err' => '',
                    'C_pass_err' => ''
                ];
                $this->view("lab/profile_update", $data);
            }
        }

        public function test_management(){
            
            // Get user data from session
            $data = [
                'ID' => $_SESSION['userID']
            ];
        
            // Fetch lab data
            $lab_data = $this->labModel->lab_data_fetch($data['ID']);

            // Prepare an array to hold all lab test details
            $testDetails = [];

            // Check if data is fetched successfully
            if ($lab_data) {
                // Iterate over each row of lab data
                
                    // Prepare data for each row
                    $data = [
                        'tests' => $lab_data
                    ];
                
            } else {
                // Handle case where no data is fetched
                echo "No lab test data found.";
                return;
            }

            


            // Pass the test details to the view
            $this->view("lab/test_management", $data);
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
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
                // Extract form data
                $data = [
                    'T_name' => trim($_POST['testname']),
                    'T_type' => trim($_POST['testtype']),
                    'Price' => trim($_POST['price']),
                    'ID' => $_SESSION['userID']
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
        
            // Fetch lab data
            $lab_data = $this->labModel->reservation_date_data_fetch($user_id, $patient_id, $date);
        
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
        


    

   
}
?>



