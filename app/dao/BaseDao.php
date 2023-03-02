<?php
namespace  app\dao;
use app\utils\DB; 
abstract class BaseDao{
    public  $db;  
   
    function __construct() {
        
        $this->db  = new DB();
    }
    
    
    
    
    
}