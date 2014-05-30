<?php

include_once("inc/HTMLTemplate.php");
include_once("inc/Connstring.php");

$tableGoods = "goods";
$tableOrderlist = "orderlist";
$tableCustomer = "customer";
$content= "<table id=\"ordertable\">";
$feedback = "";
  
if(!isset($_SESSION["admin"]))
{
    header("Location: login.php");
    exit();
}

if(isset($_POST['orderId'])&&isset($_POST['num'])&&isset($_POST['gId']))
{
    $orderId = $_POST['orderId'];
    $num = $_POST['num'];
    $gId = $_POST['gId'];
    
    $ordersql =<<<END
          DELETE FROM {$tableOrderlist} WHERE orderId={$orderId}
END;

    $mysqli->query($ordersql) or die("Could not query database" . $mysqli->errno . $mysqli->error);
    
    if($mysqli->affected_rows < 1){
        $feedback .= "订单删除错误！";
    } else{
        $feedback .= "订单已删除. ";
    }
    
    $gsql =<<<END
          UPDATE {$tableGoods} 
          SET soldnum = soldnum + {$num}
          WHERE gId={$gId}
END;
    
    $mysqli->query($gsql) or die("Could not query database" . $mysqli->errno . $mysqli->error);
    
    if($mysqli->affected_rows < 1){
        $feedback .= "物品数更新错误！";
    } else {
        $feedback .= "数据已更新. ";
    }
    
    $content .= $feedback;
}

    $sql=<<<END
    SELECT orderId,gId,cusId, msg, date, status
    FROM {$tableOrderlist}
    WHERE status=1
    ORDER BY date
END;

    $res = $mysqli->query($sql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
    while($row = $res->fetch_object())
    {   /*Query the goods info*/
        $gsql =<<<END
            SELECT gId, brand, description, pic, price, soldnum, total, category, note
            FROM {$tableGoods}
            WHERE gId="{$row->gId}"
END;
        $gres = $mysqli->query($gsql) or die("Can't Perform Query" . $mysqli->errno . " : " . $mysqli->error);
        $grow = $gres->fetch_object();
        
        /*Query the customer info*/
        $csql =<<<END
            SELECT cusId,cusName,cusDept,cusAddr,cusPhone,cusEmail
            FROM {$tableCustomer}
            WHERE cusId="{$row->cusId}"
END;
        $cres = $mysqli->query($csql) or die("Can't Perform Query". $mysqli->errno . " : " . $mysqli->error);
        $crow = $cres->fetch_object();
        
        /*Gather the info*/
        $orderId = $row->orderId;
        $status = $row->status;
        $gId = $row->gId;
        $msg  = utf8_decode(htmlspecialchars($row->msg));
        $date = $row->date;
        
        $cusId  = utf8_decode(htmlspecialchars($row->cusId));
        $cusName  = utf8_decode(htmlspecialchars($crow->cusName));
        $cusAddr  = utf8_decode(htmlspecialchars($crow->cusAddr));
        $cusPhone  = utf8_decode(htmlspecialchars($crow->cusPhone));
        $cusDept  = utf8_decode(htmlspecialchars($crow->cusDept));
        $cusEmail  = utf8_decode(htmlspecialchars($crow->cusEmail));
        
        $brand  = utf8_decode(htmlspecialchars($grow->brand));
        $desc  = utf8_decode(htmlspecialchars($grow->description));
        $category = utf8_decode(htmlspecialchars($grow->category));
        $note = utf8_decode(htmlspecialchars($grow->note));
        $pic = utf8_decode(htmlspecialchars($grow->pic));
        $price = $grow->price;
        $soldnum = $grow->soldnum;
        $total = $grow->total;
        $left = $total - $soldnum;
        
        $content .=<<<END
            <tr>
              <td id="d1">
                  <div id="thumbnail"><img src="upload/{$pic}" alt="photo" width="150" height="150"></div>
              </td>
              <td id="d2">
                  <p class="desc">
                    <strong>{$brand}</strong><br>{$desc}<br>价格: {$price}￥<br>
                    总数量: {$total} 存货量: {$left}<br> 备注：{$note}
                  </p>
              </td>
              <td id="d3">
                  <ul id="checkorder-list">
                      <li>学号/工号: </li>
                      <li>姓名: </li>
                      <li>学院/部门: </li>
                      <li>地址: </li>
                      <li>电话: </li>
                      <li>E-mail:</li>
                  </ul>
              </td>
              <td id="d4">
                  <ul id="checkorder-list">
                      <li>{$cusId} </li>
                      <li>{$cusName}</li>
                      <li>{$cusDept} </li>
                      <li>{$cusAddr}</li>
                      <li>{$cusPhone}</li>
                      <li>{$cusEmail}</li>
                  </ul>
              </td>
              <td id="d5">
                  <textarea name="msg" rows="5" maxlength="60" style="resize:none">{$msg}</textarea><br>
                  {$date}
              </td>
              <td>
                  <form action="checkorder.php?" method="POST">
                    <label for="num">数量：</label>
                    <input type="hidden" name="orderId" value="{$orderId}">
                    <input type="hidden" name="gId" value="{$gId}">
                    <input type="text" name="num" style="width:40px;" value="0"></input><br>
                    <input type="submit" value="完成结算">
                  </form>
              </td>
            </tr>
END;
    }
    $content .= "</table>";
    $mysqli->close();

echo $header;
echo $content;
echo $footer;
?>