<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Shoping</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
	
	
	function toEdit(product_id) {
		window.location.href  = "/member_system/app/controllers/ShopingContollers.php?method=get&product_id="+product_id;
	}
	function del(product_id) {
		
		window.location.href  = "/member_system/app/controllers/ShopingContollers.php?method=delete&product_id="+product_id;
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
			 			<td>建立時間</td>
	 					<td>修改時間</td>
			 			<td>功能</td>
			 		</tr>		 	
			`;

			list.forEach(function(row, i){
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
			 			<td>${row.create_date}</td>
						<td>${row.edit_date}</td>
						<td>
							<input type="button" value="編輯" onclick="toEdit(${row.product_id})">
							<input type="button" value="刪除" onclick="del(${row.product_id})">
						</td>
		 			</tr>
				`;
			})

			
			html+=`
				</table>
			`;
			
			$("#users").html(html);
		   
		});
	}	

	$(function(){
		getProduct();
		$("#send1").click(function(){
			if (!$("#product_name").val()) {
				alert("請輸入產品名稱!");
				$("#product_name").focus();
				return false;
			}
			if (!$("#stock").val()) {
				alert("請輸入庫存!");
				$("#stock").focus();
				return false;
			}		
			$check_stock = isRealNum($("#stock").val());
			$check_price = isRealNum($("#price").val());
			
			if ($check_stock && $check_price) {
				return true;
			} else if($check_stock == false){
				alert("請在庫存輸入數字!");
				$("#stock").val("");
				$("#stock").focus();
				return false;
			} else if($check_price == false) {
				alert("請在單價輸入數字!");
				$("#price").val("");
				$("#price").focus();
				return false;
			}
		});
		
		$("#search").click(function(){
			getProuct();
		});

		
});
    
function isRealNum(val){
	// isNaN()函数 把空串 空格 以及NUll 按照0来处理 所以先去除，
	    
	if(val === "" || val ==null){
	      return false;
	}
	
	if(!isNaN(val)){　　　　
	    //对于空数组和只有一个数值成员的数组或全是数字组成的字符串，
	    //isNaN返回false，例如：'123'、[]、[2]、['123'],isNaN返回false,
	    //所以如果不需要val包含这些特殊情况，则这个判断改写为if(!isNaN(val) && typeof val === 'number' )
		return true; 
	} else { 
		return false; 
	} 
}
	

</script>
</head>
<body>
<h1>商品管理</h1>
 <form action="/member_system/app/controllers/ShopingContollers.php" method="post" id="form" name="form" enctype="multipart/form-data">
 	<input type="hidden" name="method" value="callFn">
 	<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
 	產品名稱: <input type="text" name="product_name" id="product_name" ><br><br>
 	庫存: <input type="text" name="stock" id="stock" ><br><br>
 	單價: <input type="text" name="price" id="price" ><br><br>
 	上傳產品照片: <input type="file" name="img" size="50" id="img" ><br><br>	
 	<input type="submit" name="send1" id="send1" value="新增商品" > &nbsp&nbsp <input type="reset" value="清除商品資料">
 	&nbsp&nbsp&nbsp<input type="button" name="search" id="search" value="查詢全部商品" onclick="getProduct()">
 </form>  	
 
 <br><br>
 
 <div id="users">
 	 
 </div> 
</body>
</html>