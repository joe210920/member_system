<?php

namespace  app\controllers;
use app\dao\ShoppingDAO;
use app\dao\MemberDAO;

include_once $_SERVER['DOCUMENT_ROOT'] . "/member_system/autoload.php";

 
class ShopingController{
    
    public function login() {
        $account = $_POST['account'];
        $password = $_POST['password'];
        
        $dao = new MemberDAO();
        
        $result = $dao->exist($account, $password);
        
        if($result) {
            $member = $dao->getByAccount($account);
            var_export($member);
            session_start();
            $_SESSION["user"] = $member[0];
            header("Location:/member_system/app/views/shoppingMain.php");
        } else {
            $_REQUEST['msg'] = "帳號密碼錯誤，帳號登入失敗";
            include dirname(__DIR__, 3) . "/member_system/app/views/loginShoppingCar.php";
        }
    }
    public function callFn(){
        $product_name = $_POST["product_name"];
        $stock = $_POST["stock"];
        $price = $_POST["price"];
        $img = $_FILES["img"];
        date_default_timezone_set('Asia/Taipei');
        $create_date = date('Y/m/d H:i:s');
        $edit_date = date('Y/m/d H:i:s');
        
        //將照片上傳至資料夾，將照片路徑存入資料庫
        $upload_dir = "../uploadFiles/";
        $image_upload_path = "";
        
        
        if( $_FILES['img']['name']){
            $input_image = $_FILES['img']['name'];
            $image_array = explode('.',$input_image);
            $rand = rand(10000,99999);
            $image_new_name = $image_array[0].$rand.'.'.$image_array[1];
            $image_upload_path = $upload_dir.$image_new_name;
            move_uploaded_file($_FILES["img"]["tmp_name"],$image_upload_path);  
        } 
        //echo "CallFn function 接收參數:$register_date<br>";
        //呼叫 資料庫DAO
        $dao = new ShoppingDAO();
        //資料庫參數
        $shoping = [
            "product_name" => $product_name,
            "stock" => $stock,
            "price" => $price,
            "img_path" => $image_upload_path,
            "create_date" => $create_date,
            "edit_date" => $edit_date
        ];
        
        //新增資料
        $result = $dao->insert($shoping);
        $dao->query(); 
        header("Location:/member_system/app/views/productIndex.php");
    }
    //將資料秀出來
    public function getProduct() {
        $dao = new ShoppingDAO();
        echo json_encode($dao->query());    
    }
    
    //刪除資料
    public function delete() {
        $product_id = $_GET["product_id"];
        $dao = new ShoppingDAO();
        $result = $dao->delete($product_id);
        header("Location:/member_system/app/views/productIndex.php");
    }
    //修改資料
   
    public function update() {
        $product_id = $_POST["product_id"];
        $product_name = $_POST["product_name"];
        $stock = $_POST["stock"];
        $price = $_POST["price"];
        $img = $_FILES["img"];
        date_default_timezone_set('Asia/Taipei');
        $edit_date = date('Y/m/d H:i:s');
       
        //將照片上傳至資料夾，將照片路徑存入資料庫
        $upload_dir = "../uploadFiles/";
        $image_upload_path = "";
        
        if( $_FILES['img']['name']){
            $input_image = $_FILES['img']['name'];
            $image_array = explode('.',$input_image);
            $rand = rand(10000,99999);
            $image_new_name = $image_array[0].$rand.'.'.$image_array[1];
            $image_upload_path = $upload_dir.$image_new_name;
            move_uploaded_file($_FILES["img"]["tmp_name"],$image_upload_path);
        } 
        $updateShoping = [
            "product_id" => $product_id,
            "product_name" => $product_name,
            "stock" => $stock,
            "price" => $price,
            "img_path" => $image_upload_path,
            "edit_date" => $edit_date
        ];
        
        $dao = new ShoppingDAO();
        $result = $dao->update($product_id, $updateShoping);
        
        header("Location:/member_system/app/views/productIndex.php");
    }
   
    //秀出單一資料
    public function get() {
        $product_id = $_GET["product_id"];
        $dao = new ShoppingDAO();
        $product = $dao->get($product_id);     
        $_REQUEST["product"] = $product;
       
        include dirname(__DIR__,3)."/member_system/app/views/editProduct.php";
    }
    //將加入購物車的資料傳到購物車頁面
    public function addShoppingCar() {
        $product_id = $_GET["product_id"];
        $number = intval($_GET["number"]);
        $dao = new ShoppingDAO();
        $product = $dao->get($product_id);
        session_start();
             
        if (isset($_SESSION["products"])) {
           
            $products = $_SESSION["products"];
            
            $i=0;
            
            $flag = false;
            
            foreach ($products as $pt) {
               
                if ($pt->product_id == $product_id) {
                   
                    $pt -> number = $pt -> number + $number;
                   
                    $_SESSION["products"][$i] = $pt;
                    $flag = true;
                    break;
                }
                
                $i++; 
            }
         
            if (!$flag){
                $product[0] -> number = $number;
                array_push($_SESSION["products"], $product[0]);
            }  
        } else {
            
            $product[0] -> number = $number;
            $_SESSION["products"] = [$product[0]];
        }
          
        if(isset($_SESSION["products"])) {
            $_SESSION["addShoppingCarMsg"] = "加入購物車成功";
            header("Location:/member_system/app/views/shoppingMain.php");
        } else {
            $_SESSION["addShoppingCarMsg"] = "加入購物車失敗";
            header("Location:/member_system/app/views/shoppingMain.php");
        }
       
    }
    public function checkShopppingCar() {
        header("Location:/member_system/app/views/shoppingCar.php");
    }
    
    public function delProduct(){
        $productId = $_POST["productId"];
        
        session_start();
        
        $products = $_SESSION["products"];
       
        $i=0;
        foreach ($products as $product) {
            
           if ( $product->product_id == $productId) {
               unset($products[$i]);    
               break;
           }
           $i++;
        }
         
        $_SESSION["products"] = $products;
        header("Location:/member_system/app/views/shoppingCar.php");
    }
    
    
   
    
}

if(isset($_GET["method"]) ){
    (new ShopingController())->{$_GET["method"]}();
} else if (isset($_POST["method"])) {
    (new ShopingController())->{$_POST["method"]}();
}

