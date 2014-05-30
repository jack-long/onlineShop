<?php
include_once("inc/HTMLTemplate.php");
include_once("inc/Connstring.php");

$tableAccount = "account";
$tableCustomer = "customer";

$cusId = '';
$cusName = '';
$cusDept = '';
$cusPhone = '';
$cusAddr = '';
$cusEmail = '';
$feedback = '';

if(!empty($_POST))
{
    $cusId = isset($_POST['cusId']) ? $_POST['cusId'] : '';
    $cusName = isset($_POST['cusName']) ? $_POST['cusName'] : '';
    $cusDept = isset($_POST['cusDept']) ? $_POST['cusDept'] : '';
    $cusPhone = isset($_POST['cusPhone']) ? $_POST['cusPhone'] : '';
    $cusAddr = isset($_POST['cusAddr']) ? $_POST['cusAddr'] : '';
    $cusEmail = isset($_POST['cusEmail']) ? $_POST['cusEmail'] : '';
    $pw1 = isset($_POST['pw1']) ? $_POST['pw1'] : '';
    $pw2 = isset($_POST['pw2']) ? $_POST['pw2'] : '';
    $spam = isset($_POST['spam']) ? $_POST['spam'] : '';
    
    if($spam != ''){
        echo $spam;
        $_POST = array();
        die("Are You a Robot? Try Again!");
    }
    
    if($cusId==''||$cusName==''||$cusDept==''||$cusPhone==''||$cusAddr==''||$cusEmail==''||$pw1==''||$pw2==''){
        $feedback = "<h3>请填写每一栏！</h3>";
    } else {
        if($pw1 != $pw2){
            $feedback = "<h3>两次密码不同！</h3>";
        }else{
            $cusId = utf8_encode($mysqli->real_escape_string($cusId));
            $sql =<<<END
            SELECT cusId FROM {$tableCustomer} WHERE cusId="{$cusId}"
END;
            $res = $mysqli->query($sql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
            if($res->fetch_object() != NULL){
                $feedback = "<h3>用户名已存在！</h3>";
            }else{
                $cusName = utf8_encode($mysqli->real_escape_string($cusName));
                $cusDept = utf8_encode($mysqli->real_escape_string($cusDept));
                $cusPhone = utf8_encode($mysqli->real_escape_string($cusPhone));
                $cusAddr = utf8_encode($mysqli->real_escape_string($cusAddr));
                $cusEmail = utf8_encode($mysqli->real_escape_string($cusEmail));
                $pw1 = utf8_encode($mysqli->real_escape_string($pw1));
                $password = md5($pw1);
                
                $sql =<<<END
                INSERT INTO {$tableCustomer} (cusId, cusName, cusDept, cusPhone, cusAddr, cusEmail)
                VALUES ("{$cusId}", "{$cusName}", "{$cusDept}", "{$cusPhone}", "{$cusAddr}", "$cusEmail")
END;
                $mysqli->query($sql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
                
                $sql =<<<END
                INSERT INTO {$tableAccount} (user, password)
                VALUES ("{$cusId}", "{$password}")
END;
                $mysqli->query($sql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
                
                header("Location: index.php");
                exit();
            }
        }
    }
}

  $content =<<<END
    {$feedback}
    <div style="margin:auto;">
    <form action="register.php" method="post">
      <input type="text" name="cusId" placeholder="学号(工号)" maxlength="10" value="{$cusId}"></input><br>
      <input type="text" name="cusName" placeholder="姓名" maxlength="10" value="{$cusName}"></input><br>
      <input type="text" name="cusDept" placeholder="院系(部门)" maxlength="5" value="{$cusDept}"></input><br>
      <input type="text" name="cusPhone" placeholder="电话" maxlength="11" value="{$cusPhone}"></input><br>
      <input type="text" name="cusAddr" placeholder="地址" maxlength="20" value="{$cusAddr}"></input><br>
      <input type="text" name="cusEmail" placeholder="E-mail" maxlength="30" value="{$cusEmail}"></input><br>
      <input type="password" name="pw1" placeholder="密码" maxlength="20"></input><br>
      <input type="password" name="pw2" placeholder="核对密码" maxlength="20"></input>
      <input type="hidden" name="spam"></input><br>
      <input type="submit" value="注册">
    </form>
    <div>
END;

echo $header;
echo $content;
echo $footer;
?>