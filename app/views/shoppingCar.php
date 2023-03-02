<!DOCTYPE html>
<html>
<head>
<meta charset="utf8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" >
 function delProduct(id){
	$("#productId").val(id);

	$("#form").submit();
 }

 function checkout() {
	window.location.href="/member_system/app/controllers/OrderController.php?method=checkout";
 }
 function showOrders() {
	window.location.href="/member_system/app/controllers/OrderController.php?method=showOrders";
 }
</script>
<?php
header('Content-type: text/html; charset=utf-8');

session_start();

$user = $_SESSION["user"];

$products = null;
if(!empty($_SESSION["products"])) {
    $products = $_SESSION["products"];        
}


?>
<body>
	<h1><?php echo $user->name;?>的購物車頁面</h1>	
	
	<table border="1" >
	<tr>
     	<td>產品編號</td>
        <td>產品名稱</td>
        <td>產品庫存</td>
        <td>產品價格</td>
        <td>產品照片</td>
        <td>訂購數量</td>
        <td>功能</td>
    </tr>
    	<?php
    	   if(!empty($products)) {
    	     
    	       foreach ($products as $value) {
    	           $html = "
        	           <tr>
            	           <td>$value->product_id</td>
            	           <td>$value->product_name</td>
            	           <td>$value->stock</td>
            	           <td>$value->price</td>
            	           <td><img src=$value->img_path alt=未上傳照片 width=100 heigh=100></td>
            	           <td>
            	           <input type=number id=num name=num min=1 max=99 value=$value->number >
            	           </td>
            	           <td>
            	           <input type=button value=取消訂購  onclick=delProduct($value->product_id) >
            	           </td>
        	           </tr>
    	           ";
    	           echo $html;
    	      }
    	
    	   } else {
    	       echo "未有商品加入購物車";
    	   }
    	?>   	            
	</table>
	<form action="/member_system/app/controllers/ShopingContollers.php" method="post" id="form" name="form">
		
		<input type="hidden" name="method" value="delProduct">
	   
		<input type="hidden" id="productId" name="productId">
	
	</form>
		
	<br><br>
		<input type=button name="back" value="回上一頁" onclick="history.back()">  
		<input type=button name="checkout" value="結帳" onclick="checkout()">   	
		<input type= button name="showOrders" value="查看訂單" onclick="showOrders()">
</body>
</html>