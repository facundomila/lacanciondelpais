<div class="container" style="max-width:1098px;">

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
	echo "</div></div>\n";
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
	echo "<div class=\"seccion\">".$R["seccion"].($subseccion ? " &raquo; $subseccion" : "")."</div></a>\n";
	echo "</div></div></div>\n";
	$ini=false;
}
mysql_free_result($C);
?>
</div>