<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Insert title here</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">

<?php 
   if (isset($_REQUEST["msg"])){
       
       $msg = $_REQUEST["msg"];
       echo "alert('$msg')";
   }
?>	

$(function(){
	$("#send").click(function(){
		if (!$("#account").val()) {
			alert("請輸入帳號!");
			$("#account").focus();
			return false;
		}

		if (!$("#password").val()){
			alert("請輸入密碼!");
			$("#password").focus();
			return false;
		}	

		$("#form").submit();
	});
})
</script>
</head>
<body>
 
 <form action="/member_system/app/controllers/ShopingContollers.php" method="post" id="form" name="myform">

 	<h3>登入購物車系統</h3>
 	<input type="hidden" name="method" value="login">
 	帳號: <input type="text" name="account" id="account" ><br>
 	密碼: <input type="password" name="password" id="password" ><br>
 	<input type="button" id="send" value="登入"/>
 </form>  	
</body>
</html>