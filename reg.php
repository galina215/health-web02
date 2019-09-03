<fieldset style="width:50%;padding:20px;margin:auto;">
  <legend>會員登入</legend>
  <form>
    <table>
      <tr>
        <td colspan="2" style="color:red">*請設定您要註冊的帳號密碼（最長12個字元）</td>
      </tr>
      <tr>
        <td>登入帳號</td>
        <td><input type="text" name="acc" id="acc" value=""></td>
      </tr>
      <tr>
        <td>登入密碼</td>
        <td><input type="password" name="pw" id="pw" value=""></td>
      </tr>
      <tr>
        <td>再次確認密碼</td>
        <td><input type="password" name="pw2" id="pw2" value=""></td>
      </tr>
      <tr>
        <td>信箱（忘記密碼時使用）</td>
        <td><input type="text" name="email" id="email" value=""></td>
      </tr>
      <tr>
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
  console.log(acc,pw,pw2,email)

  if(acc==""|| pw==""|| pw2==""|| email==""){
      alert("不可空白")
  }else{

  $.post("api.php?do=reg",{acc,pw,email},function(res){
    if(res=='1'){
      alert("註冊完成，歡迎光臨")

    }else{
      alert("帳號重複")
    }
  })

  }
  
}


</script>