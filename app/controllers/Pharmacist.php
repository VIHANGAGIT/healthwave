<?php
    class Pharmacist extends Controller{
        public function __construct(){
            //$this->pharmacistModel = $this->model('user');
        }
        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [];
            
            $this->view('pharmacist/prescription_view', $data);
        }
    }