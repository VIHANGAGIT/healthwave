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
            $testId = isset($_POST['test_name']) ? $_POST['test_name'] : null;
            $hospitalId = isset($_POST['hospital_name']) ? $_POST['hospital_name'] : null;
            $testType = isset($_POST['test_type']) ? $_POST['test_type'] : null;
    
            // Perform the search based on the parameters
            $searchTests = $this->testModel->search_tests($testId, $hospitalId, $testType);
    
        } else {
            $searchTests = $this->testModel->get_all_available_tests();
        }

        $tests = $this->testModel->get_all_available_tests();
        $hospitals = $this->hospitalModel->getAllHospitals();

        // Getting disticnt specializations
        $types = [];
        $no_of_hospitals = [];

        foreach ($tests as $test) {
            if (!in_array($test->Test_Type, $types)) {
                $types[] = $test->Test_Type;
            }
        }

        foreach ($searchTests as $test) {
            // Get the number of hospitals for the current doctor
            $no_of_hospitals[$test->Test_ID] = $this->testModel->get_no_of_hospitals($test->Test_ID);
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
        $this->view('patient/reservations', $data);
    }

    public function doc_booking_details()
    {
        // Get doctor ID from URL parameter
        $doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : null;

        if (!$doctor_id) {
            // Handle case where ID is missing in the URL (optional)
            // You can redirect to an error page or display an error message
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

    public function fetch_schedule_details()
    {
        // Get hospital ID and doctor ID from request data
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
        $responseData = array();
        foreach ($scheduleData as $schedule) {
            // Generate time slots with 15-minute intervals
            $startTime = strtotime($schedule->Time_Start);
            $endTime = strtotime($schedule->Time_End);
            $bookedSlots = $this->scheduleModel->fetch_booked_slots($schedule->Schedule_ID);
            $timeSlots = array();
            while ($startTime < $endTime) {
                $timeSlots[] = array(
                    'start_time' => date('H:i:s', $startTime),
                    'end_time' => date('H:i:s', $startTime + 900), // 900 seconds = 15 minutes
                );
                $startTime += 900; // Move to the next 15-minute interval
            }
            foreach ($bookedSlots as $bookedSlot) {
                foreach ($timeSlots as $key => $timeSlot) {
                    if ($timeSlot['start_time'] == $bookedSlot->Start_Time) {
                        //compare date here
                        if ($bookedSlot->Date == $formatted_date) {
                            unset($timeSlots[$key]);
                        }
                    }
                }
            }

            $responseData[] = array(
                'day_of_week' => $schedule->Day_of_Week,
                'time_slots' => $timeSlots,
                'hospital_charge' => $hospital_data->Charge,
            );
        }
        
        // Send JSON response with schedule data
        echo json_encode($responseData);
    }



    public function medical_records()
    {
        $data = [];
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
            'Uname' => $_SESSION['userEmail'],
            'Name' => $_SESSION['userName'],
            'Type' => $_SESSION['userType'],
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
        $data = [];

        $merchant_id = "1226485";
        $order_id = uniqid();
        $amount = $_POST['amount'];
        $currency = "LKR";
        $merchant_secret = "MTM1NDY0Njg4ODM5NDA0Mjg4MjE3MjE3MDA3NTczMDEzNDcxNzQ2";

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
            "return_url" => "http://localhost/healthwave/patient/doc_booking",
            "cancel_url" => "http://localhost/healthwave/patient/doc_booking_details",
            "notify_url" => "http://sample.com/notify",
            "order_id" => $order_id,
            "items" => "Doctor Booking Payment",
            "amount" => $amount,
            "currency" => $currency,
            "hash" => $hash,
            "first_name" => "Vihanga",
            "last_name" => "Vithanawasam",
            "email" => "test@jj.com",
            "phone" => "0978424552",
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
            'Total_Price' => $_POST['TotalPrice'],
            'Contact_No' => $_POST['ContactNo'],
            'Email' => $_POST['Email']
        ];

        if ($this->patientModel->add_reservation($data)) {
            echo json_encode(array('message' => 'Reservation added successfully'));
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
}

    