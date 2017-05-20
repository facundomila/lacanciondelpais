<!DOCTYPE HTML>
<html><head>
<base href="<?php echo __BASE__ ?>">
<meta charset="character_set">
<title><?php echo ($titulo ? "$titulo | " : ""); ?>La Canci�n del Pa�s</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:url" content="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo (isset($ogTitulo) ? $ogTitulo : ($titulo ? $titulo : "La Canci�n del Pa�s")); ?>">
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
<!--librerias css-->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

<!--fuentes css-->
<link type="text/css" rel="stylesheet" href="fa/fa.css">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>

<link type="text/css" rel="stylesheet" href="slider_nuevo/css/skitter.styles.css">

<!-- LCDP styles -->
<link type="text/css" rel="stylesheet" href="css/lcdp-styles.css">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="bootstrap/js/jquery-3.1.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<script type="text/javascript" src="js/jq.js"></script>
<script type="text/javascript" src="js/jq-swfo.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/rotation-5.js<?php echo "?".rand(11111111,99999999); ?>"></script>

<?php
if (isset($home)) {
?>
<?php
}
?>
<script type="text/javascript">

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
	<div class="container" style="width: 80%; margin-top:15px">
			<?php
				include './components-ui/header-footer.php';
			?>
	</div>
