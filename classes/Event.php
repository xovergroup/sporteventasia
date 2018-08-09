<?php 

class Event {
    
    private $database = null;
    private $imploded;
    
    private $table = "events";
    private $table_category = "event_category";
    private $table_type = "event_type";
    private $columns = array("event_id", "event_title", "event_date_start", "event_date_end", "event_time_start", "event_time_end", "event_venue", "event_state", "event_banner_image", "event_thumbnail", "event_description", "event_pax", "event_register_date_start", "event_register_date_end", "event_register_early_bird_end", "event_category", "event_price_original", "event_price_early_bird", "event_limit_slot", "event_type", "event_status", "event_created_at");
    private $columns_create    = array("event_title", "event_date_start", "event_date_end", "event_time_start", "event_time_end", "event_venue", "event_state", "event_banner_image", "event_thumbnail", "event_description", "event_pax", "event_register_date_start", "event_register_date_end", "event_register_early_bird_end", "event_category", "event_price_original", "event_price_early_bird", "event_limit_slot", "event_type", "event_status", "event_created_at");
    
    public $id, $title, $dateStart, $dateEnd, $timeStart, $timeEnd, $venue, $state, $bannerImage, $thumbnail, $desc, $pax, $regDateStart, $regDateEnd, $regEarlyBirdEnd, $category, $priceOriginal, $priceEarlyBird, $limitSlot, $type, $eventStatus, $createdAt, $sql, $status, $result, $identifierColumn, $identifierValue, $columnName, $columnValue, $tableName;
    private $col_id                         = "event_id";
    private $col_title                      = "event_title";
    private $col_date_start                 = "event_date_start";
    private $col_date_end                   = "event_date_end";
    private $col_time_start                 = "event_time_start";
    private $col_time_end                   = "event_time_end";
    private $col_venue                      = "event_venue";
    private $col_state                      = "event_state";
    private $col_banner_image               = "event_banner_image";
    private $col_thumbnail                  = "event_thumbnail";
    private $col_description                = "event_description";
    private $col_pax                        = "event_pax";
    private $col_register_date_start        = "event_register_date_start";
    private $col_register_date_end          = "event_register_date_end";
    private $col_register_early_bird_end    = "event_register_early_bird_end";
    private $col_category                   = "event_category";
    private $col_price_original             = "event_price_original";
    private $col_price_early_bird           = "event_price_early_bird";
    private $col_limit_slot                 = "event_limit_slot";
    private $col_type                       = "event_type";
    private $col_status                     = "event_status";
    private $col_created_at                 = "event_created_at";
    
    
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
        
