<?php

if (!$home) echo "</div>\n<!-- fin cuerpoCaja -->\n\n";

$areas = ""; $puntos = "";
$sql = mysql_query("SELECT DISTINCT provincias.* FROM provincias, posts WHERE provincias.id = posts.provinciaID GROUP BY provincias.id ORDER BY provincias.id");

while($r = mysql_fetch_assoc($sql)) {
		$areas .="<area shape=\"poly\" coords=\"".$r['area']."\" href=\"notas/provincias/".$r['link']."/\" title=\"".$r['nombre']."\" >";
		$puntos .="<div style=\"position:absolute; top:".$r['coordY']."px; left:".$r['coordX']."px;\" ><a href=\"notas/provincias/".$r['link']."/\"><img src=\"img/punto.png\" title=\"".$r['nombre']."\" width=\"16\" height=\"15\" border=\"0\"></a></div>";
}
?>
</div>
<!-- fin cuerpoIzq -->

<div class="cuerpoDer">

<div style="margin-bottom: 25px;">
	<h2 style="color: #fff; text-align: center; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">MAPA MUSICAL DEL PA�S</h2>
<!-- mapa con puntos de posts provincias -->
<div id="mapa" style="padding: 5px 25px 19px;">
<img src="img/argentina.png" width="143" height="318" border="0" usemap="#Map">
<map name="Map">
	<?php echo $areas; ?>
</map>
<div id="puntos" style="position: relative; top: -329px; left: -10px;">
	<?php echo $puntos; ?>
</div>
</div>

<div id="publi1" class="publi">
<ul class="rotation">
<li><a target="_blank" href="http://www.mandrakelibros.com/"><img src="publicidad/mandrake.jpg" width="195" height="324" border="0" alt="Mandrake Libros"></a></li>
<li><a target="_blank" href="https://www.facebook.com/Puntoinquieto-Taller-de-Arte-920811171327178/"><img src="publicidad/punto-inquieto.jpg" width="195" height="324"  alt=""/></a></li>
</ul>
</div>
<!--
<div id="publi2" class="publi">
<a href="notas/literatura/poetas-del-pais/"><img src="img/banner-poetas-2.jpg" width="195" height="123"></a>
</div>
-->
<div id="publi3" class="publi">
<ul class="rotation">
<li><a target="_blank" href="https://www.facebook.com/elberlinnightclub"><img src="publicidad/berlin.jpg" width="195" height="324"  alt=""/></a></li>
<li><a target="_blank" href="https://www.facebook.com/pandorahostel"><img src="publicidad/la-casa-de-pandora-2016.jpg" width="195" height="324" border="0" alt="La Casa de Pandora	Hostel"/></a></li>

</ul>
</div>

<div class="formSuscripcion">
<form method="post" action="suscripcion.php">
<p>Suscribite a nuestros newsletters</p>
<p><input type="text" class="text" id="susEmail" name="susEmail" value="Email..." onfocus="if(this.value=='Email...') this.value='';" onblur="if(this.value=='') this.value='Email...'"></p>
<p><input type="button" class="btn" value="suscribirse" onclick="if (susCheck()) submit();"></p>
</form>
</div>

<?php
if (!$home) {
	echo "<div class=\"sideNotas\">\n\n";
	echo "<h2>�LTIMAS NOTAS</h2>\n\n<ul>";

	$C=mysql_query ("SELECT posts.Id, posts.link, seccionID, secciones.link AS sLink, secciones.seccion, subseccionID, titulo, bajada FROM posts, secciones WHERE secciones.id=seccionID ORDER BY fecha DESC, posts.Id DESC LIMIT 0, 6") or printf(mysql_error());
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
		if ($R["seccionID"]==2 && $subseccion)
			$st="<strong class=\"upper\">$subseccion:</strong> ";
		elseif ($R["seccionID"]!=6 && $R["seccion"])
			$st="<strong class=\"upper\">".$R["seccion"].":</strong> ";
		else
			$st="";

		echo "<li>\n";
		echo "<h3><a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">".$R["titulo"]."</a></h3>\n";
		echo "<p>$st".substr($R["bajada"],0,125)."...</p><p class=\"link\"><a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">leer+</a></p>\n";
		echo "</li>\n\n";
}
mysql_free_result($C);
	echo "</ul>\n</div>\n";
}
?>
</div>
<!-- fin cuerpoDer -->

<div class="clear"></div>
</div>
<!-- fin cuerpo -->

</div>
<!-- fin gral -->

<div class="bodyPie"></div>
</div>
<!-- fin body -->

</body>
</html>
