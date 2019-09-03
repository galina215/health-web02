<fieldset>
  <?php
  $subject=find("que",$_GET['id']);
  ?>
<legend>目前位置:首頁>問卷調查> <?=$subject['text'];?></legend>
<h3><?=$subject['text'];?></h3>
<form action="api.php?do=vote" method="post">
  <ul style="list-style-type:none;padding:0;margin:0">
  <?php
  $options=all("que",['parent'=>$_GET['id']]);

  foreach($options as $opt){
  ?>
    <li style="margin:10px 0">
      <input type="radio" name="opt" value="<?=$opt['id'];?>">
      <?=$opt['text'];?>
    </li>
    <?php
      }
    ?>
  </ul>
  <div><input type="submit" value="我要投票"></div>
</form>
</fieldset>