<?php
session_start();

$current_page =  basename($_SERVER["PHP_SELF"], ".php");

$adminHTML = "";
$adminDel = "";
$adminModify = "";

if(isset($_SESSION['username'])){
    if(isset($_SESSION['admin'])){
        $adminHTML .= <<<END
        <li><a href="add.php">添加物品</a></li>
        <li><a href="checkorder.php">查询订单</a></li>
END;
    }
    $adminHTML .= <<<END
    <li><a href="logout.php?cp={$current_page}">{$_SESSION["username"]}，退出</a></li>
END;
} else{
    $adminHTML = <<<END
    <li><a href="login.php?cp={$current_page}">用户登录</a></li>
END;
}

$header =<<<END
  <!DOCTYPE html>
  <html>
  <head>
    <title>慈善爱心屋</title>
    <meta http-equiv="Content-Type" content="text/html" charset="gb2312">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/cssmall.css" rel="stylesheet">
  </head>
  <body>
  <div id="wrapper">
    <div id="header">      
      <h1>慈善爱心屋</h1>
       
    <ul class="nav nav-tabs uplist">
        <li><a href="index.php">首页</a></li>
        <li><a href="aboutus.php">关于爱心屋</a></li>
        <li><a href="aboutcredit.php">关于爱心积分</a></li>
        {$adminHTML}
    </ul>
    </div>

  <div id="content">
END;

$footer =<<<END
  </div><!--content-->
  
  <div id="footer">
    <h4>地址：上海应用技术学院 大学生活动中心106室</h4>
    <p>Copyright by TianlongDu. All Rights Reserved. E-mail: du_tianlong@hotmail.com</p>
  </div>
  </div><!--wrapper-->
  </body>
</html>
END;

?>