<?php 

class Merchandise {
    
    private $database = null;
    private $imploded;
    
    public $table = "event_merchandise";  
    private $columns = array("merchandise_id", "merchandise_name", "merchandise_image", "merchandise_variable", "merchandise_price", "merchandise_event", "merchandise_created_at");
    private $column_create = array("merchandise_name", "merchandise_image", "merchandise_variable", "merchandise_price", "merchandise_event", "merchandise_created_at");
    
    public $identifierColumn, $identifierValue, $columnName, $columnValue, $tableName, $sql, $status, $result, $total, $countResult, $id, $name, $image, $variable, $price, $event, $createdAt;
    
    private $col_id                 = "merchandise_id";
    private $col_name               = "merchandise_name";
    private $col_image              = "merchandise_image";
    private $col_variable           = "merchandise_variable";
    private $col_price              = "merchandise_price";
    private $col_event              = "merchandise_event";
    private $col_datetime_created   = "merchandise_created_at";
    
    
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
    
        if(isset($this->name) && isset($this->image) && isset($this->variable) && isset($this->price) && isset($this->event)) {
            
            $name           = $this->database->real_escape_string($this->sanitizeStringV2($this->name));
            $image          = $this->image;
            $variable       = $this->database->real_escape_string($this->sanitizeStringV2($this->variable));
            $price          = $this->database->real_escape_string($this->sanitizeStringV2($this->price));
            $event          = $this->database->real_escape_string(intval($this->event));
            $date           = new DateTime();
            $dateTimeToday  = $date->format("Y-m-d H:i:s");
            $imploded       = $this->implodedArray($this->column_create);
            
            $sql = "INSERT INTO ".$this->table." (".$imploded.") VALUES('".$name."', '".$image."', '".$variable."', ".$price.", ".$event.", '".$dateTimeToday."') ";
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
    
    public function update(){
        
        if(isset($this->name) && isset($this->image) && isset($this->variable) && isset($this->price) && isset($this->event)) {
            
            $id             = $this->database->real_escape_string(intval($this->id));
            $name           = $this->database->real_escape_string($this->sanitizeStringV2($this->name));
            $image          = $this->image;
            $variable       = $this->database->real_escape_string($this->sanitizeStringV2($this->variable));
            $price          = $this->database->real_escape_string($this->sanitizeStringV2($this->price));
            $event          = $this->database->real_escape_string(intval($this->event));
            
            $sql = "UPDATE ".$this->table." SET ";
            $sql .= $this->col_name." = '".$name."', ";
            $sql .= $this->col_image." = '".$image."', ";
            $sql .= $this->col_variable." = '".$variable."', ";
            $sql .= $this->col_price." = ".$price.", ";
            $sql .= $this->col_event." = ".$event." ";
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
                        
                        $this->id           = $row->merchandise_id;
                        $this->name         = $row->merchandise_name;
                        $this->image        = $row->merchandise_image;
                        $this->variable     = $row->merchandise_variable;
                        $this->price        = $row->merchandise_price;
                        $this->event        = $row->merchandise_event;
                        $this->createdAt    = $row->merchandise_created_at;
                         
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