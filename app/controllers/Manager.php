<?php
    class Manager extends Controller{
        public function __construct(){

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
           
            $this->userModel = $this->model('user');
            $this->managerModel = $this->model('managers');
            $this->testModel = $this->model('tests');
            $this->doctorModel = $this->model('doctors');
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
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $hospital_data = $this->managerModel->hospital_data_fetch($data['ID']);
            $hospital_id = $hospital_data->Hospital_ID;

            $doctors = $this->managerModel->get_doctor_hospital($hospital_id);

            foreach($doctors as $doctor){
                if($this->managerModel->get_appointments_doctor_hospital($doctor->Doctor_ID, $hospital_id)){
                    $doctor->Cancel = 'Not allowed';
                }else{
                    $doctor->Cancel = 'Allowed';
                }
            }


            $data = [
                'doctors' => $doctors
            ];

            $this->view('manager/doc_management', $data);
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
                    if($this->managerModel->add_doctor($data)){
                        redirect('manager/doc_management');
                    } else{
                        die("Couldn't register the doctor! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('manager/add_doctor', $data);
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
                $this->view('manager/add_doctor', $data);
            }
        }


        public function reservations(){
            $data = [];
            $this->view('manager/reservations', $data);
        }

        public function schedule_management(){
            
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $hospital_data = $this->managerModel->hospital_data_fetch($data['ID']);
            $hospital_id = $hospital_data->Hospital_ID;

            $schedule = $this->managerModel->get_schedule_hospital($hospital_id);

            foreach($schedule as $sch){
                $sch->Time_Start = date('H:i', strtotime($sch->Time_Start));
                $sch->Time_End = date('H:i', strtotime($sch->Time_End));

                if($this->managerModel->get_appointments_schedule_hospital($sch->Schedule_ID, $hospital_id)){
                    $sch->Cancel = 'Not allowed';
                }else{
                    $sch->Cancel = 'Allowed';
                }
            }


            $data = [
                'schedules' => $schedule
            ];


            $this->view('manager/schedule_management', $data);
        }

        public function room_management(){
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $hospital_data = $this->managerModel->hospital_data_fetch($data['ID']);
            $hospital_id = $hospital_data->Hospital_ID;

            $rooms = $this->managerModel->get_room_hospital($hospital_id);

            foreach($rooms as $room){

                if($this->managerModel->get_appointments_room_hospital($room->Room_ID, $hospital_id)){
                    $room->Cancel = 'Not allowed';
                }else{
                    $room->Cancel = 'Allowed';
                }
            }


            $data = [
                'rooms' => $rooms
            ];

            $this->view('manager/room_management', $data);
        }

        public function add_room(){
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $hospital_data = $this->managerModel->hospital_data_fetch($data['ID']);
            $hospital_id = $hospital_data->Hospital_ID;

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'Room_Name' => trim($_POST['room_name']),
                    'Hospital_ID' => $hospital_id,
                    'Room_Name_err' => ''
                ];

                // Validate Room Name
                if(empty($data['Room_Name'])){
                    $data['Room_Name_err'] = 'Please enter room name';
                }if (strlen($data['Room_Name']) > 50) {
                    $data['Room_Name_err'] = 'Room name should be less than 50 characters';
                }

                // Check whether errors are empty
                if(empty($data['Room_Name_err'])){
                    // Register user
                    if($this->managerModel->add_room($data)){
                        redirect('manager/room_management');
                    } else{
                        die("Couldn't register the room! ");
                    }
                } else {
                    // Load view with errors
                    $this->view('manager/add_room', $data);
                }

            $this->view('manager/add_room', $data);
            }

            $data=[
                'Room_Name' => '',
                'Room_Name_err' => ''
            ];

            $this->view('manager/add_room', $data);
        }

        public function remove_room(){
            $data = [
                'ID' => $_SESSION['userID']
            ];
    
            $hospital_data = $this->managerModel->hospital_data_fetch($data['ID']);
            $hospital_id = $hospital_data->Hospital_ID;

            if($this->managerModel->remove_room($_GET['id'], $hospital_id)){
                redirect('manager/room_management');
            } else{
                die("Couldn't delete the room! ");
            }
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
        $data = [
            'ID' => $_SESSION['userID']
        ];

        $hospital_data = $this->managerModel->hospital_data_fetch($data['ID']);
        $hospital_id = $hospital_data->Hospital_ID;

        
        $all_tests = $this->testModel->get_all_tests();
            
        $hospital_tests = $this->managerModel->manager_labtest_data_fetch($hospital_id);

        // Initialize an empty array to hold test data
        $test_names_types = [];

        // Iterate through all_tests to filter out unwanted tests
        foreach ($all_tests as $key => $test) {
            $keep_test = true;

            foreach ($hospital_tests as $hospital_test) {
                if ($test->Test_ID == $hospital_test->Test_ID) {
                    // If found in hospital_tests, don't keep this test
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
                if($this->managerModel->add_test($data, $hospital_id)){
                    redirect('manager/test_management');
                } else{
                    die("Couldn't register the test! ");
                }
            } else {
                // Load view with errors
                $this->view('manager/add_test', $data);
            }
            $this->view('manager/add_test', $data);

        }else{


            // Assign the test data array to $data['Tests']
            $data['Tests'] = $test_names_types;
            $data['T_price_err'] = '';
            $data['T_price'] = '';


            // Load view
            $this->view('manager/add_test', $data);
        }
        
    }
    public function edit_test() {
        $hospital_data = $this->managerModel->hospital_data_fetch($_SESSION['userID']);
        $hospital_id = $hospital_data->Hospital_ID;
        // Check for POST request
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // Sanitize strings
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Register user
            $data = [
                'T_ID' => $_POST['test_id'],
                'T_Name' => $_POST['test_name'],
                'T_price' => $_POST['test_price'],
                'T_price_err' => ''

            ];

            // Validate Test Type
            if(empty($data['T_price'])){
                $data['T_price_err'] = 'Please enter test price';
            }else{
                if($data['T_price'] > 50000){
                    $data['T_price_err'] = 'Should be below LKR 50,000.00';
                }
            }

            // Check whether errors are empty
            if(empty($data['T_price_err'])){
                // Register user
                if($this->managerModel->edit_test($data, $hospital_id)){
                    redirect('manager/test_management');
                } else{
                    die("Couldn't register the test! ");
                }
            } else {
                // Load view with errors
                $this->view('manager/edit_test', $data);
            }
            $this->view('manager/edit_test', $data);

        }else{
            $test = $this->managerModel->get_test($_GET['test_id'], $hospital_id);
            $data = [
                'T_ID' => $test->Test_ID,
                'T_Name' => $test->Test_Name,
                'T_price' => $test->Price,
                'T_price_err' => ''
            ];


            // Load view
            $this->view('manager/edit_test', $data);
        }
        
    }
    
    public function remove_test() {
        $hospital_data = $this->managerModel->hospital_data_fetch($_SESSION['userID']);
        $hospital_id = $hospital_data->Hospital_ID;
        if($this->managerModel->remove_test($_GET['test_id'], $hospital_id)){
            redirect('manager/test_management');
        } else{
            die("Couldn't delete the test! ");
        }
    }

    public function add_schedule(){
        $data = [
            'ID' => $_SESSION['userID']
        ];

        $hospital_data = $this->managerModel->hospital_data_fetch($data['ID']);
        $hospital_id = $hospital_data->Hospital_ID;

        $doctors = $this->managerModel->get_all_doctors();
        $rooms = $this->managerModel->get_rooms_hospital($hospital_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'doctors' => $doctors,
                'rooms' => $rooms,
                'Doctor_ID' => $_POST['doctor'],
                'Room_ID' => $_POST['room'],
                'Day' => $_POST['day'],
                'start_hour' => $_POST['start_hour'],
                'start_min' => $_POST['start_min'],
                'end_hour' => $_POST['end_hour'],
                'end_min' => $_POST['end_min'],
                'Room_err' => '',
                'Day_err' => '',
                'Time_Start_err' => '',
                'Time_End_err' => ''
            ];

            // Validate Doctor ID
            if (empty($data['Doctor_ID'])) {
                $data['Doctor_ID_err'] = 'Please select a doctor';
            }else{
                $doctor_schedule = $this->managerModel->doctor_schedule_hospital($data['Doctor_ID']);
            }

            // Validate Room ID
            if (empty($data['Room_ID'])) {
                $data['Room_ID_err'] = 'Please select a room';
            }else{
                $room_schedule = $this->managerModel->get_schedule_by_hospital_room($hospital_id, $data['Room_ID']);
            }

            // Validate Date
            if (empty($data['Day'])) {
                $data['Day_err'] = 'Please select a date';
            }

            // Validate Time Start
            if (empty($data['start_hour']) || empty($data['start_min'])) {
                $data['Time_Start_err'] = 'Please select a start time';
            }else{
                $start_time = $data['start_hour'] . ':' . $data['start_min'] . ':00';
            }

            // Validate Time End
            if (empty($data['end_hour']) || empty($data['end_min'])) {
                $data['Time_End_err'] = 'Please select an end time';
            }else{
                $end_time = $data['end_hour'] . ':' . $data['end_min'] . ':00';
            }

            if($data['start_hour'] > $data['end_hour']){
                $data['Time_End_err'] = 'Invalid time';
                $data['Time_Start_err'] = 'Invalid time';
            }
            
            if ($data['start_hour'] == $data['end_hour']) {
                $data['Time_End_err'] = 'Time slot should be at least 1 hour';
                $data['Time_Start_err'] = 'Time slot should be at least 1 hour';
            }


            if($room_schedule){
                if(empty($data['Time_Start_err']) && empty($data['Time_End_err']) && empty($data['Day_err']) && empty($data['Room_err'])){
                    $day = $data['Day'];
                    foreach($room_schedule as $sch){
                        if($sch->Day_of_Week == $day){
                            if($start_time >= $sch->Time_Start && $start_time <= $sch->Time_End){
                                $data['Time_Start_err'] = 'Room Unavailable on this time slot';
                                $data['Time_End_err'] = 'Room Unavailable on this time slot';
                                $data['Room_err'] = 'Room Unavailable on this time slot';
                            }elseif($end_time >= $sch->Time_Start && $end_time <= $sch->Time_End){
                                $data['Time_Start_err'] = 'Room Unavailable on this time slot';
                                $data['Time_End_err'] = 'Room Unavailable on this time slot';
                                $data['Room_err'] = 'Room Unavailable on this time slot';
                            }
                        }
                    }
                }
            }

            if($doctor_schedule){
                if(empty($data['Time_Start_err']) && empty($data['Time_End_err']) && empty($data['Day_err']) && empty($data['Room_err'])){
                    $day = $data['Day'];
                    foreach($doctor_schedule as $sch){
                        if($sch->Day_of_Week == $day){
                            if($hospital_data->Hospital_ID == $sch->Hospital_ID){
                                $data['Day_err'] = 'Doctor already has a schedule on this day';
                            }else{
                                if($start_time >= $sch->Time_Start && $start_time <= $sch->Time_End){
                                    $data['Time_Start_err'] = 'Doctor unavailable on this time slot';
                                }
                                if($end_time >= $sch->Time_Start && $end_time <= $sch->Time_End){
                                    $data['Time_End_err'] = 'Doctor unavailable on this time slot';
                                }
                            }
                        }
                    }
                }
            }

            if(empty($data['Time_Start_err']) && empty($data['Time_End_err']) && empty($data['Day_err']) && empty($data['Room_err'])){
                $data['Hospital_ID'] = $hospital_id;
                $data['Time_Start'] = $start_time;
                $data['Time_End'] = $end_time;
                if($this->managerModel->add_schedule($data)){
                    redirect('manager/schedule_management');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->view('manager/add_schedule', $data);
            }
            
        }else{
            $data = [
                'doctors' => $doctors,
                'rooms' => $rooms,
                'Doctor_ID' => '',
                'Room_ID' => '',
                'Day' => '',
                'start_hour' => '',
                'start_min' => '',
                'end_hour' => '',
                'end_min' => '',
                'Room_err' => '',
                'Day_err' => '',
                'Time_Start_err' => '',
                'Time_End_err' => ''
            ];
            $this->view('manager/add_schedule', $data);

        }
    }

    public function edit_schedule(){
        
        
        $schedule_id = $_GET['id'];
        $schedule = $this->managerModel->get_schedule($schedule_id);

        $rooms = $this->managerModel->get_rooms_hospital($schedule->Hospital_ID);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'rooms' => $rooms,
                'Doctor_ID' => $schedule->First_Name . ' ' . $schedule->Last_Name,
                'Room_ID' => $_POST['room'],
                'Room_Name' => $schedule->Room_Name,
                'Day' => $_POST['day'],
                'start_hour' => $_POST['start_hour'],
                'start_min' => $_POST['start_min'],
                'end_hour' => $_POST['end_hour'],
                'end_min' => $_POST['end_min'],
                'Room_err' => '',
                'Day_err' => '',
                'Time_Start_err' => '',
                'Time_End_err' => ''
            ];

            // Validate Doctor ID
            if (empty($data['Doctor_ID'])) {
                $data['Doctor_ID_err'] = 'Please select a doctor';
            }else{
                $doctor_schedule = $this->managerModel->doctor_schedule_hospital($schedule->Doctor_ID);
            }

            // Validate Room ID
            if (empty($data['Room_ID'])) {
                $data['Room_ID_err'] = 'Please select a room';
            }else{
                $room_schedule = $this->managerModel->get_schedule_by_hospital_room($schedule->Hospital_ID, $data['Room_ID']);
            }

            // Validate Date
            if (empty($data['Day'])) {
                $data['Day_err'] = 'Please select a date';
            }

            // Validate Time Start
            if (empty($data['start_hour']) || empty($data['start_min'])) {
                $data['Time_Start_err'] = 'Please select a start time';
            }else{
                $start_time = $data['start_hour'] . ':' . $data['start_min'] . ':00';
            }

            // Validate Time End
            if (empty($data['end_hour']) || empty($data['end_min'])) {
                $data['Time_End_err'] = 'Please select an end time';
            }else{
                $end_time = $data['end_hour'] . ':' . $data['end_min'] . ':00';
            }

            if($data['start_hour'] > $data['end_hour']){
                $data['Time_End_err'] = 'Invalid time';
                $data['Time_Start_err'] = 'Invalid time';
            }

            if ($data['start_hour'] == $data['end_hour']) {
                $data['Time_End_err'] = 'Time slot should be at least 1 hour';
                $data['Time_Start_err'] = 'Time slot should be at least 1 hour';
            }

            if($room_schedule){
                if(empty($data['Time_Start_err']) && empty($data['Time_End_err']) && empty($data['Day_err']) && empty($data['Room_err'])){
                    $day = $data['Day'];
                    foreach($room_schedule as $sch){
                        if($sch->Schedule_ID != $schedule_id && $sch->Day_of_Week == $day){
                            if($start_time >= $sch->Time_Start && $start_time <= $sch->Time_End){
                                $data['Time_Start_err'] = 'Room Unavailable on this time slot';
                                $data['Time_End_err'] = 'Room Unavailable on this time slot';
                                $data['Room_err'] = 'Room Unavailable on this time slot';
                            }elseif($end_time >= $sch->Time_Start && $end_time <= $sch->Time_End){
                                $data['Time_Start_err'] = 'Room Unavailable on this time slot';
                                $data['Time_End_err'] = 'Room Unavailable on this time slot';
                                $data['Room_err'] = 'Room Unavailable on this time slot';
                            }
                        }
                    }
                }
            }

            if($doctor_schedule){
                if(empty($data['Time_Start_err']) && empty($data['Time_End_err']) && empty($data['Day_err']) && empty($data['Room_err'])){
                    $day = $data['Day'];
                    foreach($doctor_schedule as $sch){
                        if($sch->Schedule_ID != $schedule_id && $sch->Day_of_Week == $day){
                            if($schedule->Hospital_ID == $sch->Hospital_ID){
                                $data['Day_err'] = 'Doctor already has a schedule on this day';
                            }else{
                                if($start_time >= $sch->Time_Start && $start_time <= $sch->Time_End){
                                    $data['Time_Start_err'] = 'Doctor unavailable on this time slot';
                                }
                                if($end_time >= $sch->Time_Start && $end_time <= $sch->Time_End){
                                    $data['Time_End_err'] = 'Doctor unavailable on this time slot';
                                }
                            }
                        }
                    }
                }
            }

            if(empty($data['Time_Start_err']) && empty($data['Time_End_err']) && empty($data['Day_err']) && empty($data['Room_err'])){
                $data['Hospital_ID'] = $schedule->Hospital_ID;
                $data['Schedule_ID'] = $schedule_id;
                $data['Time_Start'] = $start_time;
                $data['Time_End'] = $end_time;
                if($this->managerModel->edit_schedule($data)){
                    redirect('manager/schedule_management');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->view('manager/edit_schedule', $data);
            }
            
        }else{
            $start_hour = date('H', strtotime($schedule->Time_Start));
            $start_min = date('i', strtotime($schedule->Time_Start));
            $end_hour = date('H', strtotime($schedule->Time_End));
            $end_min = date('i', strtotime($schedule->Time_End));
            $data = [
                'rooms' => $rooms,
                'Doctor_ID' => $schedule->First_Name . ' ' . $schedule->Last_Name,
                'Room_ID' => $schedule->Room_ID,
                'Room_Name' => $schedule->Room_Name,
                'Day' => $schedule->Day_of_Week,
                'start_hour' => $start_hour,
                'start_min' => $start_min,
                'end_hour' => $end_hour,
                'end_min' => $end_min ,
                'Room_err' => '',
                'Day_err' => '',
                'Time_Start_err' => '',
                'Time_End_err' => ''
            ];
            $this->view('manager/edit_schedule', $data);
        }
    }

    public function remove_schedule(){
        $schedule_id = $_GET['id'];
        if($this->managerModel->remove_schedule($schedule_id)){
            redirect('manager/schedule_management');
        } else{
            die("Couldn't delete the schedule! ");
        }
    }
    
}



