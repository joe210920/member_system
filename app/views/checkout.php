<!doctype html>
<html>

<head>
	<meta charset="utf8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
	<script>
	</script>
</head>

	<?php 
	   session_start();
	   $user = $_SESSION["user"];
	   $orders = $_SESSION["orders"];
	   $totalPrice = $orders[0]->totalPrice;
	   $shopping_date = $orders[0]->shopping_date;
	   
	   
	?>

<body>
	

</body>
	<h1><?php echo $user->name;?>的結帳頁面</h1>
	
	
	<table border="1">
        <tr>
        	<td>產品品編號</td>
        	<td>產品名稱</td>
       		<td>產品價格</td>
       		<td>訂購數量</td>
       		
        </tr>
		<?php 
	       if(!empty($orders)) {
	           foreach($orders as $value) {
	                   $html = "
                           <tr>
                               <td>$value->product_id</td>
                               <td>$value->product_name</td>
                               <td>$value->price</td>
                               <td>$value->number</td>
                           </tr>
                       ";
	                   echo $html;
	           }
	       }
	   ?>
		<tr>
			<td colspan="2" align="right">總價錢:&nbsp&nbsp<?php echo $totalPrice;?>元</td>
			<td colspan="2" align="right">訂購時間:&nbsp&nbsp<?php echo $shopping_date;?>
		</tr>
	
	</table>
	
	
	
	

</html>