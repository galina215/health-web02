<?php
header("Content-Type:text/html; charset=utf-8");
$host='localhost';
$user='root';
$password='admin';
$db='bcsa';
//建立連線
$dsn="mysql:host=$host;charset=utf8;dbname=$db";
$pdo=new PDO($dsn,$user,$password);

$sql="select * from `students` where substr(`班級座號`,1,3)=103";

$row=$pdo->query($sql);
$num=$row->rowCount();
echo $num;
$data=$row->fetch();
//$data=$rows->fetch();
echo "<BR>";

do{
  echo $data['學號'].'-'.$data['姓名'].'-'.$data['班級座號'];
  echo "<br>";
  ///print_r($data);
}while($data=$row->fetch()); //取到$data=null為止

echo "<br>foreach的使用<BR>";

$data=$pdo->query($sql)->fetchAll();
foreach($data as $d){
  echo $d['學號'].'-'.$d['姓名'].'-'.$d['班級座號'];
  echo "<br>";
}

?>