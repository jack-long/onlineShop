<?php
/*-----------------------------------------
login.php
checks with the database 
if the user exists 
and if the password is correct
-----------------------------------------*/
include_once("inc/HTMLTemplate.php");

$username = "";
$password = "";
$feedback = "";

if(!empty($_POST)){
	include_once("inc/connstring.php");
	$table = 'account';
	$username = isset($_POST['username'])?$_POST['username']:'';
	$password = isset($_POST['password'])?$_POST['password']:'';

	if($username ==''||$password == ''){
		$feedback = "<p class=\"feedback-yellow\">�û��� �� ���� Ϊ�գ�</p>";
	} else {
	//--------------------------
	//Prevents SQL injections
	$username = $mysqli->real_escape_string($username);
	$password = $mysqli->real_escape_string($password);
	
  /*Check for Administor Account*/
  if($username == "admin" && $password == "admin") /*Here you can change the admin account*/
  {
      session_start();
			session_regenerate_id();
			$_SESSION["admin"] = $username;
      $_SESSION["username"] = $username;
      header("Location: index.php");
  }
	//---------------------------
	//SQL query
	$query = <<<END
	--
	-- Gets username and password based on user input
	--
	SELECT user, password
	FROM {$table}
	WHERE user = '{$username}';

END;
	
	$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . ":" . $mysqli->error);//Performs query
	
	if($res->num_rows == 1){
		$pswmd5 = md5($password);
		$row = $res->fetch_object();
		if($row->password == $pswmd5){
			
			session_start();
			session_regenerate_id();
			$_SESSION["username"] = $username;
      
      //$_SESSION["userId"] = $row->adminId;
			
			header("Location: index.php");
			
		}else{
			$feedback = "<p class=\"feedback-red\">�������</p>";
		}
		$res->close();
	}else{
		$feedback = "<p class=\"feedback-red\">�޴��û���</p>";
	}
	
	$mysqli->close();
	
	}
}

	$username = htmlspecialchars($username);
	$password = htmlspecialchars($password);

	$content = <<<END
					{$feedback}	
				<form action="login.php" method="post" id ="login-form">
					<input type="text" name="username" placeholder="�û���" value="{$username}" /><br>	
					<input type="password" name="password" placeholder="����" value=""/>
					<input type="hidden" id="address" name="address"/><br>
					<input type="submit" value="��¼" />
				</form>
        <a href="register.php"><button type="button">ע��</button></a>

END;

echo $header; 
echo $content; 
echo $footer;


?>