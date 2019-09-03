<fieldset>
  <legend>新增問卷</legend>
  <form action="api.php?do=newQue" method="post">
    <table style="width:80%">
      <tr>
        <td class="clo">問卷名稱</td>
        <td><input type="text" name="subject"></td>
      </tr>
      <tr class="clo"id="more">
        <td colspan="2" >
        選項<input type="text" name="opt[]" style="width:500px">
        <input type="button" value="更多" onclick="moreOpt()">
        </td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="新增"><input type="reset" value="清空"></td>
      </tr>
    </table>
  </form>

</fieldset>

<script>
function moreOpt(){
  let opt=`<tr class="clo">
            <td colspan="2">
              選項 <input type="text" name="opt[]"  style="width:500px">
            </td>
           </tr>`
  //將字串內容插入到id more的位置前面
  $("#more").before(opt)

}

</script>