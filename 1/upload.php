<?php
 include_once "base.php";




// $link=mysql_connect("localhost","root","admin") or die("連接失敗");

// mysql_select_db("rc",$link);

// mysql_query("SET NAMES utf8");

// $query = "SELECT * from rc.UP_FILE where crno ='$crno'";
// $q=mysql_query($query);

// $re=mysql_fetch_array($q);

// echo $re; echo "<br>";



# 檢查檔案是否上傳成功
$crno=$_POST['crno'];
$file_name=$file_no=$_POST['file_name'];
$jobyear=$_POST['jobyear'];
$kind=$_POST['kind'];


echo "編號:".$crno. '<br/>';
echo "類:".$kind. '<br/>';

switch($kind){
case "11":

  $file_kind='100';
  $cert_type='150';
  echo $file_kind.'<br/>'.$cert_type.'<br/>';
// echo 100;
break;
case "22":
  $file_kind='200';
  $cert_type='250';
 echo $file_kind.'<br/>'.$cert_type.'<br/>';
break;
default:
echo "沒有相符合的結果";
}

if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK){
  echo '檔案名稱: ' . $_FILES['my_file']['name'] . '<br/>';
  echo '檔案類型: ' . $_FILES['my_file']['type'] . '<br/>';
  echo '檔案大小: ' . ($_FILES['my_file']['size'] / 1024) . ' KB<br/>';
  echo '暫存名稱: ' . $_FILES['my_file']['tmp_name'] . '<br/>';

  $str_sec = explode(".",$_FILES['my_file']['name'])[1];
  echo '類別: ' . $str_sec;
  # 檢查檔案是否已經存在
  if (file_exists('upload/' . $_FILES['my_file']['name'])){
    echo '檔案已存在。<br/>';
  } else {
    $file = $_FILES['my_file']['tmp_name'];
    $dest = 'upload/' . $_FILES['my_file']['name'];

    # 將檔案移至指定位置
    move_uploaded_file($file, $dest);
  }
} else {
  echo '錯誤代碼：' . $_FILES['my_file']['error'] . '<br/>';
}

// echo '<pre>';print_r($_FILES['my_file']['name']);
// foreach ($_FILES['my_file']['name'] as $k => $uploaded_name) {
//  echo "測試:".$_FILES['my_file']['name'][1];
// }
//  echo "名字測試:".print_r($_FILES['my_file']['name']). '<br/>';
$query = "SELECT * from rc.UP_FILE where crno ='$crno'";
$row=$pdo->query($query)->fetch(PDO::FETCH_ASSOC);
echo "123";
echo '<pre>';print_r($row);
$status = 1;
$ecc = 1;
echo $row['upd_user']. '<br/>';
// $datetime = date ("Y- m - d  H : i : s");
// echo $dd;
// $query="UPDATE rc.UP_FILE SET status = '$status', endorse_date='$endorse_date', endorse_user='$cr_id', endorse_location='$location', extension_date='$extension_date' WHERE file_no='$file_no' ";
// 				$db->query($query);
$query="INSERT INTO rc.UP_FILE (crno, jobloc, jobyear, file_name, file_no, file_kind, cert_type, file_ext, upd_date, upd_user, status, audit_dep, ecc)
 VALUES (  '".$crno."', '" . $row['jobloc'] . "', '".$jobyear."' , '".$file_name."', '".$file_no."', '".$file_kind."', '".$cert_type."', '".$str_sec."', NOW(), '".$row['upd_user']."', '".$status."', '200', '".$ecc."')";
        $count = $pdo->exec($query);
        echo "寫入".$count."筆資料". '<br/>';
        $pdo->exec($query);
        echo $query;
// $query="INSERT INTO rc.UP_LOG (id, crno_old, crno_new, jobloc_old, jobloc_new, jobyear_old, jobyear_new, issue_date_old, issue_date_new, upd_date, upd_user, jobno_old, jobno_new, cert_type_old, cert_type_new, action, certno, valid_date_old, valid_date_new, endorse_date, endorse_user, endorse_location, ecc_old, ecc_new, filename, status, tid, extension_date) VALUES ( '" . $row['id'] . "', '" . $row['crno'] . "', '" . $row['crno'] . "', '" . $row['jobloc'] . "', '" . $row['jobloc'] . "', '" .$row['jobyear'] ."', '" .$row['jobyear'] ."', '".$row['issue_date']."', '".$row['issue_date']."', NOW(), '".$row['upd_user']."', '".$row['jobno']."', '".$row['jobno']."', '".$row['cert_type']."', '".$row['cert_type']."', 'E', '".$row['file_no']."', '".$row['valid_date']."', '".$row['valid_date']."', '$endorse_date', '$cr_id', '$location', '".$row['ecc']."', '".$row['ecc']."', '$reserve_filename', '$status', '".$row['tid']."', '$extension_date')";
// 				$db->query($query);
 

?>