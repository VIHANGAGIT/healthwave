<?php
    class Patient extends Controller{
        public function __construct(){
            //$this->userModel = $this->model('user');
        }

        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [
                'title' => 'Welcome'
                //'user' => $users
            ];
            
            $this->view('patient/doc_booking', $data);
        }

        public function test_booking(){
            $data = [
                'title' => 'About Us'
            ];
            $this->view('patient/test_booking', $data);
        }

        public function reservations(){
            $data = [
                'title' => 'About Us'
            ];
            $this->view('patient/reservations', $data);
        }

        public function medical_records(){
            $data = [
                'title' => 'About Us'
            ];
            $this->view('patient/medical_records', $data);
        }
    }
?>