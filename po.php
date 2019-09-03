<div>目前位置:首頁>分類網誌> <span id="nav">健康新知</span></div>
<fieldset style="width:20%;display:inline-block;vertical-align:top">
<legend>網誌分類</legend>
<ul style="list-style-type:none;padding:0">
  <li id="type1" class="item"><a>健康新知</a></li>
  <li id="type2" class="item"><a>菸害防制</a></li>
  <li id="type3" class="item"><a>癌症防治</a></li>
  <li id="type4" class="item"><a>慢性病防治</a></li>
</ul>
</fieldset>
<fieldset style="width:70%;display:inline-block;vertical-align:top">
<legend>文章列表</legend>
<div id="list"></div>
<div id="text"></div>
</fieldset>

<script>
let article;

getList(1)

$(".item").on("click",function(){
  let str=$(this).text();
 
  $("#nav").html(str)

  let type=$(this).attr("id").substr(4,1);
  getList(type)
  })

  function getList(type) {
    
  
  $.post("api.php?do=getList",{type},function(res){
    article=JSON.parse(res)
    console.log(article)
    let list="";
    article.forEach(function(val,idx){
      list=list+`<div><a href="javascript:showPost(${idx})">${val.title}</a></div>`;
    })
    $("text").hide()
    $("#list").html(list);
    $("#list").show();
  })
}

function showPost(idx){
  let post=article[idx].text
  $("#list").hide()
  $("#text").html(post)
  $("#text").show()
}

</script>