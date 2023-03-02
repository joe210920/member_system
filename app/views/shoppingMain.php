<?php
    session_start();
    if(!isset($_SESSION["user"])) {
        header("Location:/member_system/app/views/loginShoping.php");
    }
    $user = $_SESSION["user"];
   
      
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>歡迎<?php echo $user->name;?>來到購物車</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
	
	function checkShopppingCar() {
		window.location.href  = "/member_system/app/controllers/ShopingContollers.php?method=checkShopppingCar";
	}
	
	function addShoppingCar(product_id, number) {
		if(number <= 99 && number > 0){	
			window.location.href = "/member_system/app/controllers/ShopingContollers.php?method=addShoppingCar&product_id="+product_id+"&number="+number;
			alert("加入購物車成功");
		}
		else { 
			alert("請輸入1~99之間的數字");
			return false;
		}
	}
	
	function getProduct(){
		$.post("/member_system/app/controllers/ShopingContollers.php",{"method":"getProduct"},function(result){
			var list =  JSON.parse(result);
			var  html = `
				<table border="1">
		 			<tr>
			 			<td>商品名稱</td>
			 			<td>庫存</td>
			 			<td>單價</td>
			 			<td>產品照片</td>
			 			<td>訂購數量</td>
			 			<td>功能</td>
			 		</tr>		 	
			`;

			list.forEach(function(row,  i){
				var img ="尚無圖片";
				if (row.img_path){
					img = `<img src="${row.img_path}" width="40%" alt="無圖片">`;
				}
				html += `
					<tr>
			 			<td>${row.product_name}</td>
			 			<td>${row.stock}</td>
			 			<td>${row.price}</td>
		 				<td width="150">${img}</td>
			 			<td>
							<input type="number" id="number${i}" name="number" min="1" max="99" value="0"/>	
		 				</td>
						<td>
							<input type="button" value="加入購物車" onclick="addShoppingCar(${row.product_id}, $('#number${i}').val())"/>									
						</td>
		 			</tr>
				`;
			});
			html+=`
				</table>
			`;
			$("#product").html(html);
		   
		});
	}	

	$(function(){
		
		getProduct();
		
		$("#search2").click(function(){
			getProuct();
		});
	});
</script>
</head>
<body>
<h1>購物車</h1>
 <form action="/member_system/app/controllers/ShopingContollers.php" method="post" id="form" name="form" enctype="multipart/form-data">
 	<input type="hidden" name="method" value="callFn">
 	<input type="button" name="search" id="search" value="查詢全部商品" onclick="getProduct()">
 	<input type="button" name="search2" id="search2" value="查看購物車" onclick="checkShopppingCar()">
	
 </form>  	
 <br>
 <div id="product">
 	 
 </div> 
</body>
</html>