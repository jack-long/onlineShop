<?php
include_once("inc/HTMLTemplate.php");
include_once("inc/Connstring.php");

$content =<<<END

<div id="aboutus">
<h3>上海应用技术学院慈善爱心屋简介</h3>
<p>作为上海高校慈善工作站的一个重要运作机构，高校慈善爱心屋是社区慈善超市在高等院校的创新模式，已成为上海一个新的慈善品牌。
上海应用技术学院慈善爱心屋宣传慈善理念，传承中华美德，开展与创新多种形式的慈善活动，让学生懂感恩、会奉献，让慈善之花在大学校园中越开越灿烂。
上海应用技术学院慈善爱心屋位于奉贤校区大学生活动中心106室，屋内开架陈列助困物资，便于受助学生自主选取。</p>
<ul>
<li>慈善爱心屋以实物救助为主要内容开展对贫困学生的助学帮困，开架成列助困物资，便于受助学生自主选取。</li>
<li>慈善爱心屋是经常性社会捐助接收点，所接收物资是慈善爱心屋实施帮困的主要物资来源。</li>
<li>慈善爱心屋接收企事业单位定向捐助的新品物资，通过所属区的慈善基金会价格评估后可向企事业单位开具《上海市接收公益性救济性捐赠专用票据》。</li>
<li>慈善爱心屋可多方募集慈善资金，向市场采购助困必需的生活用品和学习用品。</li>
</ul>
<p><strong>联系方式：</strong><br>
徐汇校区：学生资助管理中心（19号楼117室）       64941169 <br>
奉贤校区：慈善爱心屋（大学生活动中心106室）      60873023<br>
</p>
<p><strong>联系人：</strong>袁凌杰老师  13816062804
</p>
</div>
<table id="pics"><tr>
<td><div class="aboutimg">
<img src="img/about001.jpg" alt="photo" width="200" height="200">
</div>
</td>
<td><div class="aboutimg">
<img src="img/about002.jpg" alt="photo" width="200" height="200">
</div></td>
<td><div class="aboutimg">
<img src="img/about003.jpg" alt="photo" width="200" height="200">
</div></td>
<td><div class="aboutimg">
<img src="img/about004.jpg" alt="photo" width="215" height="200">
</div></td>
</tr></table>
END;


echo $header;
echo $content;
echo $footer;
?>