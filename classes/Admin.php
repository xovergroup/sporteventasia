<?php 


class Admin {
    
    private $database = null;
    private $imploded;
    private $table = "admins";
    private $col_username = "admin_username";
        
    public $sql, $status, $result, $total, $countResult, $data, $id, $condition, $conditionColumn, $username, $password;
    
    /* ------------------------------------ MISC ------------------------------------ */
    public function __construct($database) {
        $this->database = $database;
    }
    
    public function hashPassword($password){
    
        $salt       = sha1(rand());
        $salt       = substr($salt, 0, 10);
        $encrypted  = password_hash($password.$salt, PASSWORD_DEFAULT);
        $hash       = array("salt" => $salt, "encrypted" => $encrypted);

        return $hash;

    }
    
    public function login(){
        
        if(isset($this->username) && isset($this->password)) {
           
            $sql = "SELECT * FROM ".$this->table." WHERE ".$this->$col_username." = '".$this->username."' ";
            $result = $this->database->query($sql);
            if($result->num_rows > 0){
                
                if($row = $result->fetch_object()) {

                    $salt                   = $row->admin_salt;
                    $db_encrypted_password  = $row->admin_password;

                    if(password_verify($this->password.$salt, $db_encrypted_password)){

                        $_SESSION["admin_id"]       = $row->admin_id;
                        $_SESSION["admin_username"] = $row->admin_username; 
                        $_SESSION["admin_session"]  = true;
                        $_SESSION["admin_status"]   = "Logged In";


                    } else {
                        $_SESSION["admin_session"] = false;
                        $_SESSION["admin_status"] = "Wrong Password";
                    }

                } else {
                    $_SESSION["admin_session"] = false;
                    $_SESSION["admin_status"] = "Cannot get data";
                }
            } else {
                $_SESSION["admin_session"] = false;
                $_SESSION["admin_status"] = "Admin does not exist";
            }
        }
    }
    
    public function logout(){
        
        session_destroy();
    }
    
    public function checkAdminExist(){
        
        if(isset($this->username)) {
            
            
            $sql = "SELECT COUNT(admin_id) AS total FROM ".$this->table." WHERE admin_username = '".$this->username."' ";
            $result = $this->database->query($sql);
            
            if($result) {
                $this->status   = "Success";
                $this->sql      = $sql;
                $this->result   = $result;
                
                if($row = $result->fetch_object()){
                        
                    $this->status       = "Success";
                    $this->sql          = $sql;
                    $this->countResult  = $row->total;
                }

            } else {

                $this->status       = "Failed";
                $this->sql          = $sql;
                $this->result       = "Query Failed";

            }
        }
    }
    
    
    
}





?>