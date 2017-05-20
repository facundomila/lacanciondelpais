<style>
	.w3-fifth {
	width:18%;
	position:relative;
	float:left;
	margin: 1%
	}
    .w3-fifth img{opacity:0.8;cursor:pointer}
    .w3-fifth img:hover{opacity:1}
	.subtitle-block{
		border-bottom: 3px solid red;
		margin: 15px 0;
		padding: 5px;
		text-align: right;
	}
	.fifth-text-content {
		width: 80%;
		height: 80%;
		margin: 10%;
	}
	.fifth-text-content a{
		color: #fff;
	}
	.fifth-text-content a:hover{
		color: #eee;
		text-decoration: none;
	}
	.fifth-text-content .title{
		font-size: 18px;
		text-align: center;
		font-weight: bolder;
	}
	.fifth-text-content .seccion{
		font-size: 12px;
		padding-top: 10px;
		letter-spacing: 2px;
		color: #eee;
		text-align: center;
	}
</style>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<div class="w3-main">
<div class="w3-row-padding">

<?php
$C=mysql_query("SELECT posts.Id, posts.link, secciones.link AS sLink, seccionID, subseccionID, titulo, artista, img_1, img_2 FROM posts, secciones WHERE (subseccionID=2 OR img_2<>'') AND (img_1<>'' OR img_2<>'') AND secciones.id=SeccionID ORDER BY fecha DESC, posts.Id DESC LIMIT 0, 20") or error();
while ($R=mysql_fetch_assoc($C)) {
	$subLink="";
	if ($R["subseccionID"]) {
		$C2=mysql_query("SELECT link FROM subsecciones WHERE id=".$R["subseccionID"]);
		if ($R2=mysql_fetch_assoc($C2))
			$subLink=$R2["link"]."/";

		mysql_free_result($C2);
	}

	echo "<div class=\"w3-fifth\"><div class=\"nota-box\">
			<img src=\"sitio/jpg/".($R["Id"]>540 ? "th" : "").($R["img_2"] ? $R["img_2"] : $R["img_1"])."\" width=\"100%\">
			<div class=\"overlay\"><div class=\"fifth-text-content\">
			<a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">
			<div class=\"title\">".$R["titulo"].($R["artista"] ? "</div>><div class=\"seccion\">".$R["artista"] : "")."</div>
			</a></div></div></div></div>\n";
}
mysql_free_result($C);
?>
</div></div>
<div class="clear"></div>
