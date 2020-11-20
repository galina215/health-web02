<?php
header("Content-Type:text/html; charset=utf-8");
$dsn="mysql:host=localhost;charset=utf8;dbname=bcsa";
$pdo=new PDO($dsn,"root","admin");

$sql="select * from students order by 學號 limit 14";
$datas=$pdo->query($sql)->fetchAll();
$major=[
 "商業經營科" =>"A401",
 "國際貿易科" =>"A402",
 "資料處理科" =>"A404",
 "幼兒保育科" =>"A503",
 "美容科" =>"A504",
 "室內佈置科" =>"A506"
];

$grade=[
"畢業"=>'001',
"補校"=>'002',
"結業"=>'003',
"修業"=>'004'
];



// 正規做法 echo mb_substr($data['畢業國中'],(mb_strlen($data['畢業國中'])-2),2);
/*
 if(mb_substr($data['身分證號碼'],1,1)==1){
  $gender="男";
}else{
  $gender="女";
} */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>新生名冊</title>
  <style>
    table{
      width:800px;
      text-align:center;
    }
    td{
      border:1px solid black;
      height:20px;
    }
  
  </style>
</head>
<body>
 <!--table>tr*2>td*6---> 
<table>
  <tr>
    <td>科別代號</td>
    <td colspan="2">學號</td>
    <td rowspan="2">身分證號碼</td>
    <td colspan="6">出生</td>
    <td rowspan="2" colspan="4">入學資格</td>
    <td rowspan="2">備註</td>
  </tr>
  <tr>
    <td>科別名稱</td>
    <td>姓名</td>
    <td>性別</td>
    <td colspan="2">年</td>
    <td colspan="2">月</td>
    <td colspan="2">日</td>
  </tr>
  <!---資料內容列--->
 <?php
 foreach($datas as $data){
  //判斷性別
  $gender=(mb_substr($data['身分證號碼'],1,1)==1)?"男":"女";
  $code=$grade[mb_substr($data['畢業國中'],9,2)];
  /* echo $major[$data['科別']]."-".$data['科別']."-".$data['學號']."-".$data['姓名']."-".$gender."-".$data['身分證號碼']."-".$data['出生年月日']."-".$code."-".$data['畢業國中'];
  
  echo "<br>"; */
  $birth=[];
  $birth[0]=mb_substr((mb_substr($data['出生年月日'],0,4)-1911),0,1);
  $birth[1]=mb_substr((mb_substr($data['出生年月日'],0,4)-1911),1,1);
  $birth[2]=mb_substr($data['出生年月日'],5,1);
  $birth[3]=mb_substr($data['出生年月日'],6,1);
  $birth[4]=mb_substr($data['出生年月日'],8,1);
  $birth[5]=mb_substr($data['出生年月日'],9,1);

  /* for($i=2;$i<7;$i++){
    $birth[$i]=mb_substr($data['出生年月日'],($i+3),1);
  } */
  //print_r($birth)
 ?>
  <tr>
    <td><?=$major[$data['科別']];?></td>
    <td colspan="2"><?=$data['學號'];?></td>
    <td rowspan="2"><?=$data['身分證號碼'];?></td>
    <td rowspan="2"><?=$birth[0];?></td>
    <td rowspan="2"><?=$birth[1];?></td>
    <td rowspan="2"><?=$birth[2];?></td> <!--mb_substr($data['出生年月日'],5,1)-->
    <td rowspan="2"><?=$birth[3];?></td><!--mb_substr($data['出生年月日'],6,1)-->
    <td rowspan="2"><?=$birth[4];?></td>
    <td rowspan="2"><?=$birth[5];?></td>
    <td rowspan="2"><?=mb_substr($code,0,1);?></td>
    <td rowspan="2"><?=mb_substr($code,1,1);?></td>
    <td rowspan="2"><?=mb_substr($code,2,1);?></td>
    <td rowspan="2"><?=$data['畢業國中'];?></td>         
    <td rowspan="2"></td>         
  </tr>
  <tr>
    <td><?=$data['科別'];?></td>
    <td><?=$data['姓名'];?></td>
    <td><?=$gender;?></td>
  </tr>
<?php
}
?>
</table>

</body>
</html>