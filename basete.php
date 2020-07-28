<?php
$dsn = "mysql:host=localhost;charset=utf8;dbname=sign";
$pdo = new PDO($dsn,"root","admin");
session_start();




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