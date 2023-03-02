<?php
namespace app\dao;
use app\utils\DB;
use app\dao\BaseDao;



class OrderDAO extends BaseDao {
    
    public function __construct() {
        parent::__construct();    
    }
    //訂單裡的訂購者與總共消費多少錢會放在這一個table裡面
    
    public function insertOrder($order) {
       
        $orderer_id =  $order["orderer_id"]; 
        $totalPrice = $order["totalPrice"];
        
        $sql = "insert into orders (orderer_id, totalPrice) values ($orderer_id, $totalPrice)";
        
        $count = $this->db->insert($sql);
        
        return $count;
    }
    
    //訂單明細
    public function insertOrdersDetail($orders_detail) {
       
        $orderer_id = $orders_detail["orderer_id"];
        $product_id  = $orders_detail["product_id"];
        $product_name = $orders_detail["product_name"];
        $price = $orders_detail["price"];
        $number = $orders_detail["number"];
        
        $sql = "insert into orders_detail(orderer_id, product_id, product_name, price, number)
               values($orderer_id, $product_id, '$product_name', $price, $number)";
        
        $count = $this->db->insert($sql);
        
        return $count;
    }
    //這要用關聯資料表去連結兩個資料表
    //然後秀在訂單頁面上
    public function showOrders($id) {
        $sql = "select orders.orderer_id, orders.totalPrice, orders.shopping_date, orders_detail.product_id, orders_detail.product_name, orders_detail.price,orders_detail.number 
               from orders inner join orders_detail on $id = $id";
        $list = $this->db->query($sql);
        return $list;
    }
}