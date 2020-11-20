<?php
header("Content-Type:text/html; charset=utf-8");
$dsn="mysql:host=localhost;charset=utf8;dbname=bcsa";
$pdo=new PDO($dsn,"root","admin");

$sql="SELECT 
        substr(`班級座號`,1,3) AS '班級',
        sum(`事假`) AS '事假',
        sum(`病假`) AS '病假',
        sum(`公假`) AS '公假',
        sum(`曠課`) AS '曠課' 
      FROM 
        `records` 
      WHERE 
        substr(`年月日`,3,2)='03' 
      group by 
        `班級`
      order by
       `班級`";
  
$records=$pdo->query($sql)->fetchAll(); //各班出勤統計

$sql2="SELECT substr(`班級座號`,1,3) AS '班級' ,  count(*) AS '人數' FROM students GROUP BY substr(`班級座號`,1,3)";

$stus=$pdo->query($sql2)->fetchAll(); //各班人數

//print_r($records);
//print_r($stus);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html";charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>出勤紀錄</title>
  <link rel="stylesheet" href="style.css">

</head>
<body>
 <!--table>tr*2>td*6---> 
<table>
  <tr>
    <td>班級</td>
    <td>事假</td>
    <td>病假</td>
    <td>公假</td>
    <td>曠課</td>
    <td>到課率</td>
    <td>名次</td>
  </tr>
<?php 
foreach($records as $rec){
  $num=0;
  foreach($stus as $st){
    if($st['班級']==$rec['班級']){
      $num=$st['人數'];
    }
  }
  $rate=ROUND((156*$num-$rec['事假']-$rec['病假']-$rec['公假']-$rec['曠課'])/(156*$num),4)*100;

?>
  <tr>
    <td><?=$rec['班級'];?></td>
    <td><?=$rec['事假'];?></td>
    <td><?=$rec['病假'];?></td>
    <td><?=$rec['公假'];?></td>
    <td><?=$rec['曠課'];?></td>
    <td><?=$rate."%";;?></td>
    <td></td>
  </tr>
<?php 

}
?>
</table>

</body>
</html>