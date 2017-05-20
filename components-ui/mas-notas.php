<style>
  .w3-third img{cursor:pointer}
	.subtitle-block{
		border-bottom: 3px solid red;
		margin: 15px 0;
		padding: 5px;
		text-align: right;
	}
	.third-text-content {
		width: 90%;
		height: 90%;
		margin: 5%;
	}
	.third-text-content a{
		color: #fff;
	}
	.third-text-content a:hover{
		color: #eee;
		text-decoration: none;
	}
	.third-text-content .title{
		font-size: 18px;
		text-align: center;
		font-weight: bolder;
		letter-spacing: 5px;
	}
	.third-text-content .fecha{
		font-size: 12px;
		padding-top: 10px;
		text-align: center;
	}
	.third-text-content .seccion{
		font-size: 14px;
		padding-top: 5px;
		letter-spacing: 2px;
		color: #eee;
		text-align: center;
	}
	.third-text-content .txt{
		font-size: 12px;
		padding-top: 5px;
		color: #eee;
		text-align: center;
	}
	.third-text-content a.leermas{
    	font-size: 14px;
    	position: absolute;
    	right: 15px;
    	bottom: 10px;
    }
	.third-text-content .social{
		width: 30px;
		height: 70px;
		position: absolute;
		bottom: 2px;
		left: 5px;
	}
</style>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<div class="clear"></div>
<div class="w3-main">

  <!-- Photo grid (modal) -->
  <div class="w3-row-padding">

<?php
$ini=true;
$info=array("i".$Rh["info1"] => array(), "i".$Rh["info2"] => array(), "i".$Rh["info3"] => array());
$C=mysql_query ("SELECT  posts.Id, posts.link, secciones.link AS sLink, secciones.seccion, subseccionID, fecha, titulo, bajada, img_1 FROM posts, secciones WHERE (posts.Id=".$Rh["info1"]." OR posts.Id=".$Rh["info2"]." OR posts.Id=".$Rh["info3"].") AND secciones.id=seccionID AND img_1<>'' ORDER BY fecha DESC") or error();
while ($R=mysql_fetch_assoc($C)){
	$info["i".$R["Id"]]=$R;
}
mysql_free_result($C);

foreach ($info as $R) {
	if (count($R)) {
	if ($ini) {
?>

<?php
	}
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

	echo "<div class=\"w3-third\"><div class=\"homeNoti".($ini ? " pri" : "")."\">\n";

	list($w, $h)=@getimagesize("sitio/jpg/".($R["Id"]>540 ? "th" : "").$R["img_1"]);
	if ($w && $h)
		$h=round(223*$h/$w);
	else
		$h=125;

	echo "<div class=\"nota-box\">";
	echo "<img src=\"sitio/jpg/th".$R["img_1"]."\" width=\"360px\" />";
	echo "<div class=\"overlay\"><div class=\"third-text-content\">";
	echo "<a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">\n";
	echo "<div class=\"title\">".$R["titulo"]."</div>\n";
	echo "<div class=\"seccion\">".$R["seccion"].($subseccion ? " &raquo; $subseccion" : "")."</div></a>\n";
	echo "</div></div></div></div></div>\n";
	$ini=false;
}}

if (!$ini) {
?>
<?php
}
?>

<?php
$ini=true;
$C=mysql_query ("SELECT  posts.Id, posts.link, secciones.link AS sLink, secciones.seccion, subseccionID, fecha, titulo, bajada, img_1 FROM posts, secciones WHERE home='si' AND $fil AND secciones.id=seccionID AND img_1<>'' ORDER BY fecha DESC LIMIT 0, 3");
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

	echo "<div class=\"w3-third\"><div class=\"homeNoti".($ini ? " pri" : "")."\">\n";

	list($w, $h)=@getimagesize("sitio/jpg/".($R["Id"]>540 ? "th" : "").$R["img_1"]);
	if ($w && $h)
		$h=round(223*$h/$w);
	else
		$h=125;

	echo "<div class=\"nota-box\">";
	echo "<img src=\"sitio/jpg/th".$R["img_1"]."\" height=\"360px\" width=\"auto\" />";
	echo "<div class=\"overlay\"><div class=\"third-text-content\">";
	echo "<a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">\n";
	echo "<div class=\"title\">".$R["titulo"]."</div>\n";
	echo "<div class=\"fecha\">".fechaLarga($R["fecha"])."</div>\n";
	echo "<div class=\"seccion\">".$R["seccion"].($subseccion ? " &raquo; $subseccion" : "")."</div></a>\n";
	echo "<div class=\"txt\">".substr($R["bajada"], 0, 100)."...</div>\n";
	echo "<a class=\"leermas\" href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">leer+</a>\n";
	echo "<div class=\"social\">\n";
	echo "<a target=\"_blank\" href=\"http://www.facebook.com/sharer.php?u=".__BASE__."notas/".$R["sLink"]."/$subLink".$R["link"].".html\"><img src=\"img/icoFBsmall.png\" title=\"compartir en Facebook\" alt=\"compartir en Facebook\"></a> \n";
	echo "<a target=\"_blank\" href=\"http://twitter.com/intent/tweet?text=".textoContent($R["titulo"], 115)." ".__BASE__."notas/".$R["sLink"]."/$subLink".$R["link"].".html\" class=\"twitter\"><img src=\"img/icoTWsmall.png\" title=\"compartir en Twitter\" style=\"padding-bottom:10px\" alt=\"compartir en Twitter\"></a> \n";
	echo "<g:plusone size=\"small\" annotation=\"none\" href=\"".__BASE__."notas/".$R["sLink"]."/$subLink".$R["link"].".html\"></g:plusone>\n";
	echo "</div></div></div></div></div></div>\n";
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
