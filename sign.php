
<form method="post" enctype="multipart/form-data" action="upload.php">
編號：<input type="text" name="crno">
姓名：<input type="text" name="file_name">

<select name="file_kind">
　<option value="Taipei">台北</option>
　<option value="Taoyuan">桃園</option>
　<option value="Hsinchu">新竹</option>
　<option value="Miaoli">苗栗</option>
</select>
<select name="cert_type">
　<option value="Taipei">1</option>
　<option value="Taoyuan">2</option>
　<option value="Hsinchu">3</option>
　<option value="Miaoli">4</option>
</select>
<input type="file" name="my_file">
<input type="submit" value="Upload">
</form>

