<?php
    /*

    App core class
    Creates URL & loads core controller
    URL format - /controller/method/params

    */

    class Core{
        protected $currentController = 'Home';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
           
            //print_r($this->getUrl());

            $url = $this->getUrl();

            // Look in controllers for first value
            if(isset($_GET['url'])){
                if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){ // ucwords capitalize the first letter as in controller
                    
                    // If exists, set as current controller
                    $this->currentController = ucwords($url[0]);

                    // Unset 0th index
                    unset($url[0]);
                }
            }

            // Require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';

            // Instantiate controller class
            $this->currentController = new $this->currentController;


        }

        // Function for getting params from url
        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/'); // Remove ending / from URL
                $url = filter_var($url, FILTER_SANITIZE_URL); // Sanitize the URL to remove unwanted characters
                $url = explode('/', $url); // Split URL from / to get each param
                return $url;

            }
        }
    }