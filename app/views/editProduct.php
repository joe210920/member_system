<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>修改網頁</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php 
$product = $_REQUEST['product'][0];

//$membertext = json_encode($_REQUEST['member']); //轉成json物件
//$dataArr = json_decode($membertext, true);//轉成php物件或是陣列

 
$product_id = $product->product_id;
$product_name = $product->product_name; 
$stock = $product->stock;
$price = $product->price;
$img = $product->img_path;
$file_name ="";
if(!empty($img ) && $img != "尚無圖片") {
    $temp = explode('/', $img);//分割字串，將字串轉成陣列
    $file_name = $temp[2];
} else {
    $file_name= "無產品照片";
}
?>
<script>

$(function(){
	
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
		getShoping();
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
<h1>產品新增修改介面</h1>
 <form action="/member_system/app/controllers/ShopingContollers.php" method="post" id="form" enctype="multipart/form-data">
 	<input type="hidden" name="method" value="update">
 	<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
 	產品ID<input type="text" name="product_id" id="product_id"  readonly value="<?php echo $product_id; ?>" ><br><br>
 	產品名稱: <input type="text" name="product_name" id="product_name" value="<?php echo $product_name; ?>" ><br><br>
 	庫存: <input type="text" name="stock" id="stock" value="<?php echo $stock;?>" ><br><br>
 	單價: <input type="text" name="price" id="price"  value="<?php echo $price; ?>"><br><br>
 	更換產品照片: <input type="file" name="img" size="50" id="img"><br><br>
 	照片名稱：<?php echo $file_name;?><br><br>
 	<input type="submit" name="send1" id="send1" value="更新" > &nbsp&nbsp <input type="reset" value="還原商品資料">
 	
 </form>
	
</body>
</html>