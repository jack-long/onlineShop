<?php
include_once("inc/HTMLtemplate.php");

if(!isset($_SESSION["admin"])){
    header("Location: index.php");
    exit();
}

$content = "";
$feedback = "";
$brand = "";
$desc = "";
$price = "";
$total = "";
$category ="";
$note = "";

if(!empty($_POST))
{
  include_once("inc/connstring.php");
  
  $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
  $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
  $price = isset($_POST['price']) ? $_POST['price'] : '';
  $total  = isset($_POST['total']) ? $_POST['total'] : '';
  $category = isset($_POST['category']) ? $_POST['category'] : '';
  $note = isset($_POST['note']) ? $_POST['note'] : '';
  
  $brand = utf8_encode($mysqli->real_escape_string($brand));
  $desc = utf8_encode($mysqli->real_escape_string($desc));
  $category = utf8_encode($mysqli->real_escape_string($category));
  $note = utf8_encode($mysqli->real_escape_string($note));
  $pic = utf8_encode($mysqli->real_escape_string($_FILES["Picture"]["name"]));
  
  /*Process the Picture*/
  $allowedExts = array("gif", "jpeg", "jpg");
  $temp = explode(".", $_FILES["Picture"]["name"]);
  $extension = end($temp);
  if ((($_FILES["Picture"]["type"] == "image/gif")
  || ($_FILES["Picture"]["type"] == "image/jpeg")
  || ($_FILES["Picture"]["type"] == "image/jpg"))
  && ($_FILES["Picture"]["size"] < 102400)  /*Here to Change the Picture Max-Size*/
  && in_array($extension, $allowedExts))
  {
      if ($_FILES["Picture"]["error"] > 0)
      {
        echo "Error: " . $_FILES["Picture"]["error"] . "<br>";
      }
      else
      {
          /*----- Show the file information -----*/
          $testInfo =<<<END
          Upload: {$_FILES["Picture"]["name"]}<br>
          Type: {$_FILES["Picture"]["type"]}<br>
          Size: {{$_FILES["Picture"]["size"]}/1024}kB<br>
          Stored in: {$_FILES["Picture"]["tmp_name"]}<br>
END;
          
          if (file_exists("upload/" . $_FILES["Picture"]["name"]))
          {
            // Maybe to do something: alert($_FILES["Picture"]["name"] . " already exists. ");
          }
          else
          {
              move_uploaded_file($_FILES["Picture"]["tmp_name"], "upload/" . $_FILES["Picture"]["name"]);
          }
      }
  }
  else
  {
    die("Invalid Picture. gif, jpeg or jpg only, less than 100Kb");
  }
  /*-- END -- Process the Picture*/
  
  $sql =<<<END
  INSERT INTO goods (brand, description, pic, price, soldnum, total, category)
  VALUES ('{$brand}', '{$desc}', '{$pic}', '{$price}', '0', '{$total}', '{$category}');
END;
  $mysqli->query($sql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
  $mysqli->close();
  $feedback ="添加成功!";
  
  /*just to empty the values*/
  $brand = "";
  $desc = "";
  $price = "";
  $total = "";
  $category ="";
  $note = "";
}

/*------- Show the Upload Form -------*/
  $content .= $feedback;
  $content .=<<<END
  <form class="form" enctype="multipart/form-data" action="add.php" method="post">
      名称: <input type="text" id="name" name="brand" value="{$brand}" maxlength="10"/><br>
      描述: <textarea name="desc" maxlength="30" style="resize:none">{$desc}</textarea><br>
      价格: <input type="text" id="price" name="price" value="{$price}" /><br>
      分类: <input type="text" id="category" name="category" value="{$category}" maxlength="4"/><br>
      数量: <input type="text" id="total" name="total" value="{$total}" /><br>
      备注: <textarea name="note" maxlength="50" style="resize:none">{$note}</textarea><br>
      照片: <input type="file" id="Picture" name="Picture">
      <input type="hidden" id="address" name="address" /><br>
      <input type="submit" value="添加">
  </form>
  <p>照片要求："jpeg", "jpg" 或 "gif",格式，不大于100KB</p>
END;

echo $header;
echo $content;
echo $footer;

?>