<?php
namespace  app\dao;
use app\utils\DB; 
use app\dao\BaseDao;


class ShoppingDAO extends BaseDao{
    
    public function __construct()
    {
        parent::__construct();
        //$this->db = new ShopingDB();
    }
    
    public function insert($shopping){
        //echo  "Call Shopping DOA<br>";
        
        $sql = "insert into product (product_name, stock, price, img_path, create_date, edit_date) values(:product_name, :stock,
                                 :price, :img_path, :create_date, :edit_date)";
        $count =  $this->db->insert($sql, $shopping);
        return $count;
    }
    
    public function query() {
        
        $sql = "select * from product";
        $list = $this->db->query($sql);
        
        return $list;        
    }
    
    public function delete($product_id) {
        
        $sql = "delete from product where product_id = $product_id";
        $count = $this->db->delete($sql);
        return $count;        
    }
    
    public function update($product_id, $updateShopping) {
        $product_id = $updateShopping['product_id'];
        $product_name = $updateShopping['product_name']; 
        $stock = $updateShopping['stock'];
        $price = $updateShopping['price'];
        $img_path = $updateShopping['img_path'];
        $edit_date = $updateShopping['edit_date'] ;
        
        $sql = "update product set product_name='$product_name', stock='$stock', price='$price', img_path='$img_path', edit_date='$edit_date' where product_id = " . $product_id;
        $result = $this->db->update($sql);
        return $result;
    }
    
    public function get($product_id) {
        $sql = "select * from product where product_id = $product_id";
        $result = $this->db->query($sql);
        return $result;
    }
}