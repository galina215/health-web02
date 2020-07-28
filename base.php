<?php
$dsn = "mysql:host=localhost;charset=utf8;dbname=db02";
$pdo = new PDO($dsn,"root","admin");
session_start();

if(empty($_SESSION['total'])){  //先判斷session是否存在
  $chkDate=nums('total',['date'=>date("Y-m-d")]); //判斷今天日期的資料是否存在
  if($chkDate>0){

      //取出今天日期的瀏灠人次資料
      $today=find("total",['date'=>date("Y-m-d")]);
      //瀏灠人次加1
      $today['total']=$today['total']+1;
      //建立session資料
      $_SESSION['total']=$today['total'];
      //存回資料資料表
      save("total",$today);
  }else{
    //如果資料表中沒有今天日期的資料，則新增一筆今天的資料，同時把瀏灠人次設為1
      
      $today=[
          'date'=>date("Y-m-d"),
          'total'=>1
      ];

       //建立session資料
      $_SESSION['total']=1;
      save("total",$today);

  }

}



function find($table,$def)
{
  global $pdo;
  if(is_array($def)) {
    foreach($def as $key => $val){
      $str[] = sprintf("%s='%s'",$key,$val);
    }
    return $pdo->query("select * from $table where ".implode("&&",$str)."")->fetch(PDO::FETCH_ASSOC);
    
  }else{
    
    return $pdo->query("select * from $table where id='$def'")->fetch(PDO::FETCH_ASSOC);
  }
}

function save($table,$data)
{
  global $pdo;
  if(!empty($data['id'])){
    foreach ($data as $key =>$val){
      if($key !='id'){
        $str[] = sprintf("%s='%s'",$key,$val);
      }
    }
    return $pdo->exec("update $table set ".implode(",",$str)."where id='".$data['id']."'");
   

  }else{
   
    return $pdo->exec("insert into $table(`".implode("`,`",array_keys($data))."`)values('".implode("','",$data)."')");
  }
}


function to($url)
{
      header("location:$url");
    
}

function del($table,$def)
{
  global $pdo;
  if(is_array($def)) {
    foreach($def as $key => $val){
      $str[] = sprintf("%s='%s'",$key,$val);
    }
    return $pdo->exec("delete from $table where ".implode(" && ",$str)."");
 
  }else{
   
    return $pdo->exec("delete from $table where id='$def'");
  }
}

function q($str)
{
  global $pdo;
  return $pdo->query($str)->fetchAll();
}

function all($table,$def)
{
  global $pdo;
  if(is_array($def)) {
    foreach ($def as $key=> $val){
      $str[] = sprintf("%s='%s'",$key,$val);
    }
    return $pdo->query("select * from $table where ".implode(" && ",$str)."")->fetchAll();
    
  }else{
    return $pdo->query("select * from $table")->fetchAll();
  }
}

function nums($table,$def){
  global $pdo;
  if(is_array($def)){
    foreach($def as $key => $val){
      $str[]=sprintf("%s='%s'",$key,$val);
    }
    return $pdo->query("select count(*) from $table where ".implode("&&",$str)."")->fetchColumn();
  }else{
    return $pdo->query("select count(*) from $table")->fetchColumn();
  }
}

?>