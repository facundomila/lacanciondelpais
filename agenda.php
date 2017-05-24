<?php
require_once "sistema.inc.php";
require_once __PATH_FUN__."imagenes.fun.php";
require_once __PATH_FUN__."tiempo.fun.php";
$imagenDir="agenda";
$titulo="Agenda";
$agenda=true;

$tipos=array();
$tipos2=array();
$C=mysql_query("SELECT * FROM agenda_tipos ORDER BY tipo");
while ($R=mysql_fetch_assoc($C)) {
	$tipos[$R["id"]]=$R["tipo"];
	if (!$R["inactivo"])
		$tipos2[$R["id"]]=$R["tipo"];
}
mysql_free_result($C);

$ok=false;
if (asp()) {
	if ($_PDB["url"]=="http://")
		$_PDB["url"]="";

	$img=imagenPost(__PATH_IMG__.$imagenDir.DS, "agenda_eventos", 0, "imagen", array(array("s" => "", "w" => 440, "h" => 330, "f" => 3), array("s" => "th", "w" => 220, "h" => 175, "f" => 3)));

	mysql_query("INSERT INTO agenda_eventos (tipoID, tipo, titulo, imagen, descripcion, lugar, direccion, url, nombre, email, relacionID, relacion) VALUES ('".$_PDB["tipoID"]."', '".$_PDB["tipo"]."', '".$_PDB["titulo"]."', '$img', '".$_PDB["descripcion"]."', '".$_PDB["lugar"]."', '".$_PDB["direccion"]."', '".$_PDB["url"]."', '".$_PDB["nombre"]."', '".$_PDB["email"]."', '".$_PDB["relacionID"]."', '".$_PDB["relacion"]."')");
	$eid=mysql_insert_id();
	foreach ($_POST as $var => $val) {
		if (substr($var, 0, 3)=="mes") {
			$id=substr($var, 3);
			$f=$_POST["mes$id"]."-".$_POST["dia$id"]." ".$_POST["hora$id"].":".$_POST["min$id"].":00";
			mysql_query("INSERT INTO agenda_fechas (eventoID, fecha) VALUES ($eid, '$f')");
		}
	}
	header("location: agenda.html?ok=1");
	exit;
}

require_once __PATH_INC__."header.inc.php";
?>

<div class="container">
	<div class="seccion-head">AGENDA</div>
