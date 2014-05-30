<?php
include_once("inc/HTMLTemplate.php");
include_once("inc/Connstring.php");

$content = "";

$tableGoods = "goods";

/*---------------- The Left List -------------------*/
$query = "SELECT DISTINCT category FROM {$tableGoods}";
if($mysqli->query($query) != NULL)
{
    $content .=<<<END
      <ul class="nav leftlist">
        <li><a href='index.php?'>全部物品</a></li>
END;
    $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . ":" . $mysqli->error);
    while($row = $res->fetch_object()){
        $category  = utf8_decode(htmlspecialchars($row->category));
        $content .= "<li class=\"\"><a href='index.php?c={$row->category}'>{$category}</a></li>";
    }
    $content .= "</ul>";
}

/*----------------Start: The Goods Table -----------------*/
$c = isset($_GET['c']) ? $_GET['c'] : '';
if($c == '')
{
    $query = <<<END
    SELECT gId, brand, description, pic, price, soldnum, total, category
    FROM {$tableGoods}
    ORDER BY category
END;
}
else
{
    $query = <<<END
    SELECT gId, brand, description, pic, price, soldnum, total, category
    FROM {$tableGoods}
    WHERE category="{$c}"
END;
}

if($mysqli->query($query) == NULL){   /*?? die() ??*/
    $content = <<<END
      <div>
        <p>There is nothing inside!</p>
      <div>
END;
} else {
    $content .="<table>";
    
    $res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . ":" . $mysqli->error);
    
    $count = 0;
    
    while($row = $res->fetch_object()){
        $brand  = utf8_decode(htmlspecialchars($row->brand));
        $desc  = utf8_decode(htmlspecialchars($row->description));
        $category = utf8_decode(htmlspecialchars($row->category));
        $pic = utf8_decode(htmlspecialchars($row->pic));
        $price = $row->price;
        $soldnum = $row->soldnum;
        $total = $row->total;
        $left = $total - $soldnum;
        
        $adminRow = "";
        if(isset($_SESSION["admin"])){
            $adminRow = <<<END
            <p><a href="edit.php?gId={$row->gId}"><button type="button">修改</button></a>
             <a href="delete.php?gId={$row->gId}"><button type="button">删除</button></a></p>
END;
        }
        
        if($count%5 == 0)
            $content .= "<tr>";
        
        $count ++;
        $content .= <<<END
          <td class="item">
            <fieldset>
            <div class="picture">
              <a href="order.php?gId={$row->gId}"><img src="upload/{$pic}" alt="photo" width="100" height="100"></a>
            </div>
            <p class="desc">
                <strong>{$brand}</strong> {$desc}<br>
                {$price}￥,剩余{$left},已售{$soldnum}<br>
            </p>
            </fieldset>
            <!--<p>分类：{$category}</p>-->
            {$adminRow}
          </td>
END;
               
        if($count%5 == 0)
        { 
            $content .= "</tr>";
            $count = 0;
        }
    }
    
    if($count != 0)
        $content .= "</tr>";
    
    $content .=<<<END
        </table>
END;
/*----------------END: The Goods Table -----------------*/
}
  
echo $header;
echo $content;
echo $footer;
?>