<?php

namespace  app\controllers;
use app\dao\MemberDAO;

include_once $_SERVER['DOCUMENT_ROOT'] . "/member_system/autoload.php";

 
class MemberController{
    
    public function login(){
        //login 頁面送clinet端輸入的帳號密碼來驗證，透過MamberContollers至資料庫查詢
        
        $account = $_POST["account"];
        $password = $_POST["password"];
        
        $dao = new MemberDAO();
        
        $result =  $dao->exist($account, $password);//確認帳號跟密碼都存在的話，會回傳1，不存在的話為0
 
        //如果$result 數值為1
        //至資料庫撈出此帳戶的所有相關資料
        if ($result) {
            $member = $dao->getByAccount($account);
            //啟動session,將此使用者的資料透過session送至index.php頁面，進行後續作業
            session_start();
            $_SESSION["user"] = $member[0];
            header("Location:/member_system/app/views/index.php");
        } else {
            //反之則用$_REQUEST傳回錯誤的資訊至login,
            //由前端login頁面做訊息判斷處理
            $_REQUEST["msg"] = "帳號密碼錯誤，登入失敗";
            
            include dirname(__DIR__,3)."/member_system/app/views/login.php";
        }
        
    }
    
    public function callFn(){
        $account = $_GET["account"];
        $password = $_GET["password"];
        $name = $_GET["name"];
        $user_id = $_GET["user_id"];
        $phone_number = $_GET["phone_number"];
        date_default_timezone_set('Asia/Taipei');
        $register_date = date('Y/m/d H:i:s');
        
        //echo "CallFn function 接收參數:$register_date<br>";
        //呼叫 資料庫DAO
        $dao = new MemberDAO();
      
        //資料庫參數
        $member = [
            "account" => $account,
            "password" => $password,
            "name" => $name,
            "user_id" => $user_id,
            "phone_number" => $phone_number,
            "register_date" => $register_date
        ];
        
        //新增資料
        $result = $dao->insert($member);
        $dao->query(); 
        header("Location:/member_system/app/views/index.php");
    }
    //將資料秀出來
    public function getMembes() {
        $dao = new MemberDAO();
        echo json_encode($dao->query());    
    }
    
    //刪除資料
    public function delete() {
        $id = $_GET["id"];
        $dao = new MemberDAO();
        $result = $dao->delete($id);
        header("Location:/member_system/app/views/index.php");
    }
    //修改資料
    public function update() {
        $id = $_GET["id"];
        $account = $_GET["account"];
        $password = $_GET["password"];
        $name = $_GET["name"];
        $user_id = $_GET["user_id"];
        $phone_number = $_GET["phone_number"];
        
        $updateMember = [
            "account" => $account,
            "password" => $password,
            "name" => $name,
            "user_id" => $user_id,
            "phone_number" => $phone_number,
            
        ];
        
        $dao = new MemberDAO();
        $result = $dao->update($id, $updateMember);
        
        header("Location:/member_system/app/views/index.php");
    }
    //秀出單一資料
    public function get() {
        $id = $_GET["id"];
        $dao = new MemberDAO();
        $member = $dao->get($id);
        
        $_REQUEST["member"] = $member;
       
        include dirname(__DIR__,3)."/member_system/app/views/editData.php";
     
    }
}
 

if(isset($_GET["method"]) ){
    (new MemberController())->{$_GET["method"]}();
} else if (isset($_POST["method"])) {
    (new MemberController())->{$_POST["method"]}();
}
