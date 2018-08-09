<?php 

class Organiser {
    
    private $database = null;
    private $imploded;
    
    private $table            = "organisers";
    private $columns_create   = array("organiser_name", "organiser_person_in_charge", "organiser_contact_no", "organiser_email", "organiser_password", "organiser_salt", "organiser_created_at");
    
    
    public $id, $name, $person_in_charge, $contact, $email, $password, $salt, $total, $createdAt;
    private $col_id                 = "organiser_id";
    private $col_name               = "organiser_name";
    private $col_person_in_charge   = "organiser_person_in_charge";
    private $col_contact_no         = "organiser_contact_no";
    private $col_email              = "organiser_email";
    private $col_password           = "organiser_password";
    private $col_salt               = "organiser_salt";
    private $col_created_At         = "organiser_created_at";
    
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

        if(isset($this->name) && isset($this->person_in_charge) && isset($this->contact) && isset($this->email) && isset($this->password)) {
            
            $name               = $this->database->real_escape_string($this->sanitizeStringV2($this->name));
            $person_in_charge   = $this->database->real_escape_string($this->sanitizeStringV2($this->person_in_charge));
            $contact            = $this->database->real_escape_string($this->sanitizeStringV2($this->contact));
            $email              = $this->database->real_escape_string($this->sanitizeStringV2($this->email));
            $password           = $this->database->real_escape_string($this->sanitizeStringV2($this->password));
            $hash               = $this->hashPassword($password);
            $date               = new DateTime();
            $dateTimeToday      = $date->format("Y-m-d H:i:s");
            $imploded           = $this->implodedArray($this->columns_create);
            $total              = $this->checkOrganiserExistByEmail();
            
            if($total < 1) {
                
                $sql = "INSERT INTO ".$this->table." (".$imploded.") VALUES('".$name."', '".$person_in_charge."', '".$contact."', '".$email."', '".$hash["encrypted"]."', '".$hash["salt"]."', '".$dateTimeToday."') ";
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
                
                $this->status   = $email. " is already registered";;
                $this->sql      = $sql;
                $this->result   = "Failed";
                
            }
            
        } else {
            $this->status       = "Something is not set";
        }
    }
    
    public function checkExistByEmail(){
        
        if(isset($this->email)){
            
            $email  = $this->database->real_escape_string($this->sanitizeStringV2($this->email));
            $sql    = "SELECT COUNT(".$this->col_id.") AS total FROM ".$this->table." WHERE ".$this->col_email." = '".$email."'";
            $result =  $this->database->query($sql);

            if($result) {

                $this->status   = "Success";
                $this->sql      = $sql;

                if($row = $result->fetch_object()) {
                    $total    = $row->total;
                }

            } else {

                $this->status   = "Query Failed";
                $total    = 0;
                
            }
            
            return $total;
            
        } else {
            $this->status       = "Email is not set";
        }
        
    }
    
    public function update(){
        
        if(isset($this->id) && isset($this->name) && isset($this->person_in_charge) && isset($this->contact) && isset($this->email)) {
            
            $id                 = $this->database->real_escape_string(intval($this->id));
            $name               = $this->database->real_escape_string($this->sanitizeStringV2($this->name));
            $person_in_charge   = $this->database->real_escape_string($this->sanitizeStringV2($this->person_in_charge));
            $contact            = $this->database->real_escape_string($this->sanitizeStringV2($this->contact));
            $email              = $this->database->real_escape_string($this->sanitizeStringV2($this->email));
            
            $sql = "UPDATE ".$this->table." SET ";
            $sql .= $this->col_name." = '".$name."', ";
            $sql .= $this->col_person_in_charge." = '".$person_in_charge."', ";
            $sql .= $this->col_contact_no." = '".$contact."', ";
            $sql .= $this->col_email." = '".$email."' ";
            $sql .= "WHERE ".$this->col_id." = ".$id;
          
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
            $result =  $this->database->query($sql);

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
                        
                        $this->name             = $row->organiser_name;
                        $this->person_in_charge = $row->organiser_person_in_charge;
                        $this->contact          = $row->organiser_contact_no;
                        $this->email            = $row->organiser_email;
                        $this->createdAt        = $row->organiser_created_at;
                        
                    }
                    //$result->close();
                    
                } else {

                    $this->status       = "Success, but no result";
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
    
    public function selectOneByEmail(){
        
        if(isset($this->email)){
            
            $email = $this->database->real_escape_string($this->sanitizeStringV2($this->email));
            
            $sql = "SELECT * FROM ".$this->table."  WHERE ".$this->col_email." =  '".$email."' ";
            $result = $this->database->query($sql);

            if($result) {

                if($result->num_rows > 0) {

                    if($row = $result->fetch_object()){
                        
                        $this->status       = "Success";
                        $this->sql          = $sql;
                        
                        $this->name             = $row->organiser_name;
                        $this->person_in_charge = $row->organiser_person_in_charge;
                        $this->contact          = $row->organiser_contact_no;
                        $this->email            = $row->organiser_email;
                        
                    }
                    //$result->close();
                    
                } else {

                    $this->status       = "Success, but no result";
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