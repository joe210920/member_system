<?php
namespace  app\dao;
use app\utils\DB; 
use app\dao\BaseDao;


class MemberDAO extends BaseDao{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function exist($account , $password){
        $sql = "select count(1) as count from user where account=:account and password=:password";
        $result  = $this->db->query($sql, [$account , $password]);
       
        return $result[0]->count;
    }
    
    public function getByAccount($account) {
        $sql = "select * from user where account = :account";
        $result = $this->db->query($sql, ["account"=>$account]);
        return $result;
    }
    
    public function insert($member){
        echo  "Call Member DOA<br>";
        
        $sql = "insert into user (account, password, name, user_id, phone_number, register_date) values(:account, :password,
                                 :name, :user_id, :phone_number, :register_date)";
        $count =  $this->db->insert($sql, $member);
        return $count;
    }
    
    public function query() {
        
        $sql = "select * from user";
        $list = $this->db->query($sql);
        
        return $list;        
    }
    
    public function delete($id) {
        
        $sql = "delete from user where id = $id";
        $count = $this->db->delete($sql);
        
        return $count;        
    }
    
    public function update($id, $updateMember) {
        
        $account = $updateMember['account']; 
        $password = $updateMember['password'];
        $name = $updateMember['name'];
        $user_id = $updateMember['user_id'];
        $phone_number = $updateMember['phone_number'] ;
        
        $sql = "update user set account='$account', password='$password', name='$name', user_id='$user_id', phone_number='$phone_number'  where id=" . $id;
        $result = $this->db->update($sql);
        return $result;
    }
    
    public function get($id) {
        $sql = "select * from user where id = $id";
        $result = $this->db->query($sql);
        return $result;
    }
}