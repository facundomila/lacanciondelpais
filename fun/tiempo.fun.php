<?php
function fecha($fechaSQL, $sepF="/") {
	return (strlen($fechaSQL)>=10 ? substr($fechaSQL, 8, 2).$sepF.substr($fechaSQL, 5, 2).$sepF.substr($fechaSQL, 0, 4) : "");
}
function fechaLarga($fechaSQL) {
	return (strlen($fechaSQL)>=10 ? ((int)substr($fechaSQL, 8, 2))." de ".mes(substr($fechaSQL, 5, 2))." de ".substr($fechaSQL, 0, 4) : "");
}

function fechaLargaSinAno($fechaSQL) {
	return (strlen($fechaSQL)>=10 ? ((int)substr($fechaSQL, 8, 2))." de ".mes(substr($fechaSQL, 5, 2)) : "");
}
function fechaMesAno($fechaSQL) {
	return (strlen($fechaSQL)>=10 ? mes(substr($fechaSQL, 5, 2))." de ".substr($fechaSQL, 0, 4) : "");
}
function fechaHora($fechaSQL, $sepF="/", $sepH=":") {
	return fecha($fechaSQL, $sepF)." ".hora($fechaSQL, $sepH);
}
function fechaHoraSeg($fechaSQL, $sepF="/", $sepH=":") {
	return fecha($fechaSQL, $sepF)." ".horaSeg($fechaSQL, $sepH);
}
function hora($fechaSQL, $sepH=":") {
	return (strlen($fechaSQL)>=16 ? substr($fechaSQL, 11, 2).$sepH.substr($fechaSQL, 14, 2) : "00$sepH"."00");
}
function horaSeg($fechaSQL, $sepH=":") {
	return hora($fecchaSQL, $sepH).$sepH.(strlen($fechaSQL)>=19 ? substr($fechaSQL, 17, 2) : "00");
}
function fechaPost($campo) {
	$f="";
	if (isset($_POST[$campo."Dia"]) && isset($_POST[$campo."Mes"]) && isset($_POST[$campo."Ano"]))
		$f=$_POST[$campo."Ano"]."-".$_POST[$campo."Mes"]."-".$_POST[$campo."Dia"];
	
	if (isset($_POST[$campo."Hora"]) && isset($_POST[$campo."Min"]))
		$f.=($f ? " " : "").$_POST[$campo."Hora"].":".$_POST[$campo."Min"];
	
	return $f;
}
function mkTimeSQL($fechaSQL) {
	$t=0;
	if (strlen($fechaSQL)>=10) {
		if (strlen($fechaSQL)<18)
			$fechaSQL.=substr(" 00:00:00", strlen($fechaSQL)-10);
		
		$t=mktime((int)substr($fechaSQL, 11, 2), (int)substr($fechaSQL, 14, 2), (int)substr($fechaSQL, 17, 2), (int)substr($fechaSQL, 5, 2), (int)substr($fechaSQL, 8, 2), (int)substr($fechaSQL, 0, 4));
	}
	return $t;
}

