<?php
function archivoAdmin($carpeta, $default="", $campo="Archivo", $aclara="") {
	$txt="";
	if ($default) {
		if (substr($carpeta,-1)=="/")
			$carpeta=substr($carpeta, 0, -1);
		
		$txt.="<a target=\"_blank\" href=\"$carpeta/$default\">$default</a><br />";
		$txt.="<div id=\"divBorrar$campo\">";
		$txt.="<input type=\"checkbox\" id=\"bor$campo\" name=\"bor$campo\" /> Borrar<br />";
		$txt.="<input type=\"button\" class=\"btn\" value=\"Reemplazar\" onclick=\"fileReemplazar('$campo')\" />";
		$txt.="</div>";
		
		$txt.="<div id=\"divReemplazar$campo\" style=\"display: none\">";
		$txt.="<input type=\"file\" id=\"$campo\" name=\"$campo\" size=\"55\" /><br />";
		$txt.=($aclara ? "$aclara<br />" : "");
		$txt.="<input type=\"button\" class=\"btn\" value=\"No reemplazar\" onclick=\"fileNoReemplazar('$campo')\" />";
		$txt.="</div>";
	}
	else {
		$txt.="<input type=\"file\" class=\"Texto\" id=\"$campo\" name=\"$campo\" size=\"55\" /><br />";
		$txt.="<input type=\"button\" class=\"btnCh\" value=\"Limpiar\" onclick=\"fileLimpiar('$campo')\" />";
		$txt.=($aclara ? "<br />$aclara" : "");
	}
	return $txt;
}

function archivoPost($carpeta, $tabla, $id=0, $campo="Archivo", $campoTam="ArchivoTam", $campoDB=NULL) {
	
	if (!$campoDB)
		$campoDB=$campo;
	
	$abort=false;
	$update=($id!=0);
	$save=false;
	$n=($update ? "" : "''".($campoTam ? ", 0" : ""));
	
	if (substr($carpeta, -1)=="/")
		$carpeta=substr($carpeta, 0, -1);
	
	//Detecta archivo subido:
	$arcUpload=(isset($_FILES[$campo]) ? ((int)$_FILES[$campo]["size"]>0 ? true : false) : false);
	
	if ($update && ($arcUpload || isset($_POST["bor$campo"]))) {
		//Si existe el registro y se sube uno nuevo o se marcó el campo borrar, se borra el anterior:
		$n='';
		$C=mysql_query("SELECT $campoDB FROM $tabla WHERE id=$id") or dbError();
		if ($R=mysql_fetch_array($C)) {
			if ($R[$campoDB]) {
				archivoBorrar($carpeta, $R[$campoDB]);
				$n=", $campoDB=''".($campoTam ? ", $campoTam=0" : "");
			}
		}
		else
			$abort=true;
		
		mysql_free_result($C);
	}
		
	if (!$abort && $arcUpload) {
		$nom=explode(".", $_FILES[$campo]["name"]);
		$ext=".".$nom[count($nom)-1];
		unset($nom[count($nom)-1]);
		$nombreOr=unixName(implode(".", $nom));
		
		$bytes=$_FILES[$campo]["size"];
		$nombre=$nombreOr;
		$num=1;
		while (file_exists("$carpeta/$nombre$ext")) {
			$num++;
			$nombre="$nombreOr-$num";
			
		}
		$nombre.=$ext;
		
		if (!move_uploaded_file($_FILES[$campo]["tmp_name"], "$carpeta/$nombre"))
			$save=false;
		else
			$save=true;
			
		if ($save)
			$n=($update ? ", $campoDB='$nombre'".($campoTam ? ", $campoTam=$bytes" : "") : "'$nombre'".($campoTam ? ", $bytes" : ""));
	}
	
	return $n;
}
function archivoBorrar($carpeta, $archivo) {
	$r=false;
	if ($archivo) {
		if (substr($carpeta, -1)=="/")
			$carpeta=substr($carpeta, 0, -1);
		
		if (file_exists("$carpeta/$archivo")) {
			unlink("$carpeta/$archivo");
			$r=true;
		}
	}
	return $r;
}
function archivoTam($bytes) {
	if ((int)$bytes<1024)
		return "$bytes Bytes";
	elseif ((int)$bytes<1048576)
		return number_format($bytes/1024, 2)." KBytes";
	elseif ((int)$bytes<1073741824)
		return number_format($bytes/1048576, 2)." MBytes";
	else
		return number_format($bytes/1073741824, 2)." GBytes";
}
?>