<?php

use function PHPSTORM_META\type;

class Patient extends Controller
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->patientModel = $this->model('patients');
        $this->doctorModel = $this->model('doctors');
        $this->hospitalModel = $this->model('hospitals');
        $this->scheduleModel = $this->model('schedules');
        $this->testModel = $this->model('tests');
    }

    public function index()
    {
        $data = [];
        $this->view('patient/doc_booking', $data);
    }

    public function doc_booking()
    {
        $data = [];
        //$doctor =  new Doctors();
        //$doctors = $doctor->getAllDoctors();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
            // Get search parameters from the form
            $doctorName = isset($_POST['doctor_name']) ? $_POST['doctor_name'] : null;
            $hospitalName = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : null;
            $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : null;
    
            // Perform the search based on the parameters
            $searchDoctors = $this->doctorModel->search_doctors($doctorName, $hospitalName, $specialization);
    
        } else {
            $searchDoctors = $this->doctorModel->getAllDoctors();
        }

        $doctors = $this->doctorModel->getAllDoctors();
        $hospitals = $this->hospitalModel->getAllHospitals();

        // Getting disticnt specializations
        $specializations = [];
        $no_of_hospitals = [];

        foreach ($doctors as $doctor) {
            if (!in_array($doctor->Specialization, $specializations)) {
                $specializations[] = $doctor->Specialization;
            }
        }

        foreach ($searchDoctors as $doctor) {
            // Get the number of hospitals for the current doctor
            $no_of_hospitals[$doctor->Doctor_ID] = $this->doctorModel->get_no_of_hospitals($doctor->Doctor_ID);
        }

        $data = [
            'doctors' => $doctors,
            'searchDoctors' => $searchDoctors,
            'hospitals' => $hospitals,
            'specializations' => $specializations,
            'no_of_hospitals' => $no_of_hospitals
        ];
        $this->view('patient/doc_booking', $data);
        
    }

    public function test_booking()
    {
        $data = [];
        //$doctor =  new Doctors();
        //$doctors = $doctor->getAllDoctors();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
            // Get search parameters from the form
            $testName = isset($_POST['test_name']) ? $_POST['test_name'] : null;
            $hospitalId = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : null;
            $testType = isset($_POST['test_type']) ? $_POST['test_type'] : null;
    
            // Perform the search based on the parameters
            $searchTests = $this->testModel->search_tests($testName, $hospitalId, $testType);
    
        } else {
            $searchTests = $this->testModel->get_all_available_tests();
        }

        $tests = $this->testModel->get_all_available_tests();
        $hospitals = $this->hospitalModel->getAllHospitals();

        // Getting disticnt specializations
        $types = [];
        $no_of_hospitals = [];

        if($tests){
            foreach ($tests as $test) {
                if (!in_array($test->Test_Type, $types)) {
                    $types[] = $test->Test_Type;
                }
            }
        }
        
        if($searchTests){
            foreach ($searchTests as $test) {
                // Get the number of hospitals for the current doctor
                $no_of_hospitals[$test->Test_ID] = $this->testModel->get_no_of_hospitals($test->Test_ID);
            }
        }

        $data = [
            'tests' => $tests,
            'searchTests' => $searchTests,
            'hospitals' => $hospitals,
            'types' => $types,
            'no_of_hospitals' => $no_of_hospitals
        ];
        $this->view('patient/test_booking', $data);
    }

    public function reservations()
    {
        $data = [];
        $patient_id = $_SESSION['userID'];
        $doc_reservations = $this->patientModel->get_doc_reservations($patient_id);
        foreach ($doc_reservations as $reservation) {
            $res_time = strtotime($reservation->Date . ' ' . $reservation->Start_Time);
            $current_time = strtotime(date('Y-m-d H:i:s'));
            $time_diff = $res_time - $current_time;
            if ($time_diff < 60 * 60 * 24) {
                $reservation->allow_cancel = false;
                
            }else{
                $reservation->allow_cancel = true;
            }
        }
        
        $test_reservations = $this->patientModel->get_test_reservations($patient_id);
        $data = [
            'doc_reservations' => $doc_reservations,
            'test_reservations' => $test_reservations
        ];

        $this->view('patient/reservations', $data);
    }

    public function view_prescription(){
        $prescription_id = $_GET['id'];
        $prescription = $this->doctorModel->get_prescription_data($prescription_id);
        $Name = $prescription->First_Name . ' ' . $prescription->Last_Name;
        $Age = date_diff(date_create($prescription->DOB), date_create('now'))->y;
        $Doc_Name = $prescription->Doc_First_Name . ' ' . $prescription->Doc_Last_Name;
        $code_string = $prescription_id . $prescription->Diagnosis;
        $code = hash('sha256', $code_string); 

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
            'Code' => $code
        ];


        try{
            include_once APPROOT.'/helpers/generate_prescription.php';
        }catch(Exception $e){
            echo $e;

        }
    }

    public function doc_booking_details()
    {
        // Get doctor ID from URL parameter
        $doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : null;

        if (!$doctor_id) {
            $this->view('pages/not_found');
            return;
        }

        // Fetch patient data
        $patient_data = $this->patientModel->patient_data_fetch($_SESSION['userID']);

        // Fetch doctor data using the model
        $doctor_data = $this->doctorModel->doctor_data_fetch($doctor_id);
        $hospital_data = $this->scheduleModel->doctor_schedule_hospital($doctor_id);

        $data = [
            'First_Name' => $patient_data->First_Name,
            'Last_Name' => $patient_data->Last_Name,
            'NIC' => $patient_data->NIC,
            'C_Num' => $patient_data->Contact_No,
            'Email' => $patient_data->Username,
            'doctor_data' => $doctor_data,
            'hospital_data' => $hospital_data
        ];

        $this->view('patient/doc_booking_details', $data);
    }

    // public function fetch_schedule_details(){
    //     // Get hospital ID, doctor ID and date from request data
    //     $doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : null;
    //     $hospital_id = isset($_GET['hospital_id']) ? $_GET['hospital_id'] : null;
    //     $selected_date = isset($_GET['selected_date']) ? $_GET['selected_date'] : null;
    //     $formatted_date = date('Y-m-d', strtotime(str_replace('/', '-', $selected_date)));


    //     if (!$hospital_id || !$doctor_id) {
    //         echo json_encode(array('error' => 'Missing hospital_id or doctor_id'));  // Send JSON with error message
    //         return;
    //     }
        
    //     // Perform database query to fetch schedule details based on hospital_id and doctor_id
    //     $scheduleData = $this->scheduleModel->get_schedule_by_hospital_doctor($hospital_id, $doctor_id);
    //     $hospital_data = $this->hospitalModel->hospital_data_fetch($hospital_id);

    //     if ($scheduleData === false) {
    //         http_response_code(500); // Set HTTP status code to indicate internal server error
    //         echo json_encode(array('error' => 'Failed to fetch schedule details'));
    //         return;
    //     }

    //     // Prepare data to be sent as JSON response
    //     $responseData = array();
    //     foreach ($scheduleData as $schedule) {
    //         // Generate time slots with 15-minute intervals
    //         $startTime = strtotime($schedule->Time_Start);
    //         $endTime = strtotime($schedule->Time_End);
    //         $bookedSlots = $this->scheduleModel->fetch_booked_slots($schedule->Schedule_ID);
    //         $timeSlots = array();
    //         while ($startTime < $endTime) {
    //             $timeSlots[] = array(
    //                 'start_time' => date('H:i:s', $startTime),
    //                 'end_time' => date('H:i:s', $startTime + 900), // 900 seconds = 15 minutes
    //             );
    //             $startTime += 900; // Move to the next 15-minute interval
    //         }
    //         foreach ($bookedSlots as $bookedSlot) {
    //             foreach ($timeSlots as $key => $timeSlot) {
    //                 if ($timeSlot['start_time'] == $bookedSlot->Start_Time) {
    //                     //compare date here
    //                     if ($bookedSlot->Date == $formatted_date) {
    //                         unset($timeSlots[$key]);
    //                     }
    //                 }
    //             }
    //         }
    //         if ($formatted_date == date('Y-m-d')) {
    //             foreach ($timeSlots as $key => $timeSlot) {
    //                 date_default_timezone_set('Asia/Colombo');
    //                 if ($timeSlot['start_time'] < date('H:i:s')) {
    //                     unset($timeSlots[$key]);
    //                 }
    //             }
    //         }


    //         $responseData[] = array(
    //             'day_of_week' => $schedule->Day_of_Week,
    //             'time_slots' => $timeSlots,
    //             'hospital_charge' => $hospital_data->Charge,
    //         );
    //     }
        
    //     // Send JSON response with schedule data
    //     echo json_encode($responseData);
    // }

    public function fetch_schedule_details(){
        // Get hospital ID, doctor ID and date from request data
        $doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : null;
        $hospital_id = isset($_GET['hospital_id']) ? $_GET['hospital_id'] : null;
        $selected_date = isset($_GET['selected_date']) ? $_GET['selected_date'] : null;
        $formatted_date = date('Y-m-d', strtotime(str_replace('/', '-', $selected_date)));


        if (!$hospital_id || !$doctor_id) {
            echo json_encode(array('error' => 'Missing hospital_id or doctor_id'));  // Send JSON with error message
            return;
        }
        
        // Perform database query to fetch schedule details based on hospital_id and doctor_id
        $scheduleData = $this->scheduleModel->get_schedule_by_hospital_doctor($hospital_id, $doctor_id);
        $hospital_data = $this->hospitalModel->hospital_data_fetch($hospital_id);

        if ($scheduleData === false) {
            http_response_code(500); // Set HTTP status code to indicate internal server error
            echo json_encode(array('error' => 'Failed to fetch schedule details'));
            return;
        }

        // Prepare data to be sent as JSON response
        // Assuming $scheduleData, $formatted_date, and $hospital_data are already defined

        $responseData = array();

        foreach ($scheduleData as $schedule) {
            // Fetch booked slots for the current schedule
            $bookedSlots = $this->scheduleModel->fetch_booked_slots($schedule->Schedule_ID, $formatted_date);

            // Initialize variables to track available slots and appointment number
            $availableSlots = array();
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
                    'end_time' => date('H:i:s', $startTime + 900), // 900 seconds = 15 minutes
                );
                $startTime += 900; // Move to the next 15-minute interval
            }
            $nextAppointmentNumber = $lastBookedAppointmentNumber + 1; // Get the next appointment number

            $slotIndex = ceil($nextAppointmentNumber / 2); // Calculate the slot index

            if ($slotIndex <= count($timeSlots)) {
                $nextTimeSlot = $timeSlots[$slotIndex - 1]; // Get the time slot corresponding to the slot index
            } else {
                // Handle the case where the next appointment number exceeds the available slots
                $nextTimeSlot = null;
            }


            // Add data to responseData
            $responseData[] = array(
                'day_of_week' => $schedule->Day_of_Week,
                'start_time' => $schedule->Time_Start,
                'end_time' => $schedule->Time_End,
                'next_slot' => $nextTimeSlot,
                'next_appointment_number' => $nextAppointmentNumber,
                'hospital_charge' => $hospital_data->Charge,
            );
        }

        // Send JSON response with schedule data
        echo json_encode($responseData);
    }


    public function test_booking_details()
    {
        // Get test ID from URL parameter
        $test_id = isset($_GET['test_id']) ? $_GET['test_id'] : null;

        if (!$test_id) {
            $this->view('pages/not_found');
            return;
        }

        // Fetch patient data
        $test_data = $this->testModel->test_data_fetch($test_id);
        $patient_data = $this->patientModel->patient_data_fetch($_SESSION['userID']);

        // Fetch test data using the model
        // $doctor_data = $this->doctorModel->doctor_data_fetch($doctor_id);
        $hospital_data = $this->testModel->test_schedule_hospital($test_id);

        $data = [
            'First_Name' => $patient_data->First_Name,
            'Last_Name' => $patient_data->Last_Name,
            'NIC' => $patient_data->NIC,
            'C_Num' => $patient_data->Contact_No,
            'Email' => $patient_data->Username,
            'hospital_data' => $hospital_data,
            'test_data' => $test_data
        ];

        $this->view('patient/test_booking_details', $data);
    }

    public function fetch_test_schedule_details()
    {
        // Get hospital ID, test ID and date from request data
        $test_id = isset($_POST['test_id']) ? $_POST['test_id'] : null;
        $hospital_id = isset($_POST['hospital_id']) ? $_POST['hospital_id'] : null;
        $selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : null;
        $formatted_date = date('Y-m-d', strtotime(str_replace('/', '-', $selected_date)));

        // Define the start and end times for the slots
        $startTime1 = strtotime('9:00');
        $endTime1 = strtotime('12:00');
        $startTime2 = strtotime('13:00');
        $endTime2 = strtotime('15:00');

        $timeSlots = array();

        // Loop to generate time slots
        while ($startTime1 < $endTime1) {
            $slotStart = date('H:i', $startTime1);
            $startTime1 += (15 * 60); // Add 15 minutes
            $slotEnd = date('H:i', $startTime1);
            $timeSlots[] = array('start_time' => $slotStart, 'end_time' => $slotEnd);
        }

        while ($startTime2 < $endTime2) {
            $slotStart = date('H:i', $startTime2);
            $startTime2 += (15 * 60); // Add 15 minutes
            $slotEnd = date('H:i', $startTime2);
            $timeSlots[] = array('start_time' => $slotStart, 'end_time' => $slotEnd);
        }


        $bookedSlots = $this->testModel->fetch_booked_slots($hospital_id, $formatted_date);
        
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

    public function fetch_test_prices()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hospital_id']) && isset($_POST['test_id'])) {
            // Sanitize the input data
            $hospital_id = htmlspecialchars($_POST['hospital_id']);
            $test_id = htmlspecialchars($_POST['test_id']);

            $prices = $this->testModel->get_prices($test_id, $hospital_id);

            $tax = ($prices->Price + 100) * 0.05;
            $totalPrice = $prices->Price + 100 + $tax;

            $prices->totalPrice = $totalPrice;
            $prices->tax = $tax;

            $response = json_encode($prices);

            header('Content-Type: application/json');
            echo $response;
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(array("error" => "Invalid request"));
        }
    }

    public function cancel_test_reservation(){
        $Reservation_ID = $_POST['reservation_id'];

        if ($this->testModel->cancel_reservation($Reservation_ID)) {
            echo json_encode('Reservation deleted successfully');
        } else {
            echo json_encode('Failed to delete reservation');
        }
    }

    public function cancel_doc_reservation(){
        $Reservation_ID = $_POST['reservation_id'];

        if ($this->doctorModel->cancel_reservation($Reservation_ID)) {
            echo json_encode('Reservation deleted successfully');
        } else {
            echo json_encode('Failed to delete reservation');
        }
    }


    public function medical_records()
    {
        $data = [];
        $patient_id = $_SESSION['userID'];
        $doc_consultations = $this->patientModel->get_consultations($patient_id);
        $test_reservations = $this->patientModel->get_past_test_reservations($patient_id);
        $data = [
            'doc_consultations' => $doc_consultations,
            'test_reservations' => $test_reservations
        ];
        $this->view('patient/medical_records', $data);
    }

    public function profile()
    {
        $data = [
            'Uname' => $_SESSION['userEmail'],
            'Name' => $_SESSION['userName'],
            'Type' => $_SESSION['userType'],
            'ID' => $_SESSION['userID']
        ];

        $patient_data = $this->patientModel->patient_data_fetch($data['ID']);

        $data += [
            'ID' => $patient_data->Patient_ID,
            'First_Name' => $patient_data->First_Name,
            'Last_Name' => $patient_data->Last_Name,
            'Gender' => $patient_data->Gender,
            'NIC' => $patient_data->NIC,
            'C_Num' => $patient_data->Contact_No,
            'DOB' => $patient_data->DOB,
            'Blood_Group' => $patient_data->Blood_Group,
            'Height' => $patient_data->Height,
            'Weight' => $patient_data->Weight,
            'Allergies' => $patient_data->Allergies,
            'Email' => $patient_data->Username,
            'Password' => $patient_data->Password
        ];

        $this->view("patient/profile", $data);
    }

    public function profile_update()
    {
        $data = [
            'Uname' => $_SESSION['userEmail'],
            'Name' => $_SESSION['userName'],
            'Type' => $_SESSION['userType'],
            'ID' => $_SESSION['userID']
        ];

        $patient_data = $this->patientModel->patient_data_fetch($data['ID']);

        // Check for POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize strings
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Register user
            $data += [
                'ID' => $_SESSION['userID'],
                'First_Name' => trim($_POST['fname']),
                'Last_Name' => trim($_POST['lname']),
                'Gender' => $patient_data->Gender,
                'NIC' => trim($_POST['nic']),
                'C_Num' => $_POST['cnum'],
                'DOB' => $patient_data->DOB,
                'Age' => '',
                'Height' => $_POST['height'],
                'Weight' => $_POST['weight'],
                'Blood_Group' => $patient_data->Blood_Group,
                'Allergies' => trim($_POST['allergies']),
                'Uname' => trim($_POST['email']),
                'Pass' => trim($_POST['pass']),
                'C_pass' => trim($_POST['cpass']),
                'Uname_err' => '',
                'Pass_err' => '',
                'C_pass_err' => ''
            ];

            // Calculate age
            $currentDate = new DateTime();
            $birthDate = new DateTime($data['DOB']);
            $data['Age'] = $currentDate->diff($birthDate)->y;

            // Validate Email
            $data['Uname_err'] = empty($data['Uname']) ? 'Please enter your email' : '';

            // Validate Password
            $length = strlen($data['Pass']);
            $uppercase = preg_match('@[A-Z]@', $data['Pass']);
            $lowercase = preg_match('@[a-z]@', $data['Pass']);
            $number = preg_match('@[0-9]@', $data['Pass']);
            $spec = preg_match('@[^\w]@', $data['Pass']);

            $data['Pass_err'] = empty($data['Pass']) ? 'Please enter a password' :
                ($length < 8 ? 'Password must be at least 8 characters' :
                (!$uppercase ? 'Password must include at least 1 uppercase character' :
                (!$lowercase ? 'Password must include at least 1 lowercase character' :
                (!$number ? 'Password must include at least 1 number' :
                (!$spec ? 'Password must include at least 1 special character' : '')))));

            // Validate Confirm Password
            $data['C_pass_err'] = empty($data['C_pass']) ? 'Please confirm password' :
                ($data['Pass'] != $data['C_pass'] ? 'Confirm password does not match with password' : '');

            // Check whether errors are empty
            if (empty($data['Uname_err']) && empty($data['Pass_err']) && empty($data['C_pass_err'])) {
                // Hashing password
                $data['Pass'] = hash('sha256', $data['Pass']);

                // Register user
                if ($this->patientModel->patient_profile_update($data)) {
                    redirect('patient/profile');
                } else {
                    die("Couldn't register the patient! ");
                }
            } else {
                // Load view
                $this->view('patient/profile_update', $data);
            }
        } else {
            // Get data
            $data += [
                'First_Name' => $patient_data->First_Name,
                'Last_Name' => $patient_data->Last_Name,
                'Gender' => $patient_data->Gender,
                'NIC' => $patient_data->NIC,
                'C_Num' => $patient_data->Contact_No,
                'DOB' => $patient_data->DOB,
                'Blood_Group' => $patient_data->Blood_Group,
                'Height' => $patient_data->Height,
                'Weight' => $patient_data->Weight,
                'Allergies' => $patient_data->Allergies,
                'Uname' => $patient_data->Username,
                'Pass' => $patient_data->Password,
                'C_pass' => '',
                'Uname_err' => '',
                'Pass_err' => '',
                'C_pass_err' => ''
            ];

            // Load view
            $this->view('patient/profile_update', $data);
        }
    }

    public function profile_delete()
    {
        $data = [
            'ID' => $_SESSION['userID']
        ];

        if ($this->patientModel->patient_profile_delete($data['ID'])) {
            redirect('users/logout');
        } else {
            die("Couldn't delete the patient ");
            }
        }

    public function make_payment()
    {
       
        $merchant_id = "1226485";
        $order_id = uniqid();
        $amount = $_POST['amount'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $mobile = $_POST['phone'];
        $type = $_POST['type'];
        $currency = "LKR";
        $merchant_secret = "MTM1NDY0Njg4ODM5NDA0Mjg4MjE3MjE3MDA3NTczMDEzNDcxNzQ2";
        $return_url = ($type == "Test Booking Payment" ? "http://localhost/healthwave/patient/test_booking": "http://localhost/healthwave/patient/doc_booking");
        $cancel_url = ($type == "Test Booking Payment" ? "http://localhost/healthwave/patient/test_booking_details": "http://localhost/healthwave/patient/doc_booking_details");

        $hash = strtoupper(
            md5(
                $merchant_id . 
                $order_id . 
                number_format($amount, 2, '.', '') . 
                $currency .  
                strtoupper(md5($merchant_secret)) 
            ) 
        );
        $payment = [
            "sandbox" => true,
            "merchant_id" => $merchant_id,  
            "return_url" => $return_url,
            "cancel_url" => $cancel_url,
            "notify_url" => "",
            "order_id" => $order_id,
            "items" => $type,
            "amount" => $amount,
            "currency" => $currency,
            "hash" => $hash,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "phone" => $mobile,
            "address" => "",
            "city" => "",
            "country" => "",
            "delivery_address" => "",
            "delivery_city" => "",
            "delivery_country" => "",
            "custom_1" => "",
            "custom_2" => ""
        ];
    
        echo json_encode($payment);
    }

    public function add_reservation()
    {
        $data = [
            'Patient_ID' => $_SESSION['userID'],
            'Doctor_ID' => $_POST['DoctorID'],
            'Hospital_ID' => $_POST['HospitalID'],
            'Selected_Date' => $_POST['SelectedDate'],
            'Selected_Day' => $_POST['SelectedDay'],
            'Start_Time' => $_POST['StartTime'],
            'End_Time' => $_POST['EndTime'],
            'Appointment_No' => $_POST['AppNo'],
            'Total_Price' => $_POST['TotalPrice'],
            'Contact_No' => $_POST['ContactNo'],
            'Email' => $_POST['Email']
        ];

        $mail_data = $this->patientModel->add_reservation($data);

        if ($mail_data) {
            try {
                require_once APPROOT.'/helpers/Mail.php';
                $mail = new Mail();
        
                // Prepare the email details
                $to = $data['Email'];
                $subject = 'Reservation Confirmation'; 
                $body = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #505050; background-color: #f9f9f9; margin: 0; padding: 0;">';
                $body .= '<div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">';
                $body .= '<h1 style="text-align: center; color: #4070f4;">Hello ' . $mail_data->First_Name . ' ' . $mail_data->Last_Name . ',</h1>';
                $body .= '<p style="font-size: 16px; margin-bottom: 10px; text-align: center;">Your appointment has been confirmed.</p>';
                $body .= '<div>';
                $body .= '<p style="margin-bottom: 10px; text-align: center;"><strong>Appointment Details:</strong></p>';
                $body .= '<ul style="list-style-type: none; padding: 0;">';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Doctor Name:</strong> '. $mail_data->Doc_First_Name . ' ' .$mail_data->Doc_Last_Name .'</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Doctor Specialization:</strong> '. $mail_data->Specialization . '</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Hospital Name:</strong> '. $mail_data->Hospital_Name . '</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Room:</strong> '. $mail_data->Room_Name . '</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Appointment Number:</strong> '. $data['Appointment_No'] . '</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Date:</strong> '. $data['Selected_Date'] . '</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Appointment Time:</strong> '. $data['Start_Time'] . ' - ' .$data['End_Time'] .'</li>';
                $body .= '</ul>';
                $body .= '</div>';
                $body .= '<p class="note" style="font-size: 14px; text-align: center;">Please arrive at least 10 minutes before your scheduled appointment time.</p>';
                $body .= '<p class="note" style="font-size: 14px; text-align: center;">Thank you for choosing <b>HealthWave!</b></p>';
                $body .= '</div>';
                $body .= '</body></html>';
        
                // Send the email
                $result = $mail->send($to, $subject, $body);
        
                if ($result) {
                    $response = array('message' => 'Reservation added successfully. Confirmation email sent.');
                } else {
                    $response = array('message' => 'Failed to send confirmation email. Please contact support.');
                }
            } catch (Exception $e) {
                $response = array('message' => 'An error occurred. Please try again later.');
                // Log the exception for debugging
                error_log($e->getMessage());
            }
            echo json_encode($response);


        } else {
            echo json_encode(array('message' => 'Failed to add reservation'));
        }
        

    }

    public function add_test_reservation()
    {
        $data = [
            'Patient_ID' => $_SESSION['userID'],
            'Test_ID' => $_POST['TestID'],
            'Hospital_ID' => $_POST['HospitalID'],
            'Selected_Date' => $_POST['SelectedDate'],
            'Start_Time' => $_POST['StartTime'],
            'End_Time' => $_POST['EndTime'],
            'Total_Price' => $_POST['TotalPrice'],
            'Contact_No' => $_POST['ContactNo'],
            'Email' => $_POST['Email']
        ];

        $mail_data = $this->testModel->add_reservation($data);

        if ($mail_data) {
            try {
                require_once APPROOT.'/helpers/Mail.php';
                $mail = new Mail();
        
                // Prepare the email details
                $to = $data['Email'];
                $subject = 'Reservation Confirmation'; 
                $body = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #505050; background-color: #f9f9f9; margin: 0; padding: 0;">';
                $body .= '<div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">';
                $body .= '<h1 style="text-align: center; color: #4070f4;">Hello ' . $mail_data->First_Name . ' ' . $mail_data->Last_Name . ',</h1>';
                $body .= '<p style="font-size: 16px; margin-bottom: 10px; text-align: center;">Your test reservation has been confirmed.</p>';
                $body .= '<div>';
                $body .= '<p style="margin-bottom: 10px; text-align: center;"><strong>Appointment Details:</strong></p>';
                $body .= '<ul style="list-style-type: none; padding: 0;">';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Test Name:</strong> '. $mail_data->Test_Name .'</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Test Type:</strong> '. $mail_data->Test_Type . '</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Hospital Name:</strong> '. $mail_data->Hospital_Name . '</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Date:</strong> '. $data['Selected_Date'] . '</li>';
                $body .= '<li style="margin-bottom: 10px; text-align: center;"><strong>Appointment Time:</strong> '. $data['Start_Time'] . ' - ' .$data['End_Time'] .'</li>';
                $body .= '</ul>';
                $body .= '</div>';
                $body .= '<p class="note" style="font-size: 14px; text-align: center;">Please arrive at least 10 minutes before your scheduled reservation time.</p>';
                $body .= '<p class="note" style="font-size: 14px; text-align: center;">Thank you for choosing <b>HealthWave!</b></p>';
                $body .= '</div>';
                $body .= '</body></html>';
        
                // Send the email
                $result = $mail->send($to, $subject, $body);
        
                if ($result) {
                    $response = array('message' => 'Reservation added successfully. Confirmation email sent.');
                } else {
                    $response = array('message' => 'Failed to send confirmation email. Please contact support.');
                }
            } catch (Exception $e) {
                $response = array('message' => 'An error occurred. Please try again later.');
                // Log the exception for debugging
                error_log($e->getMessage());
            }
            echo json_encode($response);


        } else {
            echo json_encode(array('message' => 'Failed to add reservation'));
        }
        

    }

    public function payment_success()
    {
        $type = isset($_GET['type']) ? $_GET['type'] : null;
        $data = [
            'type' => $type
        ];
        $this->view('patient/payment_success', $data);

    }

    public function doctor_profile(){
        $data = [];
        $this->view('patient/doctor_profile', $data);
    }

    public function get_patient_details(){
        $resId = $_POST['resId'];
        $type = $_POST['type'];
        $patient = $this->doctorModel->get_patient_details($resId, $type);
        echo json_encode($patient);
    }
}

    