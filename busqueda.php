<?php
require_once "sistema.inc.php";
require_once __PATH_FUN__."tiempo.fun.php";

$titulo="Búsqueda de '".$_GET["q"]."'";
$descripcion=textoContent("Búsqueda en 'La Canción del País', web del programa 'De Ushuaia a la Quiaca', FM Radio Universidad de Rosario.");

require_once __PATH_INC__."header2.inc.php";

echo "<h1 class=\"naranja upper\">Búsqueda de '".$_GET["q"]."'</h1>\n";

echo "<ul class=\"notasSeccion\">\n";

$subLink="";
$subseccion="";
$ini=true;

$C=mysql_query("SELECT MATCH (seccion, titulo, bajada, artista, cuerpo, columnista) AGAINST ('".$_GDB["q"]."'), COUNT(*) AS cant FROM posts WHERE MATCH (seccion, titulo, bajada, artista, cuerpo, columnista) AGAINST ('".$_GDB["q"]."')");
if ($R=mysql_fetch_assoc($C))
	$cant=(int)$R["cant"];
else
	$cant=0;

mysql_free_result($C);

$cxp=10;
$cPag=ceil($cant/$cxp);
$pag=(isset($_GET["pag"]) ? $_GET["pag"] : 1);
if ($pag>$cPag) $pag=$cPag;
if ($pag<1)	$pag=1;
$ppp=($pag-1)*$cxp;

$sql="SELECT posts.Id, posts.link, secciones.seccion, secciones.link AS sLink, subseccionID, fecha, titulo, bajada, artista, img_1, img_2, MATCH (posts.seccion, titulo, bajada, artista, cuerpo, columnista) AGAINST ('".$_GDB["q"]."') AS relevancia FROM posts, secciones WHERE MATCH (posts.seccion, titulo, bajada, artista, cuerpo, columnista) AGAINST ('".$_GDB["q"]."') AND secciones.id=seccionID ORDER BY relevancia DESC LIMIT $ppp, $cxp";

$C=mysql_query($sql) or printf(mysql_error());
while ($R=mysql_fetch_assoc($C)) {
	$ini=false;
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
	
	echo "<li>\n";
	echo "<div class=\"txt\">\n";
	echo "<p class=\"fecha\">".fechaLarga($R["fecha"])."<span class=\"upper\"> / <a href=\"notas/".$R["sLink"]."/\">".$R["seccion"]."</a>".($subseccion ? " &raquo; <a href=\"notas/".$R["sLink"]."/$subLink\">$subseccion</a></span>" : "")."</p>\n";
	echo "<h2 class=\"turquesa\"><a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">".$R["titulo"].($R["artista"] ? " · ".$R["artista"] : "")."</a></h2>\n";
	echo "<p>".$R["bajada"]."</p>\n";
	
	echo "<div class=\"social\">";
	echo "<a target=\"_blank\" href=\"http://www.facebook.com/sharer.php?u=".__BASE__."notas/".$R["sLink"]."/$subLink".$R["link"].".html\"><img src=\"img/icoFBsmall.png\" title=\"compartir en Facebook\" alt=\"compartir en Facebook\"></a> \n";
	echo "<a target=\"_blank\" href=\"http://twitter.com/intent/tweet?text=".textoContent($R["titulo"], 115)." ".__BASE__."notas/".$R["sLink"]."/$subLink".$R["link"].".html\" class=\"twitter\"><img src=\"img/icoTWsmall.png\" title=\"compartir en Twitter\" alt=\"compartir en Twitter\"></a> \n";
	echo "<g:plusone size=\"small\" annotation=\"none\" href=\"".__BASE__."notas/".$R["sLink"]."/$subLink".$R["link"].".html\"></g:plusone>\n";
	echo "</div>\n";
	
	echo "<div class=\"link\"><a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">leer+</a></div>\n";
	echo "<div class=\"clear\"></div>\n";
	echo "</div>\n";
	echo "<div class=\"img\">";
	
	$img=($R["Id"]>540 ? "th" : "").($R["img_2"] ? $R["img_2"] : $R["img_1"]);
	if ($img) {
		list($w, $h)=@getimagesize("sitio/jpg/$img");
		if ($w && $h)
			$h=round(205*$h/$w);
		else
			$h=114;
		
		echo "<a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\"><img src=\"sitio/jpg/$img\" width=\"205\" height=\"$h\" alt=\"".textoContent($R["titulo"])."\"></a>";
	}
	echo "</div>\n";
	echo "<div class=\"clear\"></div>\n";
	echo "</li>\n";
}
mysql_free_result($C);
echo "</ul>\n";
if ($cPag>1) {
	echo "<ul class=\"paginador\">";
	if ($pag>1)
		echo "<li class=\"puntas\"><a href=\"busqueda?q=".$_GET["q"].($pag>1 ? "&pag=".($pag-1) : "")."\">Pag. Anterior</a></li>\n";
	
	$pIni=$pag-4;
	if ($pIni<4) $pIni=1;
	
	$pFin=$pag+4;
	if ($pFin>$cPag-3) $pFin=$cPag;
	
	if ($pIni>1) {
		echo "<li><a href=\"busqueda?q=".$_GET["q"]."\">1</a></li>\n";
		echo "<li class=\"puntos\">...</li>\n";
	}
	
	for ($p=$pIni; $p<=$pFin; $p++) {
		echo "<li".($p==$pag ? " class=\"sel\"" : "")."><a href=\"busqueda?q=".$_GET["q"].($p>1 ? "&pag=$p" : "")."\">$p</a></li>\n";
	}
	
	if ($pFin<$cPag) {
		echo "<li class=\"puntos\">...</li>\n";
		echo "<li><a href=\"busqueda?q=".$_GET["q"]."&pag=$cPag\">$cPag</a></li>\n";
	}
	
	if ($pag<$cPag)
		echo "<li class=\"puntas\"><a href=\"busqueda?q=".$_GET["q"]."&pag=".($pag+1)."\">Pag. Siguiente</a></li>\n";
	
	echo "</ul>\n";
	echo "<div class=\"clear\"></div>\n";
}

if ($ini)
	echo "<p>No se encontraron notas.</p>\n<br><br><br><br>\n";

require_once __PATH_INC__."/footer.inc.php";
?>