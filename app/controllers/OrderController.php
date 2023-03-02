<?php
namespace app\controllers;
use app\dao\OrderDAO;
//use app\dao\ShoppingDAO;
//use app\dao\MemberDAO;
include_once $_SERVER['DOCUMENT_ROOT'] . "/member_system/autoload.php";


class OrderController {
    
    //將訂單的訂購人與訂購明細加入個別table
    public function checkout() {
        
        session_start();
        $user = $_SESSION["user"];
        $orderer_id = $user -> id;
        $products = $_SESSION["products"];
        
        $totalPrice  = 0;
        $i = 0;
        foreach($products as $pt) {
            
            $onePrice = (int)$pt->price * (int)$pt->number;
            
            $pt -> onePrice = $onePrice;
            $_SESSION["products"][$i] = $pt;
            
            $totalPrice = $totalPrice + $onePrice;
            $i++;
        }
        
        $order = [
            "orderer_id" => $orderer_id, 
            "totalPrice" => $totalPrice,
        ];
        
        $dao = new OrderDAO();
        $result = $dao->insertOrder($order);
         
        foreach($products as $pt) {
            
            $product_id = $pt->product_id;
            $product_name = $pt->product_name;
            $price = $pt->price;
            $number = $pt->number;
                   
            $orders_detail = [
                "orderer_id" => $orderer_id,
                "product_id" => $product_id,
                "product_name" => $product_name,
                "price" => $price,
                "number" => $number
            ];    
            $result = $dao->insertOrdersDetail($orders_detail);  
        }
        
        unset($_SESSION["products"]);
        
    }
    
    public function showOrders() {
        session_start();
        $user = $_SESSION["user"];
        $id = $user->id; 
        
        $dao = new OrderDAO();
        
        $result = $dao->showOrders($id);      
        $_SESSION["orders"] = $result;
        header("Location:/member_system/app/views/checkout.php");
    }
    

}



if(isset($_GET["method"])) {
    (new OrderController())->{$_GET["method"]}();
} else if (isset($_POST["method"])) {
    (new OrderController())->{$_POST["method"]}();
}
