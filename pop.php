<style>
.more{
    background:rgba(51,51,51,0.8);
    color:#FFF;
    min-height:100px;
    width:300px;
    position:fixed;
    display:none;
    z-index:9999;
    overflow:auto;
}



</style>
<fieldset>
<legend>目前位置：首頁>人氣文章區</legend>
<table style="width:95%;margin:auto">
    <tr>
        <td width=30%>標題</td>
        <td width=55%>內容</td>
        <td></td>
    </tr>
    <?php

    $typeStr=[
        1=>"健康新知",
        2=>"菸害防制",
        3=>"癌症防治",
        4=>"慢性病防治",
    ];
    $all=nums("news",['sh'=>"checked"]);
    $div=5;
    $pages=ceil($all/$div);
    $now=(!empty($_GET['p']))?$_GET['p']:1;
    $start=($now-1)*$div;

    $news=q("select * from news where sh='checked' order by good desc limit $start,$div");
    foreach($news as $k=>$n){
?>
    <tr>
        <td class="ti clo" id="ti<?=$k;?>" style="cursor:pointer"><?=$n['title'];?></td>
        <td>
        <div id="line<?=$k;?>" class="line"><?=mb_substr($n['text'],0,20,'utf8');?></div>
        <div id="all<?=$k;?>" class="more">
        <h3 style='color:#39dde6'><?=$typeStr[$n['type']];?></h3>
        <pre><?=$n['text'];?></pre>
        </div>
        </td>
        <td>
        <?php
            echo "<span id='vie".$n['id']."'>".$n['good']."</span>個人說<img src='./icon/02B03.jpg' style='width:20px'>";
            if(!empty($_SESSION['login'])){

                $chk=[
                    'news'=>$n['id'],
                    'user'=>$_SESSION['login']
                ];
                if(nums("log",$chk)>0){
            ?>
            <a id=good<?=$n['id'];?> href="#" onclick="good('<?=$n['id'];?>','2','<?=$_SESSION['login'];?>')">收回讚</a>
            <?php
                }else{
            ?>
            <a id=good<?=$n['id'];?> href="#" onclick="good('<?=$n['id'];?>','1','<?=$_SESSION['login'];?>')">讚</a>
            <?php
                }
            }
        ?>
        </td>
    </tr>
<?php
    }

?>
    <tr>
        <td>
        <?php
            if(($now-1)>0){
                echo "<a href='?do=news&p=".($now-1)."'>&lt;</a>";
            }
            for($i=1;$i<=$pages;$i++){
                if($i==$now){
                    echo "<span style='font-size:20px'> $i </span>";
                }else{
                    echo "<a href='?do=news&p=$i'> $i </a>";
                }
            }
            if(($now+1)<=$pages){
                echo "<a href='?do=news&p=".($now+1)."'>&gt;</a>";
            }
        ?>
        </td>
        <td></td>
        <td></td>
    </tr>
</table>
</fieldset>
<script>
$(".ti").hover(function(){
  $(".more").hide();
  $(this).next().children(".more").show();
},
function(){
    $(".more").hide();
}

)
function good(id,type,user)
{
	$.post("api.php?do=good",{id,type,user},function()
	{
		if(type=="1")
		{
			$("#vie"+id).text($("#vie"+id).text()*1+1)
			$("#good"+id).text("收回讚").attr("onclick","good('"+id+"','2','"+user+"')")
		}
		else
		{
			$("#vie"+id).text($("#vie"+id).text()*1-1)
			$("#good"+id).text("讚").attr("onclick","good('"+id+"','1','"+user+"')")
		}
	})
}


</script>