<?php
header("Content-Type:text/html; charset=utf-8");
$dsn="mysql:host=localhost;charset=utf8;dbname=bcsa";
$pdo=new PDO($dsn,"root","admin");

$sql="select * from students order by 學號";
$rows=$pdo->query($sql);

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

for($i=0;$i<7;$i++){
  $data=$rows->fetch();
//判斷性別
$gender=(mb_substr($data['身分證號碼'],1,1)==1)?"男":"女";
$code=$grade[mb_substr($data['畢業國中'],9,2)];
echo $major[$data['科別']]."-".$data['科別']."-".$data['學號']."-".$data['姓名']."-".$gender."-".$data['身分證號碼']."-".$data['出生年月日']."-".$code."-".$data['畢業國中'];

echo "<br>";
}

// 正規做法 echo mb_substr($data['畢業國中'],(mb_strlen($data['畢業國中'])-2),2);
/*
 if(mb_substr($data['身分證號碼'],1,1)==1){
  $gender="男";
}else{
  $gender="女";
} */
?>