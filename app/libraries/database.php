<?php
    /*

    PDO database class
    Connect to the database
    Create prepaired statements
    Bind values
    Returns rows and results

    */

    class Database{
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;
        private $dbhandler;
        private $statement;
        private $error;

        public function __construct(){
            // Set Data Source Name (DSN)
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

            $options = [
                PDO::ATTR_PERSISTENT => true, // Enable persistent connection with db
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
            ];

            // Create new PDO instance
            try{

                $this->dbhandler = new PDO($dsn, $this->user, $this->pass, $options);

            }catch(PDOException $ex){

                $this->error = $ex->getMessage();
                echo $this->error;

            }

        }

        // Prepare statement with query
        public function query($sql){
            $this->statement = $this->dbhandler->prepare($sql);
        }

        // Bind values
        public function bind($param, $value, $type = null){
            if(is_null($type)){
                switch(true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                        break;
                }
            }

            $this->statement->bindValue($param, $value, $type);
        }

        // Execute the prepaired statement
        public function execute(){
            return $this->statement->execute();
        }

        // Get result as a array
        public function resultSet(){
            $this->execute();
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        }

        // Get single record
        public function singleRow(){
            $this->execute();
            return $this->statement->fetch(PDO::FETCH_OBJ);
        }

        // Get row count
        public function rowCount(){
            return $this->statement->rowCount();
        }
    }

