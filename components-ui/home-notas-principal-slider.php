<style>
    .mySlides {
        position:relative;
        display: active !important;
        align-content: center;
    }
    .text {
        position: absolute;
        top: 80px;
        left: 20%;
        color: #fff;
        width: 60%;
        height: 200px;
        text-align: center;
    }
    .text a:hover{
         text-decoration: none;
     }
    .sec {
       position: relative;
       width: 100%;
       margin-top: 30px;
       font-family: 'Fjalla One', sans-serif;
       color: #fff;
       letter-spacing: 3px;
       text-transform: uppercase;
       font-size: 18px;
       text-align: center;
       z-index: 1000;
    }
    .tit{
        font-family: 'Fjalla One', sans-serif;
        position: relative;
        text-transform: uppercase;
        letter-spacing: 3px;
        width: 100%;
        margin-top: 24px;
        color: #fff;
        font-size: 36px;
        text-align: center;
        z-index: 1000;
    }
    div.logo-slider {
        width: 100%;
        height: 100px;
        position: relative;
        left: -42px;
    }
    div.logo-slider img {
        width: 84px;
        height: 84px;
        position: absolute;
    }
    .mySlides .filter {
       position:absolute;
       background-color: #265d8c;
       opacity: 0.4;
       width: 100%;
       height: 100%;
       z-index: 1000;
    }
    .slideshow-container {
      overflow: hidden;
      margin: 0 auto;
      padding: 0;
      width: 100%;
      height: 465px;
      position: relative;
      -webkit-box-shadow: inset 0px 0px 126px -2px rgba(0,0,0,0.75);
      -moz-box-shadow: inset 0px 0px 126px -2px rgba(0,0,0,0.75);
      box-shadow: inset 0px 0px 126px -2px rgba(0,0,0,0.75);
    }
    .numbertext {
      font-family: 'Fjalla One', sans-serif;
      color: #f2f2f2;
      font-size: 12px;
      padding: 8px 12px;
      position: absolute;
      top: 0;
    }
    .dot {
      height: 10px;
      width: 10px;
      margin: 0 2px;
      background-color: #fff;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
    }
    .active {
      background-color: red;
    }
    /* Fading animation */
    .fade {
      opacity: 1;
      -webkit-animation-name: fade;
      -webkit-animation-duration: 1.5s;
      animation-name: fade;
      animation-duration: 1.5s;
    }

    @-webkit-keyframes fade {
      from {opacity: .4}
      to {opacity: 1}
    }

    @keyframes fade {
      from {opacity: .4}
      to {opacity: 1}
    }

    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {
      .text {font-size: 11px}
    }
</style>

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
<div style="text-align:center; position: relative; top: -75px; z-index:2000">
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
