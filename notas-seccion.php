<style>

.seccion-box {
	width: 100%;
}
.seccion-box .head{
	border: 1px solid red;
    font-size: 18px;
    padding: 8px;
    width: 100%;
    display: inline-block;
    color: #265d8c;
    text-align: center;
		margin-bottom: 20px;
}
.seccion-box .content{

}
.seccion-box .fecha-larga{
	width: 100%;
	color: #fff;
    font-size: 14px;
    font-weight: bolder;
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ff0072+0,ff0000+100 */
	background: #ff0072; /* Old browsers */
	background: -moz-linear-gradient(left,  #ff0072 0%, #ff0000 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(left,  #ff0072 0%,#ff0000 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to right,  #ff0072 0%,#ff0000 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff0072', endColorstr='#ff0000',GradientType=1 ); /* IE6-9 */
}
</style>

<div class="container-fluid" style="padding:0">
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<div class="w3-main">
  <!-- Photo grid (modal) -->

<?php
require_once "sistema.inc.php";
require_once __PATH_FUN__."tiempo.fun.php";

if (isset($_GET["sLink"])) {
	$Cs=mysql_query("SELECT * FROM secciones WHERE link='".$_GET["sLink"]."' AND inactivo=0");
	if ($Rs=mysql_fetch_assoc($Cs)) {
		$sID=$Rs["id"];
		if (isset($_GET["subLink"])) {
			$Csub=mysql_query("SELECT * FROM subsecciones WHERE link='".$_GET["subLink"]."' AND inactivo=0");
			if ($Rsub=mysql_fetch_assoc($Csub)) {
				$Rsub["link"].="/";
				$subID=$Rsub["id"];
			}
			else {
				header("location: ".__BASE__."notas/".$Rs["link"]."/");
				exit;
			}
			mysql_free_result($Csub);
		}
		else {
			$Rsub["id"]=0;
			$Rsub["link"]="";
			$Rsub["subseccion"]="";
		}
	}
	mysql_free_result($Cs);
}
else {
	header("location: ".__BASE__);
	exit;
}

$titulo=$Rs["seccion"].($Rsub["subseccion"] ? " | ".$Rsub["subseccion"] : "");
$descripcion=textoContent("Secci�n de notas de 'La Canci�n del Pa�s', web de M�sica, Literatura, Arte, Audiovisuales, Escenicas.");

require_once __PATH_INC__."header.inc.php";

echo "<div class=\"container\" style=\"width:100%;margin:15px 0 0 0\">
		<div class=\"row\">
    	<div class=\"col-md-1\"></div>
    	<div class=\"col-md-10\">
			<div class=\"seccion-box\"><div class=\"head\">".$Rs["seccion"].($Rsub["subseccion"] ? " � ".$Rsub["subseccion"] : "")."</div>\n";

$subLink="";
$subseccion="";
$ini=true;

$fil=($subID==2 ? " OR img_2<>''" : "");

$C=mysql_query("SELECT COUNT(*) AS cant FROM posts WHERE inactivo=0 AND ((seccionID=".$Rs["id"].($Rsub["id"] ? " AND subseccionID=".$Rsub["id"] : "").")$fil)");
if ($R=mysql_fetch_assoc($C))
	$cant=(int)$R["cant"];
else
	$cant=0;

mysql_free_result($C);

$cxp=15;
$cPag=ceil($cant/$cxp);
$pag=(isset($_GET["pag"]) ? $_GET["pag"] : $cPag);
if ($pag>$cPag) $pag=$cPag;
if ($pag<1)	$pag=1;
$ppp=($pag-1)*$cxp;

if ($pag==$cPag)
	$sql="SELECT Id, link, subseccionID, provinciaID, ciudad, fecha, titulo, bajada, artista, img_1, img_2 FROM posts WHERE inactivo=0 AND ((seccionID=".$Rs["id"].($Rsub["id"] ? " AND subseccionID=".$Rsub["id"] : "").")$fil) ORDER BY fecha DESC, Id DESC LIMIT 0, $cxp";
else
	$sql="SELECT * FROM (SELECT Id, link, subseccionID, ciudad, provinciaID, fecha, titulo, bajada, artista, img_1, img_2 FROM posts WHERE inactivo=0 AND ((seccionID=".$Rs["id"].($Rsub["id"] ? " AND subseccionID=".$Rsub["id"] : "").")$fil) ORDER BY fecha, Id LIMIT $ppp, $cxp) AS t ORDER BY fecha DESC, Id DESC";

$C=mysql_query($sql);
while ($R=mysql_fetch_assoc($C)) {
	$ini=false;
	$subLink="";
	$subseccion="";
	if ($R["subseccionID"]) {
		$C2=mysql_query("SELECT * FROM subsecciones WHERE id=".$R["subseccionID"]." AND inactivo=0");
		if ($R2=mysql_fetch_assoc($C2)) {
			$subseccion=$R2["subseccion"];
			$subLink=$R2["link"]."/";
		}

	}
	mysql_free_result($C2);
	$enlaceProvincia ="";
	$enlaceCiudad ="";
	if($R["provinciaID"]){
		$C3=mysql_query("SELECT * FROM provincias WHERE id=".$R["provinciaID"]."");
		if ($Pv=mysql_fetch_assoc($C3)) {
			$linkPv=$Pv["link"];
			$namePv=$Pv["nombre"];
			$enlaceProvincia = " / <a href=\"notas/provincias/".$linkPv."/\">".$namePv."</a> ";
			if($R["ciudad"]){
				$enlaceCiudad = "&raquo; <span>".$R["ciudad"]."</span>";
			}
		}

	}
	mysql_free_result($C3);
//echo "<script>console.log('".$linkPv."');</script>";

	$img=(($subID==2 && $R["img_2"]) || $R["img_1"]=="" ? $R["img_2"] : $R["img_1"]);
	if ($R["Id"]>540 && $subID!=2) $img="th$img";
	if ($img) {
		list($w, $h)=@getimagesize("sitio/jpg/$img");
		if ($w && $h)
			$h=round(205*$h/$w);
		else
			$h=114;

		echo "<div class=\"w3-third\"><div class=\"\"><img src=\"sitio/jpg/$img\" height=\"360px\" alt=\"".textoContent($R["titulo"])."\">";

		echo "<div class=\"overlay\"><div class=\"third-text-content\">";

		echo "<div class=\"fecha\">".fechaLarga($R["fecha"])."<span class=\"upper\">".(!$Rsub["id"] && $R["subseccionID"] ? " / <a href=\"notas/".$Rs["link"]."/$subLink\">$subseccion</a>": "").$enlaceProvincia.$enlaceCiudad."</span></div>\n";

		echo "<div class=\"txt\">".$R["bajada"]."</div>\n";

		echo "<div class=\"social\">";
		echo "<a target=\"_blank\" href=\"http://www.facebook.com/sharer.php?u=".__BASE__."notas/".$Rs["link"]."/$subLink".$R["link"].".html\"><img src=\"img/icoFBsmall.png\" title=\"compartir en Facebook\" alt=\"compartir en Facebook\"></a> \n";
		echo "<a target=\"_blank\" href=\"http://twitter.com/intent/tweet?text=".textoContent($R["titulo"], 115)." ".__BASE__."notas/".$Rs["link"]."/$subLink".$R["link"].".html\" class=\"twitter\"><img src=\"img/icoTWsmall.png\" title=\"compartir en Twitter\" alt=\"compartir en Twitter\"></a> \n";
		echo "<g:plusone size=\"small\" annotation=\"none\" href=\"".__BASE__."notas/".$Rs["link"]."/$subLink".$R["link"].".html\"></g:plusone>\n";
		echo "</div>\n";

		echo "<div class=\"link\"><a href=\"notas/".$Rs["link"]."/$subLink".$R["link"].".html\">leer+</a></div>\n";
		echo "</div></div><div class=\"clear\"></div>\n";
		echo "</div></div>\n";
	}
}
?>
</div></div></div><div class="col-md-1"></div></div>
<!-- componente footer -->
<div class="container-fluid" style="background-color: #eee">
<div class="container" style="width:80%">
	<div class="clear-big"></div>
	<div class="container-fluid">
	<?php
		include 'components-ui/header-footer.php';
	?>
	<div class="clear-big"></div>
	<div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-2"><span style="font-size: 12px; color: #265d8c;">@ La Canción del País 2017</span></div>
        <div class="col-md-8"></div>
        <div class="col-md-1"></div>
    </div>
    </div>
	<div class="clear-big"></div>
	</div>
</div>
