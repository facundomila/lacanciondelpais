<?php
function imagenAdmin($path="", $base="", $default="", $campo="imagen", $aclara="") {
	$txt="";
	if ($default) {
		
		$txt.=imagenHTML("th$default", $path, $base)."<br />";
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
function imagenPost($path, $tabla, $id=0, $campo="imagen", $versiones=array(array("s" => "or", "w" => 0, "h" => 0, "f" => 0), array("s" => "th", "w" => 150, "h" => 112, "f" => 2), array("s" => "th2", "w" => 120, "h" => 100, "f" => 0)), $campoDB=NULL) {
	
	if (!$campoDB)
		$campoDB=$campo;
	
	$abort=false;
	$update=false;
	$n="";
	
	$arcUpload=(isset($_FILES[$campo]) ? ((int)$_FILES[$campo]["size"]>0 ? true : false) : false);
	
	if ($id!=0 && ($arcUpload || isset($_POST["bor$campo"]))) {
		//Si existe el registro y se sube uno nuevo o se marcó el campo borrar, se borra el anterior:
		
		$C=mysql_query("SELECT $campoDB FROM $tabla WHERE id=$id") or dbError();	
		if ($R=mysql_fetch_array($C)) {
			if ($R[$campoDB]) {
				imagenBorrar($path, $R[$campoDB]);
				$n=", $campoDB=''";
			}
			$update=true;
		}
		else
			$abort=true;
		
		mysql_free_result($C);
	}
		
	if (!$abort && $arcUpload) {
		$i=imagenCrear($_FILES[$campo]);
		if ($i && is_array($versiones)) {
			$save=false;
			$nombre=md5($campo.gmdate("YmdHis").rand(111, 999));
			foreach ($versiones as $val) {
				//Recorre las versiones solicitadas y reescala el original:
				$im=imagenReescalar($i["imagen"], $val["w"], $val["h"], $val["f"], true);
				if ($im) {
					
					//Guarda las versiones en disco según el formato y asigna nombre:
					switch($i["Tipo"]) {
						case "jpg":
							$n="$nombre.jpg";
							if (imagejpeg($im, $path.$val["s"].$n, IMG_CALIDAD)) {
								$save=true;
							}
							break;
						
						case "gif":
							$n="$nombre.gif";
							if (imagegif($im, $path.$val["s"].$n))
								$save=true;
							
							break;
							
						case "png":
							$n="$nombre.png";
							if (imagepng($im, $path.$val["s"].$n))
								$save=true;
							
							break;
					}
					imagedestroy($im);
				}
			}
			
			imagedestroy($i["imagen"]);
			
			//Adapta el nombre a sql si es update:
			$n=(($update && $save) ? ", $campoDB='$n'" : "$n");
		}
	}
	return $n;
}
function imagenHTML($archivo, $path="", $base="", $border=0, $alt="", $adicional="") {
	$txt="";
	if (file_exists($path.$archivo)) {
		list($w, $h)=@getimagesize($path.$archivo);
		if ($w && $h) {
			$txt.="<img src=\"$base$archivo\" width=\"$w\" height=\"$h\" border=\"$border\" alt=\"".str_replace("\"", "'", $alt)."\"".($adicional ? " $adicional" : "")." />\n";
		}
	}
	if (!$txt) $txt="file not found";
	return $txt;
}
function imagenBorrar($path, $archivo) {
	$r=false;
	if ($archivo) {
		if (substr($path, -1)!=DS)
			$path.=DS;
		
		if (file_exists("$path$archivo")) {
			unlink("$path$archivo");
			$r=true;
		}
		
		if (file_exists($path."or$archivo")) {
			unlink($path."or$archivo");
			$r=true;
		}
		
		if (file_exists($path."gr$archivo")) {
			unlink($path."gr$archivo");
			$r=true;
		}
		
		if (file_exists($path."mi$archivo")) {
			unlink($path."mi$archivo");
			$r=true;
		}

		if (file_exists($path."md$archivo")) {
			unlink($path."md$archivo");
			$r=true;
		}
		
		if (file_exists($path."th$archivo")) {
			unlink($path."th$archivo");
			$r=true;
		}
	}
	return $r;
}
function imagenCrear($file) {
	$r=false;
	if ($file["size"]!=0) {
		if ($file["type"]=="image/jpg" || $file["type"]=="image/jpeg" || $file["type"]=="image/pjpeg") {
			$tipo="jpg";
			$im=imagecreatefromjpeg($file["tmp_name"]);
		}
		elseif ($file["type"]=="image/gif") {
			$tipo="gif";
			$im=imagecreatefromgif($file["tmp_name"]);
		}
		elseif ($file["type"]=="image/png") {
			$tipo="png";
			$im=imagecreatefrompng($file["tmp_name"]);
		}
		if ($tipo && $im)
			$r=array("imagen" => $im, "Tipo" => $tipo);
	}
	return $r;
}
function imagenReescalar($im, $ancho=0, $alto=0, $forzar=0, $transparente=false) {
	//Obtiene dimesiones:
	$offY=0;
	if ($forzar==3) {
		//Escalado especial (Corte superior):
		if ($ancho/$alto>imagesx($im)/imagesy($im)) {
			$offY=1;//(int)($alto*0.04);
			$altoN=$alto;
			$alto=0;
			$forzar=0;
		}
		else 
			$forzar=2;
	}
	$d=imagenDimensionar($im, $ancho, $alto, $forzar);
	
	if ($d) {
		if ($offY) {
			$d["AltoFinal"]=$altoN;
			$d["OffsetY"]=-$offY;
		}

		//Genera la nueva imagen:
		if (!function_exists("imagecopyresampled"))// || $transparente
			$im2=imagecreate($d["AnchoFinal"], $d["AltoFinal"]);
		else
			$im2=imagecreatetruecolor($d["AnchoFinal"], $d["AltoFinal"]);
		
		if ($im2) {
			if ($transparente) {
				$ck=imagecolorallocate($im2, 0, 255, 0);
				imagefill($im2, 0, 0, $ck);
				imagecolortransparent($im2, $ck);
			}
			
			if ($ancho==$d["AnchoOr"] && $alto==$d["AltoOr"]) {
				//No se modificó el tamaño:
				imagecopy($im2, $im, 0, 0, 0, 0, imagesx($im), imagesy($im));
			}
			else {
				if (function_exists("imagecopyresampled"))
					imagecopyresampled($im2, $im, $d["OffsetX"], $d["OffsetY"], 0, 0, $d["AnchoNuevo"], $d["AltoNuevo"], $d["AnchoOr"], $d["AltoOr"]);
				else
					imagecopyresized($im2, $im,  $d["OffsetX"], $d["OffsetY"], 0, 0, $d["AnchoNuevo"], $d["AltoNuevo"], $d["AnchoOr"], $d["AltoOr"]);
			}
		}	
	}
	if ($im2) return $im2; else	return false;
}
function imagenDimensionar($im, $ancho=0, $alto=0, $forzar=0) {
	if ($im) {
		$anchoOr=imagesx($im);
		$altoOr=imagesy($im);
		if ($anchoOr && $altoOr) {
			if ($forzar==2 && $ancho && $alto) {
				//Imagen a truncar:
				
				//Calcula proporciones:
				$anchoRatio=(float)$ancho/$anchoOr;
				$altoRatio=(float)$alto/$altoOr;
				
				//Elige la proporción adecuada:
				$ratio=1;
				if($anchoRatio>$altoRatio)
					$ratio=$anchoRatio;
				else
					$ratio=$altoRatio;
				
				//Calcula nuevo tamaño:
				$anchoNuevo=(int)round($anchoOr*$ratio, 0);
				$altoNuevo=(int)round($altoOr*$ratio, 0);
					
				//Calcula el offset de la imagen:
				$offsetX=(int)(($ancho-$anchoNuevo)/2);
				$offsetY=(int)(($alto-$altoNuevo)/2);
				
				//Define todos los parámetros resultantes:
				$r=array("AnchoOr" => $anchoOr, "AltoOr" => $altoOr, "AnchoNuevo" => $anchoNuevo, "AltoNuevo" => $altoNuevo, "OffsetX" => $offsetX, "OffsetY" => $offsetY, "AnchoFinal" => $ancho, "AltoFinal" => $alto);
			}
			else {
				//Imagen a reescalar:
				if ($forzar==0 && (!$ancho || $anchoOr<=$ancho) && (!$alto || $altoOr<=$alto)) {
					//No reescala:
					$anchoNuevo=$anchoOr;
					$altoNuevo=$altoOr;
				}
				else {
					//Calcula proporciones:
					if ($ancho && ($anchoOr>$ancho || $forzar==1))
						$anchoRatio=(float)$ancho/$anchoOr;
					else
						$anchoRatio=1;
		
					if ($alto && ($altoOr>$alto || $forzar==1))
						$altoRatio=(float)$alto/$altoOr;
					else
						$altoRatio=1;
					
					//Elige la proporción adecuada y calcula los nuevos tamaños:
					if($anchoRatio<$altoRatio) {
						$anchoNuevo=$ancho;
						$altoNuevo=(int)round($altoOr*$anchoRatio, 0);
					}
					else {
						$anchoNuevo=(int)round($anchoOr*$altoRatio, 0);
						$altoNuevo=$alto;
					}
				}
				$r=array("AnchoOr" => $anchoOr, "AltoOr" => $altoOr, "AnchoNuevo" => $anchoNuevo, "AltoNuevo" => $altoNuevo, "OffsetX" => 0, "OffsetY" => 0, "AnchoFinal" => $anchoNuevo, "AltoFinal" => $altoNuevo);
			}
		}
	}
	if ($r) return $r; else return false;
}
?>