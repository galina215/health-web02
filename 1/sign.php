
<form  id="form1" name="form1" method="post" enctype="multipart/form-data" action="upload.php" >
<!-- 編號：<input type="text" name="crno">
姓名：<input type="text" name="file_name"> -->
            <table>
				<tr><td>編號：</td><td><input type='text' name='crno' id='crno' required></td></tr>
				<tr><td>姓名：</td><td><input type='text' name='file_name' id='file_name' required></td></tr>
				<tr><td>年份(ex.2020)：</td><td><input type='text' name='jobyear' id='jobyear'pattern="[0-9]{4}" required></td></tr>
                <tr><td><select name="kind">
　              <option value="11">one</option>
　              <option value="22">two</option>
　              <option value="33">three</option>
　              <option value="44">four</option>
                </select></td></tr>
				<tr><td>選擇證書PDF</td><td><input type='file'  name='my_file' accept='.pdf' required></td></tr>
				<!-- <tr><td>選擇證書PDF</td><td><input type='file'  name='my_file[]'multiple accept='.pdf' ></td></tr> -->
                <tr><td><input type="submit" name="button" id="button" value="Upload"></td></tr>
            </table>

<!-- <select name="cert_type">
　<option value="Taipei">1</option>
　<option value="Taoyuan">2</option>
　<option value="Hsinchu">3</option>
　<option value="Miaoli">4</option>
</select> -->


</form>
<!-- <script>
 $(document).ready(function(){
    $("#button").click(function(){
        if($("#crno").val()==""){
            alert("你尚未填寫編號：");
            eval("document.form1['crno'].focus()");       
        }else if($("#file_name").val()==""){
            alert("你尚未填寫姓名");
            eval("document.form1['file_name'].focus()");    
        }else if($("#year").val()==""){
            alert("你尚未填寫年分");
            eval("document.form1['year'].focus()");       
        }else{
            document.form1.submit();
        }
    })
 })
</script> -->
