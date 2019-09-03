<?php
include_once "base.php";

$do=(!empty($_GET['do']))?$_GET['do']:"";

switch($do){
    case "reg":
        $acc=$_POST['acc'];
        $pw=$_POST['pw'];
        $email=$_POST['email'];

        $chkAcc=nums("user",['acc'=>$acc]);
        if($chkAcc>0){
            echo 0;
        }else{
            $data=[
                'acc'=>$acc,
                'pw'=>$pw,
                'email'=>$email
            ];
            save("user",$data);
            echo 1;
        }

    break;
    case "login":
    $acc=$_POST['acc'];
    $pw=$_POST['pw'];

    $chkAcc=nums("user",['acc'=>$acc]);
    if($chkAcc>0){
        $chkAcc=nums("user",['acc'=>$acc,'pw'=>$pw]);
        if($chkAcc>0){
            $_SESSION['login']=$acc;
            if($acc=='admin'){
                echo "1";
            }else{
                echo "2";
            }

        }else{
            echo "3";
        }
        
    }else{
        echo "4";
    }

    break;
    case "forget":
        $email=$_POST['email'];

        $chkEmail=nums("user",['email'=>$email]);
        if($chkEmail>0){
            echo "您的密碼為" . find("user",['email'=>$email])['pw'];
        }else{
            echo "查無此資料";
        }
    break;
    case "getList":
        $type=$_POST['type'];
        $news=all("news",['type'=>$type]);
         foreach($news as $n){
             $data[]=[
                 'id'=>$n['id'],
                 'title'=>$n['title'],
                 'text'=>$n['text']
             ]; 
            }
            // print_r($data);
            echo json_encode($data);
        
    break;
    case "adUser":

    if(!empty($_POST['del'])){
        foreach($_POST['del'] as $id){
            del("user",$id);
        }
    }
    to("admin.php?do=user");
    break;
    case "editNews":
        foreach($_POST['id'] as $key => $id){
            if(!empty($_POST['del']) &&　in_array($id , $_POST['del'])){
                del("news",$id);
            }else{
                $data=find("news",$id);
                $data['sh']=(in_array($id,$_POST['sh']))?"checked":"";
                save("news",$data);
            }
        }
        to("admin.php?do=news");
    break;
    case "newQue":
    $subject=$_POST['subject'];
    $options=$_POST['opt'];

    save("que",['text'=>$subject]);


    $parent=q("select max(`id`) from que")[0][0];
    foreach($options as $opt){
        save("que",['text'=>$opt,'parent'=>$parent]);
    }
    to("admin.php?do=que");

    break;
    case "vote";


    $vote=find("que",$_POST['opt']);
    // 選項id
    $id=$_POST['opt'];
    // 題目id
    $parent=$vote['parent'];

    $sql="update que set count=count+1 where id in($id,$parent)";
    $pdo->exec($sql);

    to("index.php?do=result&id=$parent");

    case "good";

    $id=$_POST['id'];
    $type=$_POST['type'];
    $user=$_POST['user'];

    if($type==1){
        save("log",['news'=>$id,'user'=>$user]);

        $news=find("news",$id);
        $news['good']++;
        save("news",$news);

    }else{
        $log=find("log",['news'=>$id,'user'=>$user]);
        del("log",$log['id']);

        $news=find("news",$id);
        $news['good']--;
        save("news",$news);
    }
    break;
}
?>