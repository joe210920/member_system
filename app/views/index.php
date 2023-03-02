<?php 
    //在這頁面啟用session 去接收login透過MemberContollers傳來的session資料
   session_start();
   if (!isset($_SESSION["user"])) {
       header("Location:/member_system/app/views/login.php");
   }
   //用一個變數來接上一層MemberContollers上傳來的session 的使用者資料
   $user = $_SESSION["user"];
   
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Insert title here</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">

	function toEdit(id) {	
		window.location.href  = "/member_system/app/controllers/MemberContollers.php?method=get&id="+id;
	}
	function del(id) {
		window.location.href  = "/member_system/app/controllers/MemberContollers.php?method=delete&id="+id;
	}
	function getMemer(){
		$.get("/member_system/app/controllers/MemberContollers.php",{"method":"getMembes"},function(result){
			console.log(result);
			var  list =  JSON.parse(result);
			
			var  html = `
				<table border="1">
		 			<tr>
			 			<td>姓名</td>
			 			<td>帳號</td>
			 			<td>密碼</td>
			 			<td>身分證號碼</td>
			 			<td>手機號碼</td>
	 					<td>註冊時間</td>
			 			<td align="center">功能</td>
			 		</tr>
			 	
			`;

			list.forEach(function(row, i){
				html += `
					<tr>
			 			<td>${row.name}</td>
			 			<td>${row.account}</td>
			 			<td>${row.password}</td>
			 			<td>${row.user_id}</td>
			 			<td>${row.phone_number}</td>
						<td>${row.register_date}</td>
						<td>
							<input type="button" value="編輯" onclick="toEdit(${row.id})"/>
							<input type="button" value="刪除" onclick="del(${row.id})"/>
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
		//alert("onload function")
		getMemer();

		$("#send").click(function(){

			if (!$("#account").val()) {
				alert("請輸入帳號!");
				$("#account").focus();
				return false;
			}

			if(!$("#password").val()) {
				alert("請輸入密碼");
				$("#password").focus();
			}
			
			var pwdCheck = equals($("#password").val(), $("#password_check").val());
			var uidCheck = check_user_id($("#user_id").val()); 
			
			if(!$("#user_id").val()) {
				alert("請輸入身分字號!");
				$("#user_id").focus();
				return false;
			}
			
			
			if(uidCheck == 1 && pwdCheck == 1) {
				return true;	
			} else if(pwdCheck == 0) {
				alert("請檢查輸入密碼是否一致");
				$("#password").val("");
				$("#check_password").val("");
				return false;
			} else if(uidCheck == 0) {
				alert("請檢查身份字號是否輸入正確");
				return false;
			} else {
				$("#user_id").val("");
				$("#user_id").focus();
				return false;
			}
		});
		
		$("#send2").click(function(){
			getMemer();
		});
		
    });


	function equals(str1, str2) {    
	    if(str1 == str2)    
	    {    
	        return 1;    
	    }    
	    return 0;    
	}  
	
	function check_user_id(user_id) {
		
		
		user_id = user_id.toUpperCase();
		
		var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		var num = new Array(10, 11, 12, 13, 14, 15, 16, 17, 34, 18, 19, 20, 21, 22, 35, 23, 24, 25, 26, 27, 28, 29, 32, 30, 31, 33);
		if(user_id.length == 0) {
			alert("請填寫身份字號");
			return 0;
		}
		if(user_id.length > 10 && user_id.length <10) {
			alert("身份字號只有10碼");
			return 0;
		}
		var firstWordIndex = tab.indexOf(user_id.charAt(0));
		if(firstWordIndex == -1) {
			alert("身份字號第一碼為大寫英文字母");
			return 0;
		}
		var strWord = "" + num[firstWordIndex];
		
		for(var i = 1; i < user_id.length; i++) {
			strWord += user_id.charAt(i);
		}
		var sum = 0;
		for(var i = 0; i < strWord.length - 1; i++) {
			if(i == 0) {
				sum += parseInt(strWord.charAt(i)) * 1;
				continue;
			}
			sum += parseInt(strWord.charAt(i)) * (10 - i);
		}
		var checkNum = 10 - (sum % 10);
		
		if(checkNum == parseInt(strWord.charAt(10))) {
			alert("身份字號驗證正確");
			return 1;
		} else if(checkNum == 10) { 
			alert("身分字號驗證正確");
			return 1;
		} else {
			alert("身份字號驗證錯誤");
			return 0;
		} 
		
	}

</script>
</head>
<body>
 <form action="/member_system/app/controllers/MemberContollers.php" method="get" id="form" name="myform">
    <h3>歡迎<?php echo $user->name?>登入 使用者管理系統 </h3>
 	<input type="hidden" name="method" value="callFn">
 	帳號: <input type="text" name="account" id="account" ><br>
 	密碼: <input type="password" name="password" id="password" ><br>
 	再次輸入密碼: <input type="password" name="check_password" id="check_password" ><br>
 	名子: <input type="text" name="name" id="name" ><br>
 	身分字號:<input type="text" name="user_id" id="user_id" ><br>
 	手機號碼:<input type="text" name="phone_number" id="phone_number" ><br>
 	<button id="send">送出</button>
 	<input type="button" id="send2" value="查詢會員資料"/>
 </form>  	
 
 <br>
 
 <div id="users">
 	 
 </div> 
</body>
</html>