<div class="slideshow-container">
<?php
if ($Rh["principal"]) {
	$C=mysql_query ("SELECT posts.Id, posts.link, seccionID, secciones.link AS sLink, secciones.seccion, subseccionID, titulo, bajada, img_1 FROM posts, secciones WHERE posts.Id=".$Rh["principal"]." AND secciones.id=seccionID AND img_1<>''") or printf(mysql_error());
	if ($R=mysql_fetch_assoc($C)) {
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
		if (($R["seccionID"]==2 || $R["seccionID"]==3) && $subseccion)
			$st="<strong class=\"upper\">$subseccion</strong> ";
		elseif ($R["seccionID"]==6)
			$st="";
		else
			$st="<strong class=\"upper\">".$R["seccion"]."</strong> ";

		echo "<div class=\"mySlides fade\">
					<img src=\"sitio/jpg/".$R["img_1"]."\" style=\"width:100%;\">
					<div class=\"text\">
					<div class=\"logo-slider\"><img src=\"img/lcpd_conefecto_sinfondo.png\"></div>
					    <a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">
						<div class=\"tit\">".$R["titulo"]."</div>
						<div class=\"sec\">$st</div>
						</a>
					</div></div>\n";
	}
	mysql_free_result($C);

}
$C=mysql_query ("SELECT posts.Id, posts.link, seccionID, secciones.link AS sLink, secciones.seccion, subseccionID, titulo, bajada, img_1 FROM posts, secciones WHERE home='si' AND noSlide=0 AND secciones.id=seccionID AND img_1<>'' AND $fil ORDER BY fecha DESC LIMIT 0, $cNotas") or printf(mysql_error());
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
	if (($R["seccionID"]==2 || $R["seccionID"]==3) && $subseccion)
		$st="<strong class=\"upper\">$subseccion</strong> ";
	elseif ($R["seccionID"]==6)
		$st="";
	else
		$st="<strong class=\"upper\">".$R["seccion"]."</strong> ";

	echo "<div class=\"mySlides fade\">
				<img src=\"sitio/jpg/".$R["img_1"]."\" style=\"width:100%;\">
				<div class=\"text\">
				<div class=\"logo-slider\"><img src=\"img/lcpd_conefecto_sinfondo.png\"></div>
				<a href=\"notas/".$R["sLink"]."/$subLink".$R["link"].".html\">
					<div class=\"tit\">".$R["titulo"]."</div>
					<div class=\"sec\">$st</div>
				</a></div></div>\n";

	$fil.=" AND posts.Id<>".$R["Id"];
}
mysql_free_result($C);
?>
</div>
<br>
<div class="circulos">
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
</div>


<script>
var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 6000); // Change image every 2 seconds
}
</script>
