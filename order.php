<?php
  include_once("inc/HTMLTemplate.php");
  include_once("inc/Connstring.php");
    
  /*First: Check the "gId" variable*/
  if(!isset($_GET['gId']))
  {
      header("Location: index.php");
      exit();
  }
  $gId = $_GET['gId'];
  $tableGoods = "goods";
  $tableOrderlist = "orderlist";
  $tableCustomer = "customer";

  /*Show the information*/
  $query =<<<END
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
    <table id="box">
        <tr>
          <td>
              <div id="box-pic"><img src="upload/{$pic}" alt="photo" width="150" height="150"></div>
          </td>
          <td>
              <p id="box-text">
                <strong>{$brand}</strong><br>{$desc}<br>�۸�: {$price}��<br>
                ����: {$category}<br>������: {$total} �����: {$left}<br> ��ע��{$note}
              </p>
          </td>
        </tr>
    </table>
END;

/*Second: Check the $_POST[]*/
if(!empty($_POST))  
{
    if(!isset($_SESSION["username"]))
    {
        header("Location: login.php");
        exit();
    }
    
    /*--- Store the information into the DB ---*/
    $msg  = isset($_POST['msg']) ? $_POST['msg'] : '';
    $spam = isset($_POST['spam']) ? $_POST['spam'] : '';
    if($spam != '')
    {
        die("Are You a Robot? Please Try Again.");
    }
    if($msg == '')
    {
        $feedback =<<<END
        <h2>����дԤ����Ϣ��</h2>
        <a href="order.php?gId={$gId}"><button type="button">����</button></a>
END;
        $content .= $feedback;
    }
    else
    {
        $cusId = utf8_encode($mysqli->real_escape_string($_SESSION["username"]));
        $msg = utf8_encode($mysqli->real_escape_string($msg));
        
        $sql =<<<END
        INSERT INTO {$tableOrderlist} (cusId, gId, msg)
        VALUES ('{$cusId}', '{$gId}', '{$msg}')
END;
        $mysqli->query($sql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
        $feedback = "<h2>Ԥ���ɹ���</h2>";
        $content .= $feedback; 
    }
}
else                
{   
    /*Check if the user is admin or not, the contents are different*/
    if(!isset($_SESSION["admin"]))
    {
        /*Show the visitor the Form*/
        $content .=<<<END
        <form action="order.php?gId={$gId}" method="post">
          <textarea name="msg" maxlength="60" rows="5" style="resize:none;" placeholder="���ڴ���дԤ����Ϣ"></textarea>
          <input type="hidden" name="spam"></input><br>
          <input type="submit" value="Ԥ����Ʒ" style="margin: 20px;">
          <p>��ܰ��ʾ����¼�����Ԥ��</p>
        </form>
END;
    }
    else
    {
        $sql=<<<END
        SELECT gId, cusId, msg, date
        FROM {$tableOrderlist}
        WHERE gId={$gId}
        ORDER BY date
END;
        $res = $mysqli->query($sql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
        while($row = $res->fetch_object())
        { 
            $subsql =<<<END
            SELECT * FROM {$tableCustomer} WHERE cusId="{$row->cusId}"
END;
            $subres = $mysqli->query($subsql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
            $subrow = $subres->fetch_object();
            
            $cusId  = utf8_decode(htmlspecialchars($row->cusId));
            $msg  = utf8_decode(htmlspecialchars($row->msg));
            $date = $row->date;
            
            $cusName  = utf8_decode(htmlspecialchars($subrow->cusName));
            $cusDept  = utf8_decode(htmlspecialchars($subrow->cusDept));
            $cusAddr  = utf8_decode(htmlspecialchars($subrow->cusAddr));
            $cusPhone  = utf8_decode(htmlspecialchars($subrow->cusPhone));
            $cusEmail  = utf8_decode(htmlspecialchars($subrow->cusEmail));
            
            $content .=<<<END
            <div  >
              <table class="orderlist">
                <tr>
                  <td class="table-left">ѧ��/����: </td>
                  <td class="table-right">{$cusId}</td>
                </tr>
                <tr>
                  <td class="table-left">����: </td>
                  <td class="table-right">{$cusName}</td>
                </tr>
                <tr>
                  <td class="table-left">ѧԺ/����: </td>
                  <td class="table-right">{$cusDept}</td>
                </tr>
                <tr>
                  <td class="table-left">��ַ: </td>
                  <td class="table-right">{$cusAddr}</td>
                </tr>
                <tr>
                  <td class="table-left">�绰: </td>
                  <td class="table-right">{$cusPhone}</td>
                </tr>
                <tr>
                  <td class="table-left">����: </td>
                  <td class="table-right"><textarea name="msg" rows="5" maxlength="60" style="resize:none">{$msg}</textarea></td>
                </tr>
                <tr>
                  <td class="table-left">ʱ��: </td>
                  <td class="table-right">{$date}</td>
                </tr>
              </table>
              <hr>
            </div>
END;
        }
    }

}
echo $header;
echo $content;
echo $footer;

?>