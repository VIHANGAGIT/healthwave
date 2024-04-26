<?php
    class Page extends Controller{
        public function __construct(){
        }
        public function index(){
            
            $this->view('pages/not_found');
        }
    }