<!DOCTYPE HTML>
<html><head>
<base href="<?php echo __BASE__ ?>">
<meta charset="iso-8859-1">
<title><?php echo ($titulo ? "$titulo | " : ""); ?>La Canción del País</title>
<meta property="og:url" content="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo (isset($ogTitulo) ? $ogTitulo : ($titulo ? $titulo : "La Canción del País")); ?>">
<?php
if (isset($descripcion)) {
?>
<meta property="og:description" content="<?php echo $descripcion; ?>">
<meta name="description" content="<?php echo $descripcion; ?>">
<?php
}
if (isset($ogImg)) {
?>
<meta property="og:image" content="<?php echo $ogImg; ?>">
<?php
}
?>
<link type="text/css" rel="stylesheet" href="fa/fa.css">
<link href='http://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link type="text/css" rel="stylesheet" href="estilo2015-2.css?<?php echo rand(111111,999999999999); ?>">
<link type="text/css" rel="stylesheet" href="slider_nuevo/css/skitter.styles.css">

<script type="text/javascript" src="js/jq.js"></script>
<script type="text/javascript" src="js/jq-swfo.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/rotation.js"></script>
<?php
if (isset($home)) {
?>
<script type="text/javascript" language="javascript" src="slider_nuevo/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" language="javascript" src="slider_nuevo/js/jquery.animate-colors-min.js"></script>
<script type="text/javascript" language="javascript" src="slider_nuevo/js/jquery.skitter.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('.box_skitter_large').skitter({
		theme: 'minimalist',
		numbers_align: 'right',
		progressbar: false, 
		dots: true, 
		interval: 2500,
		preview: false
	});
});
</script>
<?php
}
?>
<script type="text/javascript">

var v=new Image();
v.src='img/agendaOv.png';

$(document).ready(function() {
	//$('div#publi1').flash({ swf: 'publicidad/publicidades.swf', width: 195, height: 324, flashvars: { }, params: { wmode: 'transparent'} });
	//$('div#publi2').flash({ swf: 'publicidad/audio_bajopubli.swf', width: 195, height: 80, flashvars: { }, params: { wmode: 'transparent'} });
	//$('div#publi3').flash({ swf: 'http://www.ivoox.com/playeriVoox_em_73360_1.html', width: 195, height: 250, flashvars: { }, params: { movie: 'http://www.ivoox.com/playeriVoox_em_73360_1.html', allowFullScreen: 'true',  wmode: 'transparent', allowFullScreen: 'always'} });
});

window.___gcfg = {lang: "es"};
(function() {
	var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
	po.src = "https://apis.google.com/js/plusone.js";
	var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
})();

<?php
if (GOOGLE_ANALYTICS_CODE) {
?>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', '<?php echo GOOGLE_ANALYTICS_CODE; ?>', '<?php echo GOOGLE_ANALYTICS_DOMAIN; ?>');
ga('send', 'pageview');

<?php
}
?>
</script>
</head>
<body>
<div class="body">

<div class="gral">

<div class="header">
<div class="headerEncabezado"><a href="./"><img src="img/logo2015.png" width="350" height="65" alt="La Canción del País"></a></div>
<div class="headerBuscador">

<ul id="socialLinks">
<li><a target="_blank" href="https://www.facebook.com/profile.php?id=100000182077268"><i class="fa fa-facebook"></i></a></li>
<li><a target="_blank" href="http://twitter.com/canciondelpais"><i class="fa fa-twitter"></i></a></li>
</ul>

<form method="get" action="busqueda" onsubmit="return qCheck();">
<p><input type="text" id="q" name="q" value="<?php echo (isset($_GF["q"]) ? $_GF["q"] : "Buscar..."); ?>" onblur="if(this.value=='') this.value='Buscar...'" onfocus="if(this.value=='Buscar...') this.value='';"></p>
</form>

<div class="escuchanos"><a target="_blank" href="http://nubroadcast.com.ar/universidad/"><span class="sup">Escuchanos de lunes a viernes, de 15 a 16 hs.</span><br>en FM 103.3 / Radio Universidad</a></div>

</div>
<div class="clear"></div>
</div>
<!-- fin header -->

<div class="cuerpo">
<div class="menu">
<ul>
<?php
echo "<li".($home ? " class=\"sel\"" : "")."><a href=\"./\">Inicio</a></li>\n";

$C=mysql_query("SELECT * FROM secciones WHERE inactivo=0 ORDER BY orden");
while ($R=mysql_fetch_assoc($C)) {
	echo "<li".($R["id"]==$sID ? " class=\"sel\"" : "")."><a href=\"notas/".$R["link"]."/\">".$R["seccion"]."</a></li>\n";
}
mysql_free_result($C);
echo "<li".($contacto ? " class=\"sel\"" : "")."><a href=\"contacto.html\">Contacto</a></li>\n";

echo "<li class=\"agenda".($agenda ? " sel" : "")."\"><a href=\"agenda.html\"> <i class=\"fa fa-calendar\"></i> &nbsp;Agenda</a></li>\n";
?>
</ul>
</div>

<div class="cuerpoIzq">
<?php if (!$home) echo "<div class=\"cuerpoCaja\">\n"; ?>
