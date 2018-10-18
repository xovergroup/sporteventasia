<?php 

class Order {
    
    private $database = null;
    private $sql = null;
    
    public function __construct($database, $sql) {
        $this->database = $database;
        $this->sql = $sql;
    }
    
    public function generateNewOrderNo(){
        
        $order              = $this->findLastOrderNo();
        $last_order_no      = $order->register_order_no;
        $raw_last_order_no  = $this->rawOrderNo($last_order_no, "SE");
        $new_order_no       = $this->processNewOrderNo($raw_last_order_no, "SE", "");
        
        return $new_order_no;
    }
    
    private function processNewOrderNo($raw_order_no, $prefix, $suffix){
        
        $raw_order_no++;
        return $prefix.str_pad($raw_order_no, 5, "0", STR_PAD_LEFT).$suffix; 
        
    }
    
    private function rawOrderNo($order_no, $removeString){
        
        return intval(str_replace($removeString, "", $order_no));
        
    }
    
    private function findLastOrderNo(){
        
        if(isset($this->sql)){
            
            $crud = new CRUD($this->database);
        
            $crud->sql = $this->sql;
            $order = $crud->selectOne();

            return $order;
            
        }
        
    }
    
}



?>