</div>
<div class="container" style="max-width:1098px">
<?php
if (isset($_GET["ok"])) {
	echo "<div class=\"success-message-agenda\"><h3>Solicitud recibida</h3>\n";
	echo "<p>�Muchas gracias por colaborar con nuestra agenda!</p>\n";
	echo "<p>Muy pronto revisaremos tu solicitud y la publicaremos en esta secci�n.</p>\n";
	echo "<p><u><strong>ATENCI�N:</strong></u>En la agenda se muestran los eventos de los pr�ximos 7 d�as, si cargaste fechas posteriores se visualizar�n cuando falte una semana para el evento.</p>\n";
	echo "<p><a href=\"agenda.html\">&laquo; Volver a la agenda</a></div>\n";
}
else {
$diaAnt="";
$sMen="";
$txt="";
$C=mysql_query("SELECT agenda_eventos.*, fecha FROM agenda_fechas, agenda_eventos WHERE fecha>='".HOY."' AND fecha<='".gmdate("Y-m-d", mkTimeSQL(HOY)+604800)."' AND agenda_eventos.id=eventoID AND inactivo=1 ORDER BY fecha LIMIT 0, 40") or error();
while ($R=mysql_fetch_assoc($C)) {
	$dia=substr($R["fecha"], 0, 10);
	if ($diaAnt!=$dia) {
		$txt.="<div class=\"fecha-larga\">".dia($dia)." ".fechaLargaSinAno($dia)."</div>\n";
		$sMen.=" &bull; <a href=\"agenda.html#dia-$dia\">".dia($dia)."</a>";
		$diaAnt=$dia;
	}
	$preLink=($R["url"] ? "<a target=\"_blank\" href=\"".$R["url"]."\">" : "");
	$posLink=($R["url"] ? "</a>" : "");

	$txt.="<div class=\"item\">";
	$txt.="<div class=\"img\"><div class=\"img-filter\"></div>".($R["imagen"] ? "$preLink<img src=\"img/agenda/".$R["imagen"]."\">$posLink" : "")."</div>\n";
	$txt.="<div class=\"info\">";
	$txt.="<div class=\"titulo\">".($R["tipoID"] && isset($tipos[$R["tipoID"]]) ? "<span class=\"tipo\">".$tipos[$R["tipoID"]]."</span> | " : ($R["tipo"] ? "<span class=\"tipo\">".$R["tipo"]."</span> - " : "")).$preLink.$R["titulo"].$posLink."</div>\n";
	if ($R["descripcion"])
	$txt.="<div class=\"descripcion\">".nl2br($R["descripcion"])."</div>\n";
	$txt.="<div class=\"horario\">".hora($R["fecha"])." hs</div>\n";
	$txt.="<div class=\"lugar\">".($R["lugar"] || $R["direccion"] ? "".$R["lugar"].($R["lugar"] && $R["direccion"] ? ", " : "").$R["direccion"] : "").".</div>\n";
	$txt.="</div></div>\n";
	$txt.="<div class=\"agenda-clear\"></div>\n";
}
mysql_free_result($C);

$C=mysql_query("SELECT * FROM informacion WHERE Id=288");
if ($R=mysql_fetch_array($C)) {
	if (trim($R["contenido"]) && trim($R["contenido"])!="<p></p>") {
		$txt.="<h2 id=\"muestras-y-exposiciones\">Muestras y Exposiciones</h2>\n";
		$txt.="<br>\n";
		$txt.="<div class=\"item\">".$R["contenido"]."</div>\n";
		$sMen.=" &bull; <a href=\"agenda.html#muestras-y-exposiciones\">Muestras y Exposiciones</a>";
	}
}
mysql_free_result($C);

if ($sMen) {
	echo "<div class=\"agenda-menu\">".substr($sMen, 8)."</div>\n";
}
if ($txt) {
	echo "<div class=\"agenda\">$txt</div>\n";
}
else
	echo "<p>No hay eventos futuros en la agenda.</p><p>Volv&eacute; a consultarla en los pr&oacute;ximos d&iacute;as.</p>";
?>


<div id="agendaForm" class="form">
<h2>Agreg&aacute; tu evento:</h2>
<p>Complet&aacute; el siguiente formulario para agregar tu evento a nuestra agenda:</p>
<form method="post" action="agenda.html" enctype="multipart/form-data" onsubmit="return checkAgenda();">
<input type="hidden" id="asp" name="asp" value="<?php echo rand(100, 336); ?>">
<p><label for="tipoID">Tipo de evento*:</label><br><select class="texto" id="tipoID" name="tipoID" onchange="chTipo()">
<option value="">Seleccion&aacute; un tipo de evento...</option>
<?php
foreach ($tipos2 as $var => $val) {
	echo "<option value=\"$var\">$val</option>\n";
}
?>
<option value="0">Otro...</option>
</select><input class="texto" type="text" id="tipo" name="tipo" value="" maxlength="30" style="display: none; width: 65%;"> <input type="button" class="btn" id="tipoBtn" value="Reiniciar" onclick="resetTipo()" style="display: none;"></p>
<p><label for="titulo">T&iacute;tulo*:</label><br><input class="texto" type="text" id="titulo" name="titulo" value="" maxlength="100"></p>
<p><label for="imagen">Imagen*:</label><br><input class="texto2" type="file" id="imagen" name="imagen" value=""><br>&nbsp;&nbsp;S�LO IMAGEN SIN TEXTO. NO ENVIAR FLYERS.<br>&nbsp;&nbsp;La imagen debe ser formato jpg. M�ximo 2 MB. Ser� reescalada y cortada a 440px x 330px</p>
<p><label for="descripcion">Descripci&oacute;n / sinopsis breve / participantes*: (<span id="descripcionChar">300 caracteres disponibles</span>)</label><br><textarea class="texto" id="descripcion" name="descripcion" onkeyup="chText('descripcion', 300)"></textarea></p>
<p><label for="url">Link:</label><br><input class="texto" type="text" id="url" name="url" value="http://" maxlength="200"></p>
<p><label for="lugar">Lugar*:</label><br><input class="texto" type="text" id="lugar" name="lugar" value="" maxlength="50"></p>
<p><label for="direccion">Direcci&oacute;n*:</label><br><input class="texto" type="text" id="direccion" name="direccion" value="" maxlength="100"></p>
<div id="fechas">
<label for="Fecha:">Fecha*:</label>
<p id="f0" class="fec">
<select class="texto" id="mes0" name="mes0" style="width: 100px;" onchange="chMes(0)">
<option value="">Mes...</option>
<option value="<?php echo $ano1."-".($mes1<10 ? "0" : "").$mes1; ?>"><?php echo mes($mes1); ?></option>
<option value="<?php echo $ano2."-".($mes2<10 ? "0" : "").$mes2; ?>"><?php echo mes($mes2); ?></option>
</select> /
<select class="texto" id="dia0" name="dia0" style="width: 80px; text-align: right;">
<option value="">D&iacute;a...</option>
</select>
 -
<select class="texto" id="hora0" name="hora0" style="width: 95px; text-align: right;">
<option value="">Hora...</option>
<?php
for ($a=0; $a<24; $a++) {
	echo "<option value=\"".($a<10 ? "0" : "")."$a\">".($a<10 ? "0" : "")."$a</option>\n";
}
?>
</select>
 :
<select class="texto" id="min0" name="min0" style="width: 95px; text-align: right;">
<option value="">Minuto...</option>
<?php
for ($a=0; $a<60; $a+=5) {
	echo "<option value=\"".($a<10 ? "0" : "")."$a\">".($a<10 ? "0" : "")."$a</option>\n";
}
?>
</select> <input type="button" class="btn" value="Borrar" onclick="delFecha(0)" style="display: none">
</p>
</div>
<p class="right"><input class="btn" type="button" value="Agregar fecha..." onclick="addFecha();"></p>
<hr>
<h2>Datos de contacto</h2>
<p>La siguiente informaci&oacute;n no ser&aacute; publicada:</p>
<p><label for="nombre">Nombre*:</label><br><input class="texto" type="text" id="nombre" name="nombre" value="" maxlength="100"></p>
<p><label for="email">Email*:</label><br><input class="texto" type="text" id="email" name="email" value="" maxlength="60"></p>
<p><label for="relacionID">Relaci&oacute;n con el evento*:</label><br><select class="texto" id="relacionID" name="relacionID" onchange="chRel()">
<option value="">Seleccion&aacute; una opci&oacute;n...</option>
<?php
foreach ($agendaRels as $var => $val) {
	echo "<option value=\"$var\">$val</option>\n";
}
?>
</select><input class="texto" type="text" id="relacion" name="relacion" value="" maxlength="30" style="display: none; width: 65%;"> <input type="button" class="btn" id="relacionBtn" value="Reiniciar" onclick="resetRel()" style="display: none;"></p>
<p>* Datos obligatorios.</p>
<p class="right"><input class="btn" type="submit" value="Enviar"></p>
</form>
</div></div></div></div></div><div class="col-md-1"></div></div></div>

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
<?php
}
?>
</div>
