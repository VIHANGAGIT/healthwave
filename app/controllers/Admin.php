<?php
    class Admin extends Controller{
        public function __construct(){
            //$this->adminModel = $this->model('user');
        }
        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [];
            
            $this->view('admin/dashboard', $data);
        }

        public function approvals(){
            $data = [];
            $this->view('admin/approvals', $data);
        }

        public function doc_management(){
            $data = [];
            $this->view('admin/doc_management', $data);
        }

        public function test_management(){
            $data = [];
            $this->view('admin/test_management', $data);
        }

        public function hospital_management(){
            $data = [];
            $this->view('admin/hospital_management', $data);
        }

        public function reservations(){
            $data = [];
            $this->view('admin/reservations', $data);
        }
    }
?>