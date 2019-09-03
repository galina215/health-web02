<fieldset>
  <?php
  $subject=find("que",$_GET['id']);
  $total=$subject['count'];
  ?>
<legend>目前位置:首頁>問卷調查> <?=$subject['text'];?></legend>
<h3><?=$subject['text'];?></h3>
<ul id="list">
  <?php
    $options=all("que",["parent"=>$_GET['id']]);
    foreach($options as $key=> $opt){
      $rate=round($opt['count']/$total,2);
    
  ?>
  <li>
    <div><?=($key+1).".".$opt['text'];?></div>
    <div style='background:#ddd;width:<?=$rate*40;?>%;height:20px'></div>
    <div><?=$opt['count'];?>票<?=$rate*100;?>(%)</div>
  </li>

<?php
  }
?>
</ul>
<div class="ct"><button onclick="javascript:lof('?do=que')">返回</button></div>
</fieldset>