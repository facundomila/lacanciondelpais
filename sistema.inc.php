<?php
//$debug=true;
//Debug Mode:
if (isset($debug)) {
	error_reporting(E_ALL);
	define("DEBUG", true);
}
else {
	error_reporting(0);
	define("DEBUG", false);
}

//Set Path:
define("DS", DIRECTORY_SEPARATOR);
$dn=explode(DS, dirname(__FILE__));
define("__PATH__", join(DS, $dn).DS);

define("__PATH_INC__", __PATH__."inc".DS);
define("__PATH_FUN__", __PATH__."fun".DS);
define("__PATH_IMG__", __PATH__."img".DS);
define("__PATH_IMG2__", __PATH__."sitio".DS."jpg".DS);
define("__PATH_ARCH__", __PATH__."archivos".DS);
define("__PATH_MAILER__", __PATH__."phpmailer".DS);
define("__PATH_ADMIN__", __PATH__."_admin".DS);
define("__PATH_MU__", __PATH_ADMIN__."multiupload".DS);
define("__PATH_MU_BUFFER__", __PATH_MU__."buffer".DS);

//Seteos de tiempo:
define("HUSO", -3);
define("AHORA", gmdate("Y-m-d H:i:s", time()+HUSO*3600));
define("HOY", substr(AHORA, 0, 10));

//Seteos de base de datos y carpeta base:
if ($_SERVER["HTTP_HOST"]=="localhost" || $_SERVER["HTTP_HOST"]=="pcd") {
	define ("__CARPETA__", "lacanciondelpais.com.ar/");

	mysql_connect("localhost", "root", "");
	mysql_select_db("cancion_dualaq");
}
else {
	define("__CARPETA__", "");

	mysql_connect("localhost", "cancion_perry", "perry");
	mysql_select_db("cancion_dualaq");
}
define("__MINIBASE_IMG__", "img/");
define("__MINIBASE_IMG2__", "sitio/jpg/");
define("__MINIBASE_ARCH__", "archivos/");
define("__MINIBASE_CKE__", "ckeditor/");
define("__MINIBASE_JS__", "js/");
define("__MINIBASE_FONTS__", "fonts/");
define("__MINIBASE_ADMIN__", "admin/");

define("__BASE__", "http://".$_SERVER["HTTP_HOST"]."/".__CARPETA__);

define("__BASE_IMG__", __BASE__.__MINIBASE_IMG__);
define("__BASE_IMG2__", __BASE__.__MINIBASE_IMG2__);
define("__BASE_ARCH__", __BASE__.__MINIBASE_ARCH__);
define("__BASE_CKE__", __BASE__.__MINIBASE_CKE__);
define("__BASE_JS__", __BASE__.__MINIBASE_JS__);
define("__BASE_FONTS__", __BASE__.__MINIBASE_FONTS__);
define("__BASE_ADMIN__", __BASE__.__MINIBASE_ADMIN__);
define("__BASE_MU__", __BASE_ADMIN__."multiupload/");
define("__BASE_FA__", "http://www.digiloc.com.ar/_new/fa/");

//Seteos del sitio web.
define("SITIO_NOMBRE", "La Canci�n del Pa�s");
define("SITIO_EMAIL", "	deushuaiaalaquiaca@yahoo.com.ar");
define("SITIO_EMAIL_NR", "noreply@lacanciondelpais.com.ar");

define("SITIO_DESARROLLO", "Polisemic");
define("SITIO_DESARROLLO_URL", "http://www.polisemic.com/");

define("ADMIN_NOMBRE", "Administrador Web");

define("HOME_URL", "./");

define("IMG_CALIDAD", 100);

define("IDIOMA", "es");

define("OG_IMG_DEFAULT", __BASE_IMG__.".jpg");

define("GOOGLE_ANALYTICS_CODE", "UA-42083338-1");
define("GOOGLE_ANALYTICS_DOMAIN", "lacanciondelpais.com.ar");
define("FB_APP_ID", "151918994843167");

define("MAILING_LISTAS", false);

require_once __PATH_FUN__."sistema.fun.php";

list($_POST, $_PDB, $_PF)=adaptar($_POST, false);
list($_GET, $_GDB, $_GF)=adaptar($_GET, false);

$titulo="";
$descripcion="M�sica, literatura, arte, audiovisuales, esc�nicas, agenda cultural. Entrevistas, cr�ticas, columnas, informaci�n.";
$claves="Rosario, M�sica, Literatura, Arte, Audiovisuales, Artes Esc�nicas, Agenda cultural, Entrevistas, Cr�ticas, Columnas, Informaci�n.";

$ogTitulo="";
$ogImg="";

$home=false;
$agenda=false;
$contacto=false;
$sID=0;
$subID=0;

$provincias=array(1 => "Buenos Aires", 2 => "Catamarca", 3 => "Chaco", 4 => "Chubut", 5 => "Ciudad Aut�noma de Buenos Aires", 6 => "C�rdoba", 7 => "Corrientes", 8 => "Entre R�os", 9 => "Formosa", 10 => "Jujuy", 11 => "La Pampa", 12 => "La Rioja", 13 => "Mendoza", 14 => "Misiones", 15 => "Neuquen", 16 => "R�o Negro", 17 => "Salta", 18 => "San Juan", 19 => "San Luis", 20 => "Santa Cruz", 21 => "Santa Fe", 22 => "Santiago del Estero", 23 => "Tierra del Fuego", 24 => "Tucum�n");

$agendaRels=array(1 => "Encargado de prensa", 2 => "Productor", 3 => "Director", 4 => "Integrante del elenco", 5 => "Colaborador", 0 => "Otra...");
?>
