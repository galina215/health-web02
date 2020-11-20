<!---利用GET帶過來的參數直接在結果頁中呈現訂單的訊息--->

感謝您的訂購，您的訂單編號是：<?=$_GET['no'];?><br>
電影名稱：<?=$_GET['name'];?><br>
日期：<?=$_GET['date'];?><br>
場次時間 :<?=$_GET['sess'];?><br>
座位：<br>
<?php

  //坐位的資訊會被組合成為一個以逗號分隔的字串，因此使用explode()函式來將字串轉換成陣列
  $seats=explode(",",$_GET['seats']) ;

  //排序陣列,預設是由小到大排列,如果要由大到小使用rsort()
  sort($seats);

  //以迴圈的方式列出座位的訊息
  foreach($seats as $s){
    echo ceil(($s+1)/5)."排".($s%5+1)."號<br>";
  }
  echo "共".$_GET['qt']."張電影票";

?>
<div class="ct"><button onclick="lof('?do=home')">確認</button></div>