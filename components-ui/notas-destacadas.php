<style>
    .w3-half img{
        opacity:1;
        cursor:pointer;
    }
    .w3-half img:hover{opacity:1}
	.subtitle-block{
		border-bottom: 3px solid red;
		margin: 15px 0;
		padding: 5px;
		text-align: right;
	}
	.half-text-content {
		width: 80%;
		height: 80%;
		margin: 10%;
	}
	.half-text-content a{
    	color: #fff;
    }
    .half-text-content a:hover{
		color: #eee;
		text-decoration: none;
	}
	.half-text-content .title{
		font-size: 24px;
		text-align: center;
		font-weight: bolder;
	}
	.half-text-content .fecha{
		font-size: 14px;
		padding-top: 15px;
		text-align: center;
	}
    .half-text-content .seccion{
		font-size: 18px;
		padding-top: 15px;
		letter-spacing: 2px;
		color: #eee;
		text-align: center;
	}
</style>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !notas destacadas CONTENT! -->
<div class="clear"></div>
<div class="w3-main">

  <!-- Header
  <div class="w3-row-padding">
  	<div class="subtitle-block"><h3>Notas destacadas</h3></div>
  </div> -->
  <!-- Photo grid (modal) -->
  <div class="w3-row-padding">

<?php
$ini=true;
$C=mysql_query ("SELECT  posts.Id, posts.link, secciones.link AS sLink, secciones.seccion, subseccionID, fecha, titulo, bajada, img_1 FROM posts, secciones WHERE (posts.Id=".$Rh["destacada1"]." OR posts.Id=".$Rh["destacada2"].") AND secciones.id=seccionID AND img_1<>'' ORDER BY Id".($Rh["destacada1"]>$Rh["destacada2"] ? " DESC" : ""));
while ($R=mysql_fetch_assoc($C)){

	$subLink="";
	$subseccion="";
	if ($R["subseccionID"]) {
		$C2=mysql_query("SELECT * FROM subsecciones WHERE id=".$R["subseccionID"]);
		if ($R2=mysql_fetch_assoc($C2)) {
			$subseccion=$R2["subseccion"];
			$subLink=$R2["link"]."/";
		}
		mysql_free_result($C2);
	}

	echo "<div class=\"w3-half\"><div class=\"homeNoti".($ini ? " pri" : "")."\">\n";

	list($w, $h)=@getimagesize("sitio/jpg/".$R["img_1"]);
	if ($w && $h)
		$h=round(285*$h/$w);
	else
		$h=160;

	echo "<div class=\"nota-box\">";
	echo "<div class=\"filter\"></div><img src=\"sitio/jpg/".$R["img_1"]."\" width=\"100%\" width=\"100%\" class=\"picture\"/>";
	echo "<div class=\"overlay\"><div class=\"half-text-content\">";
    echo "<a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">\n";
	echo "<div class=\"title\">".$R["titulo"]."</div><div class=\"fecha\">".fechaLarga($R["fecha"])."</div>\n";
    echo "<div class=\"seccion\">".$R["seccion"].($subseccion ? " &raquo; $subseccion" : "")."</a></div>\n";
	echo "</div></div></div></div></div>\n";
	$ini=false;
}
mysql_free_result($C);
?>
  </div>
</div>
<div class="clear"></div>

<!-- End notas destacadas content -->

<script>
      $("#menu").hover(function(){
          $('.flyout').removeClass('hidden');
      },function(){
          $('.flyout').addClass('hidden');
      });
  </script>