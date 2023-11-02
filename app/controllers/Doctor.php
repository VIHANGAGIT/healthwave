<?php
    class Doctor extends Controller{
        public function __construct(){
            //$this->doctorModel = $this->model('user');
        }
        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [];
            
            $this->view('doctor/reservations', $data);
        }

        public function consultations(){
            $data = [];
            $this->view('doctor/consultations', $data);
        }
    }
?>