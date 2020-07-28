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
		<p>�{�����դ��ФŨϥ�</p>
		<p>
			<table>
				<font size=1 style='font-weight:bold'>���q�l����Endorse/�����W�Ǫ`�N�ƶ�</font>
				<tr><td><font size=1>1. �U���Үѭ�l�ɡG</font></td><td><font size=1>�Ц�SURVEY->�d�߲��->Print->All Long Certs�U���Ҧ��ҮѡA�ɮ׮榡�Ҭ�pdf��</font></td></tr>
				<tr><td><font size=1>2. �s���Ү��ɡG</font></td><td><font size=1>�[�\���v�q�l���B���O�Ϊ����A</font><font size=1 color='red'>�����ܧ��Ү�pdf���ɦW(�Y�Үѽs��)</font></td></tr>
				<tr><td valign="top"><font size=1>3. �W���Ү��ɡG</font></td><td><font size=1>�i�@��(�P��)�W�Ǧh���ɮ�</font><font size=1 color='red'>(����Ctrl�i�h��)</font><font size=1>�A�ȭ��W��pdf��<br>�P�@����Үѫ�ĳ�P�ɤW�ǡA���P��ҮѤ]�i�P�ɤW��<br>���B�J�i��ݭn�����ɶ�(���ҮѦh��A��1~2����)�A�Э@�ߵ���</font></td></tr>
				<tr><td valign="top"><font size=1>4. �H�e�Үѧ�s�q���G</font></td><td><font size=1>�W�ǧ�����A�t�ΧY�|�ߨ�H�o�q�l�Үѧ�s�q������F�A���ԷV�W��<br>�P�@����ҮѦp���h���W�ǡA��F�N�|����h����s�q���A�G�кɶq�P�ɤW��</font></td></tr>
			</table>
		</p>
		<hr>
		<form method='post' enctype='multipart/form-data'>
			<table>
				<tr><td>Endorse���&nbsp;</td><td><input type='text' name='endorse_date' id='endorse_date'>(YYYY-MM-DD)</td></tr>
				<tr><td>Endorse�a�I</td><td><input type='text' name='location' id='location'></td></tr>
				<tr><td>����Ү�PDF</td><td><input type='file' id='files' name='files[]' accept='.pdf' onchange='fileChange(this)'multiple></td></tr>
			</table>
		
		<?php
			//�ҧ�s���Ү�cert type array(�H�H�n��), $certs[crno][0, 1, 2...] = $cert_type 
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
					showinfo("�нT�{Extension������T");
					$error = true;
					break;
				}
			}
			if (checkIssueDate($endorse_date) != ""){
				showinfo("�нT�{Endorse������T");
				$error = true;
			}
			if (strlen($location) == 0){
				showinfo("�п�JEndorse�a�I");
				$error = true;
			}
			if (empty($_FILES['files']['name'][0])){
				showinfo("�п���ɮ�");
				$error = true;
			}
			if (!$error){
				foreach ($_FILES['files']['name'] as $k => $uploaded_name) {
					//echo $uploaded_name;
					$uploaded_tmp = $_FILES['files']['tmp_name'][$k];
					//���ɦWpdf, �����B�z
					if (strtolower(pathinfo($uploaded_name, PATHINFO_EXTENSION)) == 'pdf'){
						//�ɦW
				 		$file_name = $uploaded_name;
				 		//�h�����ɦW
				 		$file_no = reset(explode(".", $file_name));
				 		//�ɮ�tmp���|
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

		//�̾��Үѽs���A��s�������ɮ�
		function processSingleFile($file_no, $source_path){
			global $certs, $db, $rcUrl, $cr_id, $location, $endorse_date, $extension;

	        $query = "SELECT * from rc.UP_FILE where file_no ='$file_no'";
	        $result = $db->query($query);
	        if ($row = $result->fetchAssoc()){

		    	//�uendorse����
		    	if ($row['file_kind'] != 20)
		    		return;

				//�{���ɸ��|
		    	$target_path = $rcUrl . "/" . $row['jobyear'] . "/" . $row['jobloc'] . "/LC/" . $row['id'] . "." . $row['file_ext'];

				//�ˬd�W���ɻP���ɬO�_�ۦP�A�ۦP���ܤ�����
		    	$hash_old = sha1_file($target_path);
				$hash_new = sha1_file($source_path);
				if ($hash_old == $hash_new){
					echo $file_no." No changes detected<br>";
					return;
				}

				//�x�s�{���ɡAzip�ѥX�Ӫ�url�n��copy�Apdf���ɬ������W�ǡA��move_uploaded_file
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

		    	//�x�s�d�s��
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

				//�Y���q�l�ҮѡA�t�W�Ǧ�gcp�[����
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
