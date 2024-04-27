<?php
    class Home extends Controller{
        public function __construct(){
            //$this->userModel = $this->model('user');
        }

        public function index(){
            
            //$users = $this->userModel->getUsers();
            $data = [
                'title' => 'Welcome'
                //'user' => $users
            ];

            
            
            $this->view('pages/index', $data);
        }

        public function about(){
            $data = [
                'title' => 'About Us'
            ];
            $this->view('pages/about', $data);
        }

        


    }
?>