<?php
header("Content-Type:text/html; charset=utf-8");
$host='localhost';
$user='root';
$password='admin';
$db='bcsa';
//建立連線
$link=mysqli_connect($host,$user,$password,$db);
//設定編碼
mysqli_query($link,"SET NAMES UTF8");
echo "<br>查詢的結果概要<BR>";
//建立查詢語句
$sql="select * from `students` where substr(`班級座號`,1,3)=103";

//送出查詢語句
$rows=mysqli_query($link,$sql);

echo "<br>do....while的使用<BR>";
$data=mysqli_fetch_assoc($rows);

//逐筆取出資料
do{
  echo $data['學號'].'-'.$data['姓名'].'-'.$data['班級座號'];
  echo "<br>";
  ///print_r($data);
}while($data=mysqli_fetch_assoc($rows)); //取到$data=null為止

echo "最後的data";


echo "<br>while的使用<BR>";
$sql="select * from `students` where substr(`班級座號`,1,3)=103";
//送出查詢語句
$rows=mysqli_query($link,$sql);
while($data=mysqli_fetch_assoc($rows)){
  echo $data['學號'].'-'.$data['姓名'].'-'.$data['班級座號'];
  echo "<br>";
}

echo "<br>for的使用<BR>";
$sql="select * from `students` where substr(`班級座號`,1,3)=103";
//送出查詢語句
$rows=mysqli_query($link,$sql);
$num=mysqli_num_rows($rows);

for($i=0;$i<$num;$i++){
  $data=mysqli_fetch_assoc($rows);
  echo $data['學號'].'-'.$data['姓名'].'-'.$data['班級座號'];
  echo "<br>";
}

echo "<br>foreach的使用<BR>";
$sql="select * from `students` where substr(`班級座號`,1,3)=103";
//送出查詢語句
$rows=mysqli_query($link,$sql);
$data=mysqli_fetch_all($rows,MYSQLI_ASSOC);

foreach($data as $d){
  echo $d['學號'].'-'.$d['姓名'].'-'.$d['班級座號'];
  echo "<br>";
}

?>