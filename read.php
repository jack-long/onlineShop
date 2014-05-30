<?php
  header("content-type: image/gif");
  $host="localhost";
  $username="root";
  $password="";
  $db="store";
  
  mysql_connect($host,$username,$password) or die("Unable to connect to SQL server");
  @mysql_select_db($db) or die("Unable to select database");
  $result=mysql_query("SELECT * FROM store Where id=0") or die("Can't Perform Query");
  $data = @ MYSQL_RESULT($result, 0, "photo");
  echo $data;

?>