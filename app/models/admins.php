<?php 
    class Admins{
        private $db;
        
        public function __construct(){
            $this->db = new Database;
        }

        public function admin_data_fetch($id){
            $this->db->query('SELECT * FROM admin WHERE Admin_ID = :id');

            // Binding parameters for the prepaired statement
            $this->db->bind(':id', $id);
            $adminRow = $this->db->singleRow();

            // Execute query
            if($this->db->execute()){
                return $adminRow;
            } else{
                return false;
            }
        }

        public function admin_profile_update($data){
            $this->db->query('UPDATE admin SET First_Name = :F_name, Last_Name= :L_name, NIC = :NIC, Contact_No = :C_num, Username = :Uname, Password = :Pass WHERE Admin_ID = :Admin_ID');

            // Binding parameters for the prepaired statement
            $this->db->bind(':F_name', $data['First_Name']);
            $this->db->bind(':L_name', $data['Last_Name']);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':C_num', $data['C_Num']);
            $this->db->bind(':Uname', $data['Username']);
            $this->db->bind(':Pass', $data['Pass']);
            $this->db->bind(':Admin_ID', $data['Admin_ID']);

            // Execute query
            if($this->db->execute()){
                return true;
            } else{
                return false;
            }
        }
   
    }