function fechaHoraAdmin($campo, $default="", $minAno=5, $maxAno=5, $inc=true, $minPaso=5) {
	if (strlen($default)>=10)
		$fecha=substr($default, 0, 10);
	else
		$fecha=HOY;

	if (strlen($default)>=16)
		$hora=substr($default, 11, 5);
	else
		$hora=substr(AHORA, 11, 5);
	
	return fechaAdmin($campo, $fecha, $minAno, $maxAno, $inc)." - ".horaAdmin($campo, $hora, $minPaso);
}
function fechaAdmin($campo, $default="", $minAno=5, $maxAno=5, $inc=true) {
	if (!$default)
		$default="0000-00-00";
	
	$dia=(int)substr($default, 8, 2);
	$mes=(int)substr($default, 5, 2);
	$ano=(int)substr($default, 0, 4);
	
	$anoHoy=(int)substr(HOY, 0, 4);
	
	$inc=($inc ? 1 : -1);
	
	$anoIni=$anoHoy-$minAno;
	$anoFin=$anoHoy+$maxAno;
	if ($ano<$anoIni && $ano!=0)
		$anoIni=$ano;
	
	if ($ano>$anoFin)
		$anoFin=$ano;
		
	if ($inc==-1) {
		$aux=$anoIni;
		$anoIni=$anoFin;
		$anoFin=$aux;
	}
	$txt="<select class=\"Texto\" id=\"$campo"."Dia\" name=\"$campo"."Dia\" style=\"width: 50px; text-align: right\">\n";
	$txt.="<option value=\"00\">Día...</option>\n";
	for ($a=1; $a<32; $a++) {
		$aa=($a<10 ? "0$a" : $a);
		$txt.="<option value=\"$aa\"".($a==$dia ? " selected=\"selected\"" : "").">$a&nbsp;</option>\n";
	}
	$txt.="</select>\n";
	$txt.=" / \n";
	$txt.="<select class=\"Texto\" id=\"$campo"."Mes\" name=\"$campo"."Mes\" style=\"width: 120px;\">\n";
	$txt.="<option value=\"00\">Mes...</option>\n";
	for ($a=1; $a<13; $a++) {
		$aa=($a<10 ? "0$a" : $a);
		$txt.="<option value=\"$aa\"".($a==$mes ? " selected=\"selected\"" : "").">".mes($a)."</option>\n";
	}
	$txt.="</select>\n";
	$txt.=" / \n";
	$txt.="<select class=\"Texto\" id=\"$campo"."Ano\" name=\"$campo"."Ano\" style=\"width: 60px; text-align: right;\">\n";
	$txt.="<option value=\"0000\">Año...</option>\n";
	for ($a=$anoIni; ($inc==1 && $a<=$anoFin) || ($inc==-1 && $a>=$anoFin); $a+=$inc) {
		$aa=(strlen($a)<4 ? substr("0000", strlen($a)).$a : $a);
		$txt.="<option value=\"$aa\"".($a==$ano ? " selected=\"selected\"" : "").">$a&nbsp;</option>\n";
	}
	$txt.="</select>\n";
	
	return $txt;
}
function horaAdmin($campo, $default="", $minPaso=5) {
	$hora=substr($default, 0, 2);
	$min=substr($default, 3, 2);
	$txt="<select class=\"Texto\" id=\"$campo"."Hora\" name=\"$campo"."Hora\" style=\"width: 50px; text-align: right\">\n";
	for ($a=0; $a<24; $a++) {
		$aa=($a<10 ? "0$a" : $a);
		$txt.="<option value=\"$aa\"".($a==$hora ? " selected=\"selected\"" : "").">$aa&nbsp;</option>\n";
	}
	$txt.="</select>\n";
	$txt.=" : \n";
	$txt.="<select class=\"Texto\" id=\"$campo"."Min\" name=\"$campo"."Min\" style=\"width: 50px; text-align: right\">\n";
	$sel=false;
	for ($a=0; $a<60; $a+=$minPaso) {
		$aa=($a<10 ? "0$a" : $a);
		if (!$sel && $a>$min-$minPaso) {
			$seltxt=" selected=\"selected\"";
			$sel=true;
		}
		else
			$seltxt="";
		
		$txt.="<option value=\"$aa\"$seltxt>$aa&nbsp;</option>\n";
	}
	$txt.="</select>\n";
	return $txt;
}
function mesAnoAdmin($campo, $default="", $minAno=5, $maxAno=5, $inc=false, $add="") {
	if (!$default)
		$default="0000-00-00";
	
	$dia=(int)substr($default, 8, 2);
	$mes=(int)substr($default, 5, 2);
	$ano=(int)substr($default, 0, 4);
	
	$anoHoy=(int)substr(HOY, 0, 4);
	
	$inc=($inc ? 1 : -1);
	
	$anoIni=$anoHoy-$minAno;
	$anoFin=$anoHoy+$maxAno;
	if ($ano<$anoIni && $ano!=0)
		$anoIni=$ano;
	
	if ($ano>$anoFin)
		$anoFin=$ano;
		
	if ($inc==-1) {
		$aux=$anoIni;
		$anoIni=$anoFin;
		$anoFin=$aux;
	}
	$txt="<input type=\"hidden\" id=\"$campo"."Dia\" name=\"$campo"."Dia\" value=\"01\"$add>\n";
	$txt.="<select class=\"texto\" id=\"$campo"."Mes\" name=\"$campo"."Mes\" style=\"width: 120px;\"$add>\n";
	$txt.="<option value=\"00\">Mes...</option>\n";
	for ($a=1; $a<13; $a++) {
		$aa=($a<10 ? "0$a" : $a);
		$txt.="<option value=\"$aa\"".($a==$mes ? " selected=\"selected\"" : "").">".mes($a)."</option>\n";
	}
	$txt.="</select>\n";
	$txt.=" / \n";
	$txt.="<select class=\"texto\" id=\"$campo"."Ano\" name=\"$campo"."Ano\" style=\"width: 80px; text-align: right;\"$add>\n";
	$txt.="<option value=\"0000\">Año...</option>\n";
	for ($a=$anoIni; ($inc==1 && $a<=$anoFin) || ($inc==-1 && $a>=$anoFin); $a+=$inc) {
		$aa=(strlen($a)<4 ? substr("0000", strlen($a)).$a : $a);
		$txt.="<option value=\"$aa\"".($a==$ano ? " selected=\"selected\"" : "").">$a&nbsp;</option>\n";
	}
	$txt.="</select>\n";
	
	return $txt;
}
function mes($m) {
	$mes="";
	switch((int)$m) {
		case  1: $mes="enero"; break;
		case  2: $mes="febrero"; break;
		case  3: $mes="marzo"; break;
		case  4: $mes="abril"; break;
		case  5: $mes="mayo"; break;
		case  6: $mes="junio"; break;
		case  7: $mes="julio"; break;
		case  8: $mes="agosto"; break;
		case  9: $mes="septiembre"; break;
		case 10: $mes="octubre"; break;
		case 11: $mes="noviembre"; break;
		case 12: $mes="diciembre"; break;
	}
	return $mes;
}
function diaSem($d) {
	$dia="";
	switch((int)$d) {
		case  0: $dia="domingo"; break;
		case  1: $dia="lunes"; break;
		case  2: $dia="martes"; break;
		case  3: $dia="miércoles"; break;
		case  4: $dia="jueves"; break;
		case  5: $dia="viernes"; break;
		case  6: $dia="sábado"; break;
	}
	return $dia;
}
function dia($fechaSQL) {
	$t=mktime(0, 0, 0, substr($fechaSQL, 5, 2), substr($fechaSQL, 8, 2), substr($fechaSQL, 0, 4));
	return diasem(gmdate("w", $t));
}
function diasMes($mes, $ano) {
	switch((int)$mes) {
		case 1: case 3: case 5: case 7: case 8: case 10: case 12: $r=31; break;
		case 2: $r=(($ano%4==0 && $ano%100!=0) || $ano%400==0 ? 29 : 28); break;
		default: $r=30;
	}
	return $r;
}
function edad($fechaNac, $fechaHoy=NULL) {
	if ($fechaHoy===NULL)
		$fechaHoy=HOY;
	
	$edad=substr($fechaHoy, 0, 4)-substr($fechaNac, 0, 4);
	if (substr($fechaNac, 5, 2)>substr($fechaHoy, 5, 2) || (substr($fechaNac, 5, 2)==substr($fechaHoy, 5, 2) && substr($fechaNac, 8, 2)>substr($fechaHoy, 8, 2)))
		$edad--;
		
	return $edad;
}
?>