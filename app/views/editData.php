 
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>修改網頁</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<?php 
$member = $_REQUEST['member'][0];
//$membertext = json_encode($_REQUEST['member']); //轉成json物件
//$dataArr = json_decode($membertext, true);//轉成php物件或是陣列

$id = $member->id;
$account = $member->account; 
$password = $member->password;
$name = $member->name;
$user_id = $member->user_id;
$phone_number = $member->phone_number;
?>
<script>

$(function(){
	//alert("onload function")

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
		var pwdCheck = equals(password, check_password);
		if(pwdCheck) {
			alert("兩次輸入密碼不相等");
			$("#password").focus();
			$("#password").val("");
			$("#check_password").val("");
			return false;
		}

		if(!$("#user_id").val()) {
			alert("請輸入身分字號!");
			$("#user_id").focus();
			return false;
		}
		var flag = check_user_id($("#user_id").val()); 
		if(flag && pwdCheck) {
			return true;
			
		} else if(pwdCheck == false) {
			alert("請檢查輸入密碼是否一致");
		} else if(flag) {
			alert("請檢查身份字號是否輸入正確")
		} else {
			$("#user_id").val("");
			$("#user_id").focus();
			return false;
		} 	
		
	});
});

function check_user_id(user_id) {
	user_id = user_id.toUpperCase();
	
	var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var num = new Array(10, 11, 12, 13, 14, 15, 16, 17, 34, 18, 19, 20, 21, 22, 35, 23, 24, 25, 26, 27, 28, 29, 32, 30, 31, 33);
	if(user_id.length == 0) {
		alert("請填寫身份字號");
		return false;
	}
	if(user_id.length > 10 && user_id.length <10) {
		alert("身份字號只有10碼");
		return false;
	}
	var firstWordIndex = tab.indexOf(user_id.charAt(0));
	if(firstWordIndex == -1) {
		alert("身份字號第一碼為大寫英文字母");
		return false;
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
		return true;
	} else if(checkNum == 10) { 
		alert("身分字號驗證正確");
		return true;
	} else {
		alert("身份字號驗證錯誤");
		return false;
	} 
	
}
function equals(str1, str2) {    
    if(str1 == str2)    
    {    
        return true;    
    }    
    return false;    
}  


</script>
</head>
<body>
	<form action="/member_system/app/controllers/MemberContollers.php" method="get" id="form3">
		<input type="hidden" name="method" value="update">
		<input type="hidden" name="method2" value="get">
		取得的ID值: <input type="text" name="id" id="id" value=<?php echo $id; ?>><br>
 		帳號: <input type="text" name="account" id="account" value=<?php echo $account; ?>><br>
 		密碼: <input type="password" name="password" id="password" value=<?php echo $password; ?>><br>
 		再次輸入密碼: <input type="password" name="check_password" id="check_password" ><br>
 		名子: <input type="text" name="name" id="name" value=<?php echo $name; ?>><br>
 		身份字號:<input type="text" name="user_id" id="user_id" value=<?php echo $user_id;?>><br>
 		手機號碼:<input type="text" name="phone_number" id="phone_number" value=<?php echo $phone_number;?>><br>
 		<input type="submit" name="send" id="send" value="修改完成">
	</form>
	
</body>
</html>