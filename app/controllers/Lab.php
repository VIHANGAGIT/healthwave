<?php
    class Lab extends Controller{
        public function __construct(){
            //$this->labModel = $this->model('user');
        }
        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [];
            
            $this->view('lab/test_appt_management', $data);
        }

        public function test_management(){
            $data = [];
            $this->view('lab/test_management', $data);
        }

        public function test_result_upload(){
            $data = [];
            $this->view('lab/test_result_upload', $data);
        }
    }
?>