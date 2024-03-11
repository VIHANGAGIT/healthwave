<?php


    class Reservation{
            private $db;
            
            public function __construct(){
                $this->db = new Database;
            }

            public function getReservations($id){
                
                $this->db->query('SELECT * FROM reservation WHERE Doctor_ID = :id');
                $this->db->bind(':id', $id);

                // Fetch all the rows from the result set
                $reservations = $this->db->resultSet();

                // Check if any rows were returned
                if ($this->db->rowCount() > 0) {
                    return $reservations;
                } else {
                    return false;
                }

                
            }
    }
?>