<?php
require_once "sistema.inc.php";
require_once __PATH_FUN__."tiempo.fun.php";
$home=true;
$ogTitulo="La Canci�n del Pa�s";
require_once __PATH_INC__."header.inc.php";

$Ch=mysql_query("SELECT * FROM home");
if ($Rh=mysql_fetch_assoc($Ch)) {

}
mysql_free_result($Ch);
$fil="posts.Id<>".$Rh["principal"]." AND posts.Id<>".$Rh["destacada1"]." AND posts.Id<>".$Rh["destacada2"]." AND posts.Id<>".$Rh["info1"]." AND posts.Id<>".$Rh["info2"]." AND posts.Id<>".$Rh["info3"];
$cNotas=($Rh["principal"] ? 3 : 6);
?>

<div class="clear"></div>

<!-- componente home notas principal slider -->
<div class="container-fluid" style="padding: 0px">
	<?php
		require_once('components-ui/home-notas-principal-slider.php');
	?>
</div>

<div class="container">
	<div class="agenda-link">
		<div class="titulo-agenda">AGENDA CULTURAL ROSARIO</div>
		<div class="inner">ENTRA Y ENTERATE DE TODO LO QUE PASA EN LA CIUDAD</div>
		<a class="btn" href="agenda.html">ENTRAR</a>
	</div>
</div>

<!-- componente notas destacadas -->
<div class="container">
	<?php
		include('components-ui/mas-notas.php');
	?>
</div>

<div class="container">
	<div class="ad-one">espacio publicitario</div>
</div>

<!-- componente mas notas -->
<div class="container">
	<?php
		include('components-ui/mas-notas.php');
	?>
</div>

<div class="container">
	<div class="ad-one">espacio publicitario</div>
</div>

<!-- componente discos -->
<div class="container">
	<?php
		include('components-ui/mas-notas.php');
	?>
</div>
<div class="clear-big"></div>
<!-- componente footer -->
<div class="container-fluid" style="background-color: #eee">
<div class="container" style="width:90%">
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
