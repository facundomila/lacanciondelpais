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
