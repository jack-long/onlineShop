<?php
include_once("inc/HTMLTemplate.php");
include_once("inc/Connstring.php");

$content =<<<END

<div id="aboutus">
<h3>�Ϻ�Ӧ�ü���ѧԺ���ư����ݼ��</h3>
<p>��Ϊ�Ϻ���У���ƹ���վ��һ����Ҫ������������У���ư��������������Ƴ����ڸߵ�ԺУ�Ĵ���ģʽ���ѳ�Ϊ�Ϻ�һ���µĴ���Ʒ�ơ�
�Ϻ�Ӧ�ü���ѧԺ���ư���������������������л����£���չ�봴�¶�����ʽ�Ĵ��ƻ����ѧ�����ж�������ף��ô���֮���ڴ�ѧУ԰��Խ��Խ���á�
�Ϻ�Ӧ�ü���ѧԺ���ư�����λ�ڷ���У����ѧ�������106�ң����ڿ��ܳ����������ʣ���������ѧ������ѡȡ��</p>
<ul>
<li>���ư�������ʵ�����Ϊ��Ҫ���ݿ�չ��ƶ��ѧ������ѧ���������ܳ����������ʣ���������ѧ������ѡȡ��</li>
<li>���ư������Ǿ��������������յ㣬�����������Ǵ��ư�����ʵʩ��������Ҫ������Դ��</li>
<li>���ư����ݽ�������ҵ��λ�����������Ʒ���ʣ�ͨ���������Ĵ��ƻ����۸��������������ҵ��λ���ߡ��Ϻ��н��չ����Ծȼ��Ծ���ר��Ʊ�ݡ���</li>
<li>���ư����ݿɶ෽ļ�������ʽ����г��ɹ����������������Ʒ��ѧϰ��Ʒ��</li>
</ul>
<p><strong>��ϵ��ʽ��</strong><br>
���У����ѧ�������������ģ�19��¥117�ң�       64941169 <br>
����У�������ư����ݣ���ѧ�������106�ң�      60873023<br>
</p>
<p><strong>��ϵ�ˣ�</strong>Ԭ�����ʦ  13816062804
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