<?php
namespace  app\utils;


class DB {
    /**
     * MYSQL connect
     */
    public function __construct() {
       $host =  "localhost";
       $db   =  "member_db";
       $user =  "root";
       $pass =  "";
       $port =  3306;
        
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8mb4"
        ];
        $dsn = "mysql:host=$host;dbname=$db;port=$port";
        try {
            $this->pdo = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }       
    }
    
    /**
     * msql query sql
     * @param string $sql
     * @return array[]
     */
    public function query($sql, $params =null) {
        
        $stmt = $this->pdo->prepare($sql);
        
        if ($params){
            $stmt->execute($params); 
        } else {
            $stmt->execute();
        }
         
        $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
          
        $stmt->closeCursor();
        
        return $rows;
    }
    
    /**
     * mysql update sql
     * @param sting  $sql
     * @return boolean
     */
    public function insert($sql, $params=null){
        $stmt = $this->pdo->prepare($sql);
        
        if ($params){
            $stmt->execute($params);
        } else{
            $stmt->execute();
        }
        return $stmt->rowCount();
    }
    
    //測試()不成功
    public function TestInser($sql) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
    public function delete($sql, $params=null){
        $stmt = $this->pdo->prepare($sql);
        
        if ($params){
            $stmt->execute($params);
        } else{
            $stmt->execute();
        }
        
        return $stmt->rowCount();
    }
    
    /**s
     * mysql update sql
     * @param sting  $sql
     * @return boolean
     */
    public function update($sql, $params=null){
        $stmt = $this->pdo->prepare($sql);
        
        if ($params){
            $stmt->execute($params); 
        } else{
            $stmt->execute();
        }
  
        return $stmt->rowCount();
    }
    
    /**
     * mysql update batch sql
     * @param sting  $sql
     * @return boolean
     */
    public function updateBatch($sql, $params=null){
        $stmt = $this->pdo->prepare($sql);
        try {
            if ($params) {
                foreach ($params as $param) {
                    $stmt->execute($param);
                }
            } else {
                $stmt->execute();
            }
           
        }catch (\Exception $e){
            throw $e;
        }
        return $stmt->rowCount();
    }
    
    /**
     * mysql update batch for Transaction
     * @param sting  $sql
     * @return boolean
     */
    public function updateBatchTransaction($sql, $params=null){
        $stmt = $this->pdo->prepare($sql);
        try {
            $this->pdo->beginTransaction();
            if ($params) {
                foreach ($params as $param) {
                    $stmt->execute($param);
                }
            } else {
                $stmt->execute();
            }
            $this->pdo->commit();
        }catch (\Exception $e){
            $this->pdo->rollBack();
            throw $e;
        }
        return $stmt->rowCount();
    }
    
    /**
     * get mysql connetcion
     * @return unknown
     */
    public function getConn(){
        return $this->pdo;
    }
    
    /**
     * Auto close db connetcion
     */
    public function __destruct() {
       $this->pdo = null;
    }
}

 