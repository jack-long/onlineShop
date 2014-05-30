<?php
session_start();

$current_page =  basename($_SERVER["PHP_SELF"], ".php");

$adminHTML = "";
$adminDel = "";
$adminModify = "";

if(isset($_SESSION['username'])){
    if(isset($_SESSION['admin'])){
        $adminHTML .= <<<END
        <li><a href="add.php">�����Ʒ</a></li>
        <li><a href="checkorder.php">��ѯ����</a></li>
END;
    }
    $adminHTML .= <<<END
    <li><a href="logout.php?cp={$current_page}">{$_SESSION["username"]}���˳�</a></li>
END;
} else{
    $adminHTML = <<<END
    <li><a href="login.php?cp={$current_page}">�û���¼</a></li>
END;
}

$header =<<<END
  <!DOCTYPE html>
  <html>
  <head>
    <title>���ư�����</title>
    <meta http-equiv="Content-Type" content="text/html" charset="gb2312">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/cssmall.css" rel="stylesheet">
  </head>
  <body>
  <div id="wrapper">
    <div id="header">      
      <h1>���ư�����</h1>
       
    <ul class="nav nav-tabs uplist">
        <li><a href="index.php">��ҳ</a></li>
        <li><a href="aboutus.php">���ڰ�����</a></li>
        <li><a href="aboutcredit.php">���ڰ��Ļ���</a></li>
        {$adminHTML}
    </ul>
    </div>

  <div id="content">
END;

$footer =<<<END
  </div><!--content-->
  
  <div id="footer">
    <h4>��ַ���Ϻ�Ӧ�ü���ѧԺ ��ѧ�������106��</h4>
    <p>Copyright by TianlongDu. All Rights Reserved. E-mail: du_tianlong@hotmail.com</p>
  </div>
  </div><!--wrapper-->
  </body>
</html>
END;

?>