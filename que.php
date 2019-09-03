<fieldset>
<legend>目前位置:首頁>問卷調查</legend>
<table style="width:90%">
  <tr class="ct">
    <td width="10%">編號</td>
    <td width="60%">問卷題目</td>
    <td width="10%">投票總數</td>
    <td width="10%">結果</td>
    <td width="10%">狀態</td>
  </tr>
  <?php
  $ques=all("que",['parent'=>0]);
  foreach($ques as $k=> $q){
  ?>
  <tr>
    <td class="ct"><?=($k+1);?></td>
    <td><?=$q['text'];?></td>
    <td class="ct"><?=$q['count'];?></td>
    <td class="ct"><a href='?do=result&id=<?=$q['id'];?>'>結果</a></td>
    <td class="ct">
      <?php
      if(empty($_SESSION['login'])){
          echo "請先登入";
      }else {
        echo "<a href='?do=vote&id=".$q['id']."'>參與投票</a>";
      }
      ?>
    </td>
  </tr>
  <?php
  }
  ?>
</table>
</fieldset>