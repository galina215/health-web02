<fieldset style="width:90%;margin:auto;">
  <legend>帳號管理</legend>
  <form action="dapi.php?do=adUser"method="post">
    <table style="width:80%;margin:auto;" class="ct">
    <tr class="clo">
      <td>帳號</td>
      <td>密碼</td>
      <td>刪除</td>
    </tr>
    <?php
    $users=all("user","");
    foreach($users as $u){
  
    
    ?>
    <tr>
      <td><?=$u['acc'];?></td>
      <td><?=str_repeat("*",strlen($u['pw']));?></td>
      <td><input type="checkbox" name="del[]" value=<?=$u['id'];?>></td>
    </tr>
    <?php
      }
    ?>
    <tr>
      <td colspan="3"><input type="submit" value="確認刪除"><input type="reset" value="清空選取"></td>
    </tr>
    </table>
  </form>

  <h2>新增會員</h2>
  <form>
      <table>
        <tr>
          <td colspan="2" style="color:red">*請設定您要註冊的帳號及密碼(最長12個字元)</td>
        </tr>
        <tr>
          <td>Step1:登入帳號</td>
          <td><input type="text" name="acc" id="acc" value=""></td>
        </tr>
        <tr>
          <td>Step2:登入密碼</td>
          <td><input type="password" name="pw" id="pw" value=""></td>
        </tr>
        <tr>
          <td>Step3:再次確認密碼</td>
          <td><input type="password" name="pw2" id="pw2" value=""></td>
        </tr>
        <tr>
          <td>Step4:信箱(忘記密碼時使用)</td>
          <td><input type="text" name="email" id="email" value=""></td>
        </tr>        
        <tr>
          <!----因為要使用ajax的方式來做註冊，因此把submit改成button，並用onclick來觸發註冊專用的js函式reg()--->
          <td><input type="button" value="註冊" onclick="reg()"><input type="reset" value="清除"></td>
          <td class='r'>
          </td>
        </tr>
      </table>
    </form>
</fieldset>
<script>
function reg(){
  let acc=$("#acc").val()
  let pw=$("#pw").val()
  let pw2=$("#pw2").val()
  let email=$("#email").val()
  // console.log(acc,pw,pw2,email)

  if(acc==""|| pw==""|| pw2==""|| email==""){
      alert("不可空白")
  }else{

  $.post("api.php?do=reg",{acc,pw,email},function(res){
    if(res=='1'){
      location.reload();

    }else{
      alert("帳號重複")
    }
  })

  }
  
}


</script>