        if(isset($this->title) && isset($this->dateStart) && isset($this->dateEnd) && isset($this->timeStart) && isset($this->timeEnd) && isset($this->venue) && isset($this->state) && isset($this->bannerImage) && isset($this->thumbnail) && isset($this->desc) && isset($this->pax) && isset($this->regDateStart) && isset($this->regDateEnd) && isset($this->regEarlyBirdEnd) && isset($this->category) && isset($this->priceOriginal) && isset($this->priceEarlyBird) && isset($this->limitSlot) && isset($this->type) && isset($this->$eventStatus)) {
            
            $title              = $this->database->real_escape_string($this->sanitizeStringV2($this->title));
            $date_start         = $this->database->real_escape_string($this->sanitizeStringV2($this->dateStart));
            $dateEnd            = $this->database->real_escape_string($this->sanitizeStringV2($this->dateEnd));
            $timeStart          = $this->database->real_escape_string($this->sanitizeStringV2($this->timeStart));
            $timeEnd            = $this->database->real_escape_string($this->sanitizeStringV2($this->timeEnd));
            $venue              = $this->database->real_escape_string($this->sanitizeStringV2($this->venue));
            $state              = $this->database->real_escape_string(intval($this->state));
            $banner_image       = $this->database->real_escape_string($this->sanitizeStringV2($this->bannerImage));
            $thumbnail          = $this->database->real_escape_string($this->sanitizeStringV2($this->thumbnail));
            $desc               = $this->database->real_escape_string($this->sanitizeStringV2($this->desc));
            $pax                = $this->database->real_escape_string(intval($this->pax));
            $reg_date_start     = $this->database->real_escape_string($this->sanitizeStringV2($this->regDateStart));
            $reg_date_end       = $this->database->real_escape_string($this->sanitizeStringV2($this->regDateEnd));
            $reg_early_bird_end = $this->database->real_escape_string($this->sanitizeStringV2($this->regEarlyBirdEnd));
            $category           = $this->database->real_escape_string(intval($this->category));
            $price_original     = $this->database->real_escape_string($this->sanitizeStringV2($this->priceOriginal));
            $price_early_bird   = $this->database->real_escape_string($this->sanitizeStringV2($this->priceEarlyBird));
            $limit_slot         = $this->database->real_escape_string($this->sanitizeStringV2($this->limitSlot));
            $type               = $this->database->real_escape_string(intval($this->type));
            $status             = $this->database->real_escape_string(intval($this->$eventStatus));
            
            $date               = new DateTime();
            $dateTimeToday      = $date->format("Y-m-d H:i:s");
            $imploded           = $this->implodedArray($this->columns_create);
            
            
                
            $sql = "INSERT INTO ".$this->table." (".$imploded.") VALUES('".$title."', '".$date_start."', '".$dateEnd."', '".$timeStart."', '".$timeEnd."', '".$venue."', '".$state."', '".$banner_image."', '".$thumbnail."', '".$desc."', ".$pax.", '".$reg_date_start."', '".$reg_date_end."', '".$reg_early_bird_end."', ".$category.", '".$price_original."', '".$price_early_bird."', '".$limit_slot."', ".$type.", ".$status.", '".$dateTimeToday."') ";
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
        
        if(isset($this->id) && isset($this->title) && isset($this->dateStart) && isset($this->dateEnd) && isset($this->timeStart) && isset($this->timeEnd) && isset($this->venue) && isset($this->state) && isset($this->bannerImage) && isset($this->thumbnail) && isset($this->desc) && isset($this->pax) && isset($this->regDateStart) && isset($this->regDateEnd) && isset($this->regEarlyBirdEnd) && isset($this->category) && isset($this->priceOriginal) && isset($this->priceEarlyBird) && isset($this->limitSlot) && isset($this->type) && isset($this->$eventStatus)) {
            
            $id                 = $this->database->real_escape_string(intval($this->id));
            $title              = $this->database->real_escape_string($this->sanitizeStringV2($this->title));
            $date_start         = $this->database->real_escape_string($this->sanitizeStringV2($this->dateStart));
            $dateEnd            = $this->database->real_escape_string($this->sanitizeStringV2($this->dateEnd));
            $timeStart          = $this->database->real_escape_string($this->sanitizeStringV2($this->timeStart));
            $timeEnd            = $this->database->real_escape_string($this->sanitizeStringV2($this->timeEnd));
            $venue              = $this->database->real_escape_string($this->sanitizeStringV2($this->venue));
            $state              = $this->database->real_escape_string(intval($this->state));
            $banner_image       = $this->database->real_escape_string($this->sanitizeStringV2($this->bannerImage));
            $thumbnail          = $this->database->real_escape_string($this->sanitizeStringV2($this->thumbnail));
            $desc               = $this->database->real_escape_string($this->sanitizeStringV2($this->desc));
            $pax                = $this->database->real_escape_string(intval($this->pax));
            $reg_date_start     = $this->database->real_escape_string($this->sanitizeStringV2($this->regDateStart));
            $reg_date_end       = $this->database->real_escape_string($this->sanitizeStringV2($this->regDateEnd));
            $reg_early_bird_end = $this->database->real_escape_string($this->sanitizeStringV2($this->regEarlyBirdEnd));
            $category           = $this->database->real_escape_string(intval($this->category));
            $price_original     = $this->database->real_escape_string($this->sanitizeStringV2($this->priceOriginal));
            $price_early_bird   = $this->database->real_escape_string($this->sanitizeStringV2($this->priceEarlyBird));
            $limit_slot         = $this->database->real_escape_string($this->sanitizeStringV2($this->limitSlot));
            $type               = $this->database->real_escape_string(intval($this->type));
            $status             = $this->database->real_escape_string(intval($this->$eventStatus));
            
            $sql = "UPDATE ".$this->table." SET ";
            $sql .= $this->col_title." = '".$title."', ";
            $sql .= $this->col_date_start." = '".$date_start."', ";
            $sql .= $this->col_date_end." = '".$dateEnd."', ";
            $sql .= $this->col_time_start." = '".$timeStart."', ";
            $sql .= $this->col_time_end." = '".$timeEnd."', ";
            $sql .= $this->col_venue." = '".$venue."', ";
            $sql .= $this->col_state." = ".$state.", ";
            $sql .= $this->col_banner_image." = '".$banner_image."', ";
            $sql .= $this->col_thumbnail." = '".$thumbnail."', ";
            $sql .= $this->col_description." = '".$desc."', ";
            $sql .= $this->col_pax." = ".$pax.", ";
            $sql .= $this->col_register_date_start." = '".$reg_date_start."', ";
            $sql .= $this->col_register_date_end." = '".$reg_date_end."', ";
            $sql .= $this->col_register_early_bird_end." = '".$reg_early_bird_end."', ";
            $sql .= $this->col_category." = ".$category.", ";
            $sql .= $this->col_price_original." = '".$price_original."', ";
            $sql .= $this->col_price_early_bird." = '".$price_early_bird."', ";
            $sql .= $this->col_limit_slot." = '".$limit_slot."', ";
            $sql .= $this->col_type." = ".$type.", ";
            $sql .= $this->col_status." = ".$status." ";
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
                        
                        $this->id               = $row->event_id;
                        $this->title            = $row->event_title;
                        $this->dateStart        = $row->event_date_start;
                        $this->dateEnd          = $row->event_date_end;
                        $this->timeStart        = $row->event_time_start;
                        $this->timeEnd          = $row->event_time_end;
                        $this->venue            = $row->event_venue;
                        $this->state            = $row->event_state;
                        $this->bannerImage      = $row->event_banner_image;
                        $this->thumbnail        = $row->event_thumbnail;
                        $this->desc             = $row->event_description;
                        $this->pax              = $row->event_pax;
                        $this->regDateStart     = $row->event_register_date_start;
                        $this->regDateEnd       = $row->event_register_date_end;
                        $this->regEarlyBirdEnd  = $row->event_register_early_bird_end;
                        $this->category         = $row->event_category;
                        $this->priceOriginal    = $row->event_price_original;
                        $this->priceEarlyBird   = $row->event_price_early_bird;
                        $this->limitSlot        = $row->event_limit_slot;
                        $this->type             = $row->event_type;
                        $this->$eventStatus     = $row->event_status;
                        $this->createdAt        = $row->event_created_at;
                        
                        
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