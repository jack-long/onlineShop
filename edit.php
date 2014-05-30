<?php

include_once("inc/HTMLTemplate.php");
include_once("inc/Connstring.php");

if(!isset($_SESSION["admin"])){
    header("Location: index.php");
    exit();
}

$tableGoods = "goods";

$gId = isset($_GET['gId']) ? $_GET['gId'] : '';
if($gId == '')
{
    header("Location: index.php");
    exit();
}

if(!empty($_POST))
{  
  $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
  $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
  $price = isset($_POST['price']) ? $_POST['price'] : '';
  $left = isset($_POST['left']) ? $_POST['left'] : '';
  $total  = isset($_POST['total']) ? $_POST['total'] : '';
  $category = isset($_POST['category']) ? $_POST['category'] : '';
  $note = isset($_POST['note']) ? $_POST['note'] : '';
  $pic = isset($_FILES["Picture"]["name"]) ? $_FILES["Picture"]["name"] : '';
  
  $brand = utf8_encode($mysqli->real_escape_string($brand));
  $desc = utf8_encode($mysqli->real_escape_string($desc));
  $category = utf8_encode($mysqli->real_escape_string($category));
  $note = utf8_encode($mysqli->real_escape_string($note));
  $soldnum = $total - $left;
 
  /*Process the Picture*/
  if($pic != '')
  {
      $pic = utf8_encode($mysqli->real_escape_string($pic));
      $allowedExts = array("gif", "jpeg", "jpg");
      $temp = explode(".", $_FILES["Picture"]["name"]);
      $extension = end($temp);
      if ((($_FILES["Picture"]["type"] == "image/gif")
          || ($_FILES["Picture"]["type"] == "image/jpeg")
          || ($_FILES["Picture"]["type"] == "image/jpg"))
          && ($_FILES["Picture"]["size"] < 102400)
          && in_array($extension, $allowedExts))
      {
          if ($_FILES["Picture"]["error"] > 0)
          {
            echo "Error: " . $_FILES["Picture"]["error"] . "<br>";
          }
          else
          {
              $testInfo =<<<END
              Upload: {$_FILES["Picture"]["name"]}<br>
              Type: {$_FILES["Picture"]["type"]}<br>
              Size: {{$_FILES["Picture"]["size"]}/1024}kB<br>
              Stored in: {$_FILES["Picture"]["tmp_name"]}<br>
END;
              
              if (file_exists("upload/" . $_FILES["Picture"]["name"]))
              {
                die($_FILES["Picture"]["name"] . " already exists. ");
              }
              else
              {
                  move_uploaded_file($_FILES["Picture"]["tmp_name"], "upload/" . $_FILES["Picture"]["name"]);
                  $sql = "UPDATE {$tableGoods} SET pic='{$pic}' WHERE gId={$gId}";
                  $mysqli->query($sql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
              }
          }
      }
      else
      {
        die("Invalid Picture. gif, jpeg or jpg only, less than 100Kb");
      }
  }
  /*-- END -- Process the Picture*/
  
  $sql =<<<END
      UPDATE {$tableGoods} 
      SET brand = '{$brand}', description = '{$desc}', price = '{$price}',
      soldnum = '{$soldnum}', total = '{$total}', category = '{$category}'
      WHERE gId = {$gId};
END;
  $mysqli->query($sql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
  
  //echo "修改成功";
  header("Location: index.php?{$gId}=y");
}
else
{
    $query = <<<END
      SELECT gId, brand, description, pic, price, soldnum, total, category, note
      FROM {$tableGoods}
      WHERE gId="{$gId}";
END;
    
    $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . ":" . $mysqli->error);
    $row = $res->fetch_object();
    
    $brand  = utf8_decode(htmlspecialchars($row->brand));
    $desc  = utf8_decode(htmlspecialchars($row->description));
    $category = utf8_decode(htmlspecialchars($row->category));
    $note = utf8_decode(htmlspecialchars($row->note));
    $pic = utf8_decode(htmlspecialchars($row->pic));
    $price = $row->price;
    $soldnum = $row->soldnum;
    $total = $row->total;
    $left = $total - $soldnum;

    $content =<<<END
    <img src="upload/{$pic}" alt="photo" width="150" height="150">
    <form enctype="multipart/form-data" action="edit.php?gId={$gId}" method="post">
        名称: <input type="text" id="name" name="brand" value="{$brand}" maxlength="10" /><br>
        描述: <textarea name="desc" maxlength="30" style="resize:none">{$desc}</textarea><br>
        价格: <input type="text" id="price" name="price" value="{$price}" /><br>
        分类: <input type="text" id="category" name="category" value="{$category}" maxlength="4" /><br>
        总数量: <input type="text" id="total" name="total" value="{$total}" /><br>
        存货量: <input type="text" id="left" name="left" value="{$left}" /><br>
        备注: <textarea name="note" maxlength="50" style="resize:none">{$note}</textarea><br>
        照片: <input type="file" id="Picture" name="Picture">
        <input type="hidden" id="address" name="address"/><br>
        <input type="submit" value="提交">
        <a href="index.php"><button type="button">返回</button></a>
        <p>照片要求："jpeg", "jpg" 或 "gif",格式，不大于100KB</p>
    </form>
END;

  echo $header;
  echo $content;
  echo $footer;
}

?>