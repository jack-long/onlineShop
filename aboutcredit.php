<?php
include_once("inc/HTMLTemplate.php");
include_once("inc/Connstring.php");

$content =<<<END
<div id="aboutcredit">
<h3>爱心积分制度简介</h3>
<p>上海应用技术学院爱心积分制度是为了更好的帮助家庭经济困难学生（以下简称“困难生”），实现资助育人的一项制度。
困难生可以通过获得校内外各类奖励、参加各类公益活动或其他本制度内列出的途径获得爱心积分，
并可前往慈善爱心屋使用爱心积分兑换自己所需生活、学习物品或获得其它资助。
爱心积分的实施既可以减轻困难生的经济压力，贯彻执行学校有关的帮困政策；
又将学生的学习和实践相结合，能够在校园内营造良好的学习生活和帮困氛围，达到资助育人的目的。
</p>
<h3>爱心积分使用规则</h3>
<h4>一、积分录入</h4>
<ul>
<li>国家奖学金、上海市奖学金、优秀奖学金、资助类活动获奖、义务献血等数据由学生资助管理中心统计转换后直接导入对应同学的爱心积分账户；</li>
<li>获得学习进步奖的同学可凭辅导员开出的证明前往慈善爱心屋办理爱心积分录入手续；</li>
<li>获得各类其他奖项（在可获爱心奖励积分奖项范围内）的同学，可凭获奖证书等前往慈善爱心屋办理爱心积分录入手续；</li>
<li>参加各类公益活动的同学，将由活动主办方（学生资助管理中心、校慈善义工队或二级学院慈善义工分队）负责统计应得爱心积分，
交由校慈善义工队爱心积分管理处核实并录入；</li>
<li>学生如发表文章或经查发现本人有爱心积分被漏登记，可带好相关证明、获奖材料原件及复印件等至慈善爱心屋办理登记爱心积分录入。
每月月底会公示爱心积分情况。</li>
</ul>
<h4>二、积分抵扣</h4>
<p>为了树立学生自立、自强、自信的信念，鼓励经济困难学生积极参加校内外各类学习、科创竞赛和公益活动，学校规定每学年获得校级及以上资助项目
（包括国家励志奖学金、校励志奖学金、国家助学金、詹守成奖学金、学校学费减免、各级慈善基金会及社会、个人捐助等项目）
的大二、大三年级家庭经济困难同学，该学年必须至少完成150点爱心积分（每学年结束前学生资助管理中心会在获资助项目的学
生个人爱心积分账户里扣除150点爱心积分，此部分积分不可兑换慈善爱心屋内物品），账户内没被扣满150点爱心积分的学生，
原则上将不能申请下一学年校级及以上资助项目。每年4月份对于爱心积分账户当学年新增积分少于150点的同学，会由学生资助管理中心给其发出预警通知。
</p>
<h4>三、积分兑换</h4>
<p>学生可凭爱心积分在慈善爱心屋（奉贤校区大学生活动中心106）兑换物品。在慈善爱心屋内，一点爱心积分相当于一元人民币。</p>
<p>爱心积分不可兑换现金，积分换购产品无质量问题一般不退不换，学生换购物品确认后会从个人爱心账户扣除相应积分。
积分可保留至学生毕业离校前，学生毕业后积分账户将自动清零。<p>
<h3>注意事项</h3>
<p>本制度自二O一二年九月一日起实施，解释权归上海应用技术学院学生工作部（处），管理部门为校学生资助管理中心。<p>

<h5>上海应用技术学院学生工作部（处）<h5>
<h5>二O一二年二月<h5>

</div>
END;

echo $header;
echo $content;
echo $footer;

?>