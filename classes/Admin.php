<?php 


class Admin {
    
    private $database = null;
    private $imploded;
    
    public $table = "admins";  
    private $columns = array("admin_id", "admin_username", "admin_password", "admin_salt", "admin_created_at");
    private $column_create = array("admin_username", "admin_password", "admin_salt", "admin_created_at");
    
    public $identifierColumn, $identifierValue, $columnName, $columnValue, $tableName, $sql, $status, $result, $total, $countResult, $id, $username, $password, $salt, $createdAt;
    
    private $col_id                 = "admin_id";
    private $col_username           = "admin_username";
    private $col_password           = "admin_password";
    private $col_salt               = "admin_salt";
    private $col_datetime_created   = "admin_created_at";
    
    /* ------------------------------------ MISC ------------------------------------ */
    public function __construct($database) {
        $this->database = $database;
    }
    
    public function sanitizeInt($var) {
        
        $var = intval($var);
        return $var;
    }
    
    public function sanitizeString($var) {

        $var = htmlentities($var);
        $var = strip_tags($var);
        $var = preg_replace('/\s+/', '', $var);
        return $var;
    }
    
    public function sanitizeStringV2($var) {

        $var = filter_var($var, FILTER_SANITIZE_STRING);
        $var = htmlentities($var);
        $var = strip_tags($var);

        return $var;
    }
    
    public function sanitizeStringV3($var) {

        $var = filter_var($var, FILTER_SANITIZE_STRING);
        $var = htmlentities($var);
        $var = strip_tags($var);
        $var = preg_replace('/\s+/', '', $var);

        return $var;
    }

    private function implodedArray($cols) {
        
        $imploded = implode(", ", $cols);
        return $imploded;
    }
    
    private function hashPassword($password){
    
        $salt       = sha1(rand());
        $salt       = substr($salt, 0, 10);
        $encrypted  = password_hash($password.$salt, PASSWORD_DEFAULT);
        $hash       = array("salt" => $salt, "encrypted" => $encrypted);

        return $hash;

    }
    
    /* ------------------------------------ MAIN ------------------------------------ */
    public function create(){
    
        if(isset($this->username) && isset($this->password)) {
            
            $check = $this->checkAdminExist();
            
            if($this->countResult < 1){
                
                $username       = $this->database->real_escape_string($this->sanitizeStringV2($this->username));
                $password       = $this->database->real_escape_string($this->sanitizeStringV2($this->password));
                $hash           = $this->hashPassword($password);
                $date           = new DateTime();
                $dateTimeToday  = $date->format("Y-m-d H:i:s");
                $imploded       = $this->implodedArray($this->column_create);

                $sql = "INSERT INTO ".$this->table." (".$imploded.") VALUES('".$username."', '".$hash["encrypted"]."', '".$hash["salt"]."', '".$dateTimeToday."') ";
                $result = $this->database->query($sql);

                if($result) {
                    $this->status   = "Success";
                    $this->sql      = $sql;
                    $this->result   = $result;

                } else {

                    $this->status       = "Failed";
                    $this->sql          = $sql;
                    $this->result       = "Query Failed";

                }  
            } else {
                
                $this->status   = "Dulicate admin username";
            }
            
            
        } else {
            $this->status = "Something is not set";
        }
    }
    
