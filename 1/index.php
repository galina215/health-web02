<!DOCTYPE html>
<html>
<head>
	<?php
		ini_set("max_execution_time", "200");
		$thisPage="sur/uplc2";
		include_once "../../inc/head.php";
		include_once "../../inc/headf_sur.php";
		include_once("../uplc/type.php");
		$cr_id = (int) $_SESSION['cr_id'] ;
	?>
	
</head>
<body>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all">
		<?php
			include_once "../../inc/main_menu.php";
		?>
		<p>程式測試中請勿使用</p>
		<p>
			<table>
				<font size=1 style='font-weight:bold'>※電子長證Endorse/附頁上傳注意事項</font>
				<tr><td><font size=1>1. 下載證書原始檔：</font></td><td><font size=1>請至SURVEY->查詢船舶->Print->All Long Certs下載所有證書，檔案格式皆為pdf檔</font></td></tr>
				<tr><td><font size=1>2. 編輯證書檔：</font></td><td><font size=1>加蓋驗船師電子章、註記或附頁，</font><font size=1 color='red'>切勿變更證書pdf檔檔名(即證書編號)</font></td></tr>
				<tr><td valign="top"><font size=1>3. 上傳證書檔：</font></td><td><font size=1>可一次(同時)上傳多個檔案</font><font size=1 color='red'>(按住Ctrl可多選)</font><font size=1>，僅限上傳pdf檔<br>同一艘船的證書建議同時上傳，不同船的證書也可同時上傳<br>此步驟可能需要較長時間(視證書多寡，約1~2分鐘)，請耐心等候</font></td></tr>
				<tr><td valign="top"><font size=1>4. 寄送證書更新通知：</font></td><td><font size=1>上傳完成後，系統即會立刻寄發電子證書更新通知給船東，請謹慎上傳<br>同一艘船之證書如分多次上傳，船東將會收到多次更新通知，故請盡量同時上傳</font></td></tr>
			</table>
		</p>
		<hr>
		<form method='post' enctype='multipart/form-data'>
			<table>
				<tr><td>Endorse日期&nbsp;</td><td><input type='text' name='endorse_date' id='endorse_date'>(YYYY-MM-DD)</td></tr>
				<tr><td>Endorse地點</td><td><input type='text' name='location' id='location'></td></tr>
				<tr><td>選擇證書PDF</td><td><input type='file' id='files' name='files[]' accept='.pdf' onchange='fileChange(this)'multiple></td></tr>
			</table>
		
		<?php
			//所更新之證書cert type array(寄信要用), $certs[crno][0, 1, 2...] = $cert_type 
		$certs = array();
		
		$endorse_date = isset($_POST['endorse_date'])?$_POST['endorse_date']:"";
		$location = isset($_POST['location'])?$_POST['location']:"";

		?>
		<script>
			document.getElementById("endorse_date").value = '<?=$endorse_date?>';
			document.getElementById("location").value = '<?=$location?>';
		</script>
		<?php
		if (isset($_POST['upload'])){
			$error = false;
			$extension = $_POST['extension'];
			foreach($extension as $date){
				if (empty($date))
					continue;
				if (checkIssueDate($date) != ""){
					showinfo("請確認Extension日期正確");
					$error = true;
					break;
				}
			}
			if (checkIssueDate($endorse_date) != ""){
				showinfo("請確認Endorse日期正確");
				$error = true;
			}
			if (strlen($location) == 0){
				showinfo("請輸入Endorse地點");
				$error = true;
			}
			if (empty($_FILES['files']['name'][0])){
				showinfo("請選取檔案");
				$error = true;
			}
			if (!$error){
				foreach ($_FILES['files']['name'] as $k => $uploaded_name) {
					//echo $uploaded_name;
					$uploaded_tmp = $_FILES['files']['tmp_name'][$k];
					//副檔名pdf, 直接處理
					if (strtolower(pathinfo($uploaded_name, PATHINFO_EXTENSION)) == 'pdf'){
						//檔名
				 		$file_name = $uploaded_name;
				 		//去掉附檔名
				 		$file_no = reset(explode(".", $file_name));
				 		//檔案tmp路徑
		 		        $source_path = $uploaded_tmp;
		 		        processSingleFile($file_no, $source_path);
					}
				}
				$status = 8;
				$crid = 375;
				$sid = 0;
				include_once("../../inc/sendCertificate.php");
			}
			
		}

		//依據證書編號，更新對應的檔案
		function processSingleFile($file_no, $source_path){
			global $certs, $db, $rcUrl, $cr_id, $location, $endorse_date, $extension;

	        $query = "SELECT * from rc.UP_FILE where file_no ='$file_no'";
	        $result = $db->query($query);
	        if ($row = $result->fetchAssoc()){

		    	//只endorse長證
		    	if ($row['file_kind'] != 20)
		    		return;

				//現行檔路徑
		    	$target_path = $rcUrl . "/" . $row['jobyear'] . "/" . $row['jobloc'] . "/LC/" . $row['id'] . "." . $row['file_ext'];

				//檢查上傳檔與原檔是否相同，相同的話不做事
		    	$hash_old = sha1_file($target_path);
				$hash_new = sha1_file($source_path);
				if ($hash_old == $hash_new){
					echo $file_no." No changes detected<br>";
					return;
				}

				//儲存現行檔，zip解出來的url要用copy，pdf單檔為直接上傳，用move_uploaded_file
		    	if (substr($source_path, 0, 6) == "zip://")
					copy($source_path, $target_path);
				else
					move_uploaded_file($source_path, $target_path);

				//cert type
				if (!array_key_exists($row['crno'], $certs))
					$certs[$row['crno']] = array();
				$certs[$row['crno']][$row['id']] = $row['cert_type'];

				//extension date
				$extension_date = $extension[$row['id']];
				if (empty($extension_date))
					$extension_date = "0000-00-00";

		    	//儲存留存檔
		    	$reserve_filename = $row['id'] . "." . date("YmdHis") . "." . $row['file_ext'];
		    	$target_path2 = $rcUrl . "/" . $row['jobyear'] . "/" . $row['jobloc'] . "/LC/" . $reserve_filename;
				copy($target_path, $target_path2);

				$status = 8;
				//update UP_FILE
				$query="UPDATE rc.UP_FILE SET status = '$status', endorse_date='$endorse_date', endorse_user='$cr_id', endorse_location='$location', extension_date='$extension_date' WHERE file_no='$file_no' ";
				$db->query($query);

				//log 
				$query="INSERT INTO rc.UP_LOG (id, crno_old, crno_new, jobloc_old, jobloc_new, jobyear_old, jobyear_new, issue_date_old, issue_date_new, upd_date, upd_user, jobno_old, jobno_new, cert_type_old, cert_type_new, action, certno, valid_date_old, valid_date_new, endorse_date, endorse_user, endorse_location, ecc_old, ecc_new, filename, status, tid, extension_date) VALUES ( '" . $row['id'] . "', '" . $row['crno'] . "', '" . $row['crno'] . "', '" . $row['jobloc'] . "', '" . $row['jobloc'] . "', '" .$row['jobyear'] ."', '" .$row['jobyear'] ."', '".$row['issue_date']."', '".$row['issue_date']."', NOW(), '".$row['upd_user']."', '".$row['jobno']."', '".$row['jobno']."', '".$row['cert_type']."', '".$row['cert_type']."', 'E', '".$row['file_no']."', '".$row['valid_date']."', '".$row['valid_date']."', '$endorse_date', '$cr_id', '$location', '".$row['ecc']."', '".$row['ecc']."', '$reserve_filename', '$status', '".$row['tid']."', '$extension_date')";
				$db->query($query);

				//若為電子證書，另上傳至gcp加憑證
				gcpCurlPostFile($target_path, ($row['ecc'] == 1));
				echo $file_no." Uploaded<br>";
			}else{
				echo "<font color='red'>" . $file_no." Not found</font><br>";
			}
		}
		?>

			<div id='cert_list'>

			</div>
		</form>	
	</div>
	<?php
    	require_once "../../inc/foot.php";
	?>
</body>
</html>
