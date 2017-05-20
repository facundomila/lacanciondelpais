<style>
.nota-img-head {
	width: 100%;
	height: 350px;
	overflow: hidden;
	position: relative;
}
.nota-img-head img {
	width: 100%;
}
.nota-img-head .overlay {
	background-color: #265d8c;
	opacity: 0.3;
	width: 100%;
	height: 100%;
}
.logo-nota {
	margin: 35px 50%;
	position: relative;
	left:-50px;
}
.fecha-larga {
	color: #265d8c;
	font-weight: bolder;
	margin: auto;
	width: 300px;
	text-align: center;
}
.compartir h1 {
	color: #265d8c;
	font-weight: bolder;
	margin: 15px auto 35px;
	width: 500px;
	text-align: center;
	line-height: 24px;
	font-family: 'Titillium Web', sans-serif !important;
	font-size: 22px;
}
.nota h1 {
	color: #265d8c;
	font-weight: bolder;
	margin: 15px auto 35px;
	width: 500px;
	text-align: center;
	line-height: 24px;
	font-family: 'Titillium Web', sans-serif !important;
	font-size: 22px;
}
div.nota a:hover{
    color: red;
    text-decoration: none;
}
.content {
	margin: 0;
	width: 100%;
}
.content p{
	color: #265d8c;
	width: 80%;
	margin: 20px auto;
}
.content img.left{
	width: 90% !important;
	margin-right: 10%;
}
.content img.right{
	width: 90% !important;
	margin-left: 10%;
}
.show-comments-box {
	width: 80%;
	margin: 0 10%;
}
.show-comments-box .title{
	color: #265d8c;
    font-size: 24px;
}
.show-comments-box .each-comment{
	color: #333;
    font-size: 14px;
    background-color: #eee;
}
.show-comments-box .fecha{
	color: #333;
    font-size: 12px;
}
.show-comments-box .nombre{
	color: green;
    font-size: 12px;
}
.show-comments-box .comentario{
	color: red;
    font-size: 12px;
}
.nota-comment-box {
    width: 100%;
}
.nota-comment-box .title{
    color: #265d8c;
    font-size: 24px;
}
.nota-comment-title input{
    color: #333;
    font-size: 16px;
    padding: 8px;
}
.cabezal-parrafo{
		color: #265d8c;
  	font-size: 16px;
  	padding: 8px;
		letter-spacing: 5px;
		font-weight: bolder;
		border-bottom: 2px solid red;
		width: 80%;
		margin: 10%;
}
</style>

<?php
require_once "sistema.inc.php";
require_once __PATH_FUN__."tiempo.fun.php";
if (asp()) {
	$_PDB["comentario"]=strip_tags($_PDB["comentario"]);
	mysql_query("INSERT INTO comentarios (idpost, nombre, comentario, fecha) VALUES (".$_PDB["idpost"].", '".$_PDB["nombre"]."', '".$_PDB["comentario"]."', '".HOY."')");
	header("location: ".__BASE__."notas/".$_GET["sLink"].(isset($_GET["subLink"]) ? "/".$_GET["subLink"] : "")."/".$_GET["link"].".html#comentarios");
	exit;
}

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

if (isset($_GET["link"])) {
	$Cc=mysql_query("SELECT * FROM posts WHERE link='".$_GET["link"]."'".($_GET["preview"]=="-preview" ? "" : " AND inactivo=0")." AND seccionID=".$Rs["id"]." AND subseccionID=".$Rsub["id"]);
	if ($Rc=mysql_fetch_assoc($Cc)) {

	}
	else {
		header("location: ".__BASE__."notas/".$Rs["link"]."/".$Rsub["link"]);
		exit;
	}
	mysql_free_result($Cc);
}


$enlaceProvincia="";
$enlaceCiudad="";
if($Rc["provinciaID"]){
		$C3=mysql_query("SELECT * FROM provincias WHERE id=".$Rc["provinciaID"]."");
		if ($Pv=mysql_fetch_assoc($C3)) {
			$linkPv=$Pv["link"];
			$namePv=$Pv["nombre"];
			$enlaceProvincia = " / <a href=\"notas/provincias/".$linkPv."/\">$namePv</a> ";
			if($Rc["ciudad"]){
				$enlaceCiudad = " &raquo; <span>".$Rc["ciudad"]."</span>";
			}
		}
		mysql_free_result($C3);
	}


$titulo=$Rc["titulo"];
$ogTitulo=textoContent($Rc["titulo"]);
$descripcion=textoContent("La Canci�n del Pa�s. ".$Rc["bajada"]);
if ($Rc["img_1"])
	$ogImg="http://www.lacanciondelpais.com.ar/sitio/jpg/".$Rc["img_1"];

require_once __PATH_INC__."header.inc.php";

mysql_query("UPDATE posts SET contador=contador+1 WHERE id=".$Rc["Id"]);

echo "<div class=\"nota-img-head\"><img src=\"../sitio/jpg/".$Rc["img_1"]."\"><div class=\"overlay\"></div></div>";
echo "<div class=\"logo-nota\"><img src=\"img/lcpd_conefecto_sinfondo.png\" style=\"width:100px;height:100px\"></div>";
echo "<div class=\"fecha-larga\">".fechaLarga($Rc["fecha"])."<span class=\"notasSeccion\"> <br> <a href=\"notas/".$Rs["link"]."/\">".$Rs["seccion"]."</a>".($Rsub["subseccion"] ? " &raquo; <a href=\"notas/".$Rs["link"]."/".$Rsub["link"]."\">".$Rsub["subseccion"]."</a>" : "")."<span class=\"notasSeccion\">$enlaceProvincia$enlaceCiudad</span></span></div>\n";
echo "<div class=\"nota\"><h1>".$Rc["titulo"].($Rc["artista"] ? " � ".$Rc["artista"] : "").($_GET["preview"]=="-preview" ? " [preview]" : "")."</h1></div>\n";
echo "<div class=\"content\">".trim($Rc["cuerpo"])."</div>\n";

echo "<div class=\"compartir\"><h1>Te gustó la nota? Compartila!\n";
echo "<a target=\"_blank\" href=\"http://www.facebook.com/sharer.php?u=".__BASE__."notas/".$Rs["link"]."/".$Rsub["link"].$Rc["link"].".html\"><img src=\"img/icoFBsmall.png\" title=\"compartir en Facebook\" alt=\"compartir en Facebook\"></a> ";
echo "<a target=\"_blank\" href=\"http://twitter.com/intent/tweet?text=".textoContent($Rc["titulo"], 115)." ".__BASE__."notas/".$Rs["link"]."/".$Rsub["link"].$Rc["link"].".html\" class=\"twitter\"><img src=\"img/icoTWsmall.png\" title=\"compartir en Twitter\" alt=\"compartir en Twitter\"></a> ";
echo "<g:plusone size=\"small\" annotation=\"none\" href=\"".__BASE__."notas/".$Rs["link"]."/".$Rsub["link"].$Rc["link"].".html\"></g:plusone></div>\n";
?>

<div class="cabezal-parrafo">
	<img src="img/lcpd_conefecto_sinfondo.png" style="width:50px;height:50px;margin:7px">
	<p style="width:63%;float:right;text-align:right">ESCUCHA LA ENTREVISTA ENTEVISTA ENTERA EN NUESTRO CANAL DE YOUTUBE</p>
</div>

<div class="container">
	<?php
		include('components-ui/mas-notas.php');
	?>
</div>
<?php

$ini=true;
$C=mysql_query ("SELECT * FROM comentarios WHERE idpost=".$Rc["Id"]);
while ($R=mysql_fetch_array($C)) {
	if ($ini) {
		$ini=false;
		echo "<div class=\"clear\"></div><hr><div class=\"show-comments-box\"><div class\"title\">COMENTARIOS</div>\n";
	}
	echo "<div class=\"each-comment\">\n";
	echo "<div class=\"fecha\">".fechaLarga($R["fecha"])."</div>\n";
	echo "<div class=\"nombre\">".$R["nombre"].":</div>\n";
	echo "<div class=\"comentario\">".$R["comentario"]."</div>\n";
	echo "</div>\n";
}

mysql_free_result($C);

if (!$ini)
	echo "</div><div class=\"clear\"></div>\n";
?>
<div class="container" style="width:80%">
	<div class="nota-comment-box">
		<div class="title">DEJ� UN COMENTARIO</div>
		<form method="post" action="notas/<?php echo $Rs["link"]."/".$Rsub["link"].$Rc["link"]; ?>.html">
		<input type="hidden" id="asp" name="asp" value="<?php echo rand(100,333) ?>">
		<input type="hidden" id="idpost" name="idpost" value="<?php echo $Rc["Id"] ?>">
		<div class="name"><label for="nombre">Nombre:</label><br>
			<input type="text" class="texto" id="nombre" name="nombre" value=""></div>
		<div class="comment"><label for="comentario">Comentario:</label><br><textarea class="texto" id="comentario" name="comentario" cols="75" rows="5"></textarea></div>
		<div class="btn"><input type="button" class="btn" value="Enviar comentario" onclick="if (comCheck()) { this.disabled='disabled'; submit(); }"></div>
		</form>
	</div>
</div>

</div>

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
        <div class="col-md-2"><span style="font-size: 12px; color: #265d8c;">@ La Canci�n del Pa�s 2017</span></div>
        <div class="col-md-8"></div>
        <div class="col-md-1"></div>
    </div>
    </div>
	<div class="clear-big"></div>
	</div>
</div>