    public function login(){
        
        if(isset($this->username) && isset($this->password)) {
           
            $username = $this->database->real_escape_string($this->sanitizeStringV2($this->username));
            $password = $this->database->real_escape_string($this->sanitizeStringV2($this->password));
            
            $sql = "SELECT * FROM admins WHERE admin_username = '".$username."' ";
            $result = $this->database->query($sql);
            if($result->num_rows > 0){
                
                if($row = $result->fetch_object()) {

                    $salt                   = $row->admin_salt;
                    $db_encrypted_password  = $row->admin_password;

                    if(password_verify($password.$salt, $db_encrypted_password)){

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
            
            $username = $this->database->real_escape_string($this->sanitizeStringV2($this->username));
            
            $sql = "SELECT COUNT(admin_id) AS total FROM admins WHERE admin_username = '".$username."' ";
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
    
    
    public function updateOne(){
              
        if(isset($this->identifierColumn) && isset($this->identifierValue) && isset($this->columnName) && isset($this->columnValue) && isset($this->tableName)){
            
            $identifier_column  = $this->database->real_escape_string($this->sanitizeStringV2($this->identifierColumn));
            $identifier_value   = $this->database->real_escape_string($this->sanitizeStringV2($this->identifierValue));
            $column_name        = $this->database->real_escape_string($this->sanitizeStringV2($this->columnName));
            $column_value       = $this->database->real_escape_string($this->sanitizeStringV2($this->columnValue));
            $table_name         = $this->database->real_escape_string($this->sanitizeStringV2($this->tableName));
                                                                      
            $sql = "UPDATE ".$table_name." SET ";
            $sql .= $column_name." = '".$column_value."' ";
            $sql .= "WHERE ".$identifier_column." = '".$identifier_value."' ";
            
            $result = $this->database->query($sql);
          
            if($result) {
                $this->status   = "Success";
                $this->sql      = $sql;
                $this->result   = $result;

            } else {

                $this->status       = "Query Failed";
                $this->sql          = $sql;
                $this->result       = "Failed";

            }
        }
    }
    
    public function delete(){
        
        if(isset($this->id)){
            
            $id     = $this->database->real_escape_string(intval($this->id));
            $sql    = "DELETE FROM ".$this->table." WHERE ".$this->col_id." = ".$id;
            $result = $this->database->query($sql);

            if($result) {

                $this->status   = "Success";
                $this->sql      = $sql;

            } else {

                $this->status   = "Query Failed";
                $this->sql      = $sql;
                
            }
        }
    }
    
    public function selectOne(){
        
        if(isset($this->id)){
      
            $id = $this->database->real_escape_string(intval($this->id));
            
            $sql = "SELECT * FROM ".$this->table."  WHERE ".$this->col_id." = ".$id;
            $result = $this->database->query($sql);

            $the_object_array   = array();
            if($row = $result->fetch_object()) {

                $the_object_array[] = $row;
            }
            //$result->free();
            
            
            if(!empty($the_object_array)) {
            
                $item = array_shift($the_object_array);
            } else {
                $item = "No data";
            }
        
            return $item;
        } else {
            $this->status = "ID is not set";
        }
        
    }
    
    public function selectOneV2(){
        
        if(isset($this->id)){
            
            $id = $this->database->real_escape_string(intval($this->id));
            
            $sql = "SELECT * FROM ".$this->table."  WHERE ".$this->col_id." = ".$id;
            $result = $this->database->query($sql);
            
            if($result) {

                if($result->num_rows > 0) {

                    if($row = $result->fetch_object()){
                        
                        $this->status       = "Success";
                        $this->sql          = $sql;
                        
                        $this->id           = $row->admin_id;
                        $this->username     = $row->admin_username;
                        $this->createdAt    = $row->admin_created_at;
                        
                    }
                    //$result->close();
                    
                } else {

                    $this->status       = "Failure";
                    $this->sql          = $sql;
                    $this->countResult  = $result->num_rows;
                    $this->result       = "No result";
                }


            } else {

                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->result       = "Query Failed";
            }
        }
    }
    
    public function selectAll(){
        
        if(isset($this->sql)){
            
            $sql    = $this->sql;
            $result =  $this->database->query($sql);
        
            if($result) {

                if($result->num_rows > 0) {

                    $this->status       = "Success";
                    $this->sql          = $sql;
                    $this->result       = $result;
                    $this->total        = $result->num_rows;

                } else {

                    $this->status       = "Success";
                    $this->sql          = $sql;
                    $this->result       = "No Data";
                    $this->total        = $result->num_rows;

                }


            } else {

                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->result       = "Query Failed";

            }
             
        } else {
            $this->status = "SQL is not set";
        }
    }
    
}





?>