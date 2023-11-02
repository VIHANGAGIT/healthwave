<?php
    class Manager extends Controller{
        public function __construct(){
            //$this->managerModel = $this->model('user');
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
            $data = [];
            $this->view('manager/doc_management', $data);
        }

        public function test_management(){
            $data = [];
            $this->view('manager/test_management', $data);
        }

        public function reservations(){
            $data = [];
            $this->view('manager/reservations', $data);
        }
    }
?>