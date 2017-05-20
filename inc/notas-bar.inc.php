<?php
echo "<div class=\"notasBar\">\n<ul class=\"bar\">\n";
$ini=true;
$C=mysql_query("SELECT  * FROM subsecciones WHERE seccionID=".$Rs["id"]." ORDER BY orden");
while ($R=mysql_fetch_assoc($C)) {
	if ($ini) $ini=false; else echo "<li>·</li>\n";
	echo "<li".($subID==$R["id"] ? " class=\"sel\"": "")."><a href=\"notas/".$Rs["link"]."/".$R["link"]."/\">".$R["subseccion"]."</a></li>\n";
}
mysql_fetch_assoc($C);
echo "</ul>\n";
echo "</div>\n";
echo "<div class=\"clear\"></div>\n";
echo "<br>\n";
?>