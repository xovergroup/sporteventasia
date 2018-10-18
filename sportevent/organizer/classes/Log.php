<?php 

class Log {
    
    private $database = null;
    private $imploded;
        
    public $table = "logs";  
    private $columns = array("log_id", "log_action", "log_user", "log_user_type", "log_created_at");
    private $column_create = array("log_action", "log_user", "log_user_type", "log_created_at");
    
    public $identifierColumn, $identifierValue, $columnName, $columnValue, $tableName, $sql, $status, $result, $total, $countResult, $id, $action, $user, $userType, $createdAt;
    
    private $col_id                 = "log_id";
    private $col_action             = "log_action";
    private $col_user               = "log_user";
    private $col_user_type          = "log_user_type";
    private $col_datetime_created   = "log_created_at";
    
    
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
    
    
    /* ------------------------------------ MAIN ------------------------------------ */
    public function create(){
    
        if(isset($this->action) && isset($this->user) && isset($this->userType)) {
            
            $action         = $this->database->real_escape_string($this->sanitizeStringV2($this->action));
            $user           = $this->database->real_escape_string(intval($this->user));
            $user_type      = $this->database->real_escape_string(intval($this->userType));
            $date           = new DateTime();
            $dateTimeToday  = $date->format("Y-m-d H:i:s");
            $imploded       = $this->implodedArray($this->column_create);
            
            $sql = "INSERT INTO ".$this->table." (".$imploded.") VALUES('".$action."', ".$user.", ".$user_type.", '".$dateTimeToday."') ";
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
            $this->status = "Something is not set";
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
    
    public function deleteV2(){
        
        if(isset($this->id) && isset($this->tableName) && isset($this->identifierColumn)){
            
            
            $id                 = $this->database->real_escape_string(intval($this->id));
            $table              = $this->database->real_escape_string($this->sanitizeStringV2($this->tableName));
            $identifier_column  = $this->database->real_escape_string($this->sanitizeStringV2($this->identifierColumn));
            
            $sql    = "DELETE FROM ".$table." WHERE ".$identifier_column." = ".$id;
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
                        
                        $this->id           = $row->log_id;
                        $this->action       = $row->log_action;
                        $this->user         = $row->log_user;
                        $this->userType     = $row->log_user_type;
                        $this->createdAt    = $row->log_created_at;
                         
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