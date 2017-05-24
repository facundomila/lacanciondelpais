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

echo "<div class=\"nota-img-head\"><img src=\"../sitio/jpg/".$Rc["img_1"]."\"></div>";
echo "<div class=\"logo-nota\"><img src=\"img/lcpd_conefecto_sinfondo.png\" style=\"width:84px;height:84px\"></div>";
echo "<div class=\"nota\"><h1>".$Rc["titulo"].($Rc["artista"] ? " � ".$Rc["artista"] : "").($_GET["preview"]=="-preview" ? " [preview]" : "")."</h1></div>\n";
echo "<div class=\"seccion-nota\">Audiovisuales</div>\n";
echo "<div class=\"compartir\">";
echo "<a target=\"_blank\" href=\"http://twitter.com/intent/tweet?text=".textoContent($Rc["titulo"], 115)." ".__BASE__."notas/".$Rs["link"]."/".$Rsub["link"].$Rc["link"].".html\" class=\"twitter\"><i class=\"fa fa-twitter-square\" aria-hidden=\"true\"></i></a>";
echo "<a target=\"_blank\" href=\"http://www.facebook.com/sharer.php?u=".__BASE__."notas/".$Rs["link"]."/".$Rsub["link"].$Rc["link"].".html\"><i class=\"fa fa-facebook\" aria-hidden=\"true\"></i></a></div>";
echo "<div class=\"fecha-nota\">".fechaLarga($Rc["fecha"])."</div>\n";
echo "<div class=\"content\">".trim($Rc["cuerpo"])."</div>\n";
?>

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
