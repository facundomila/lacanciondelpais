<?php
function randPassword($chars=8) {
	$pass="";
	for ($a=0;$a<$chars;$a++) {
		do {
			$x=rand(48, 122);
		}
		while (($x>57 && $x<65) || ($x>90 && $x<97));
		$pass.=chr($x);
	}
	return $pass;
}
function getOrden($tabla, $campo="Orden") {
	$C=mysql_query("SELECT MAX($campo) FROM $tabla") or dbError();	
	if ($R=mysql_fetch_array($C))
		$r=(int)$R[0]+1;
	else
		$r=1;
	
	mysql_fetch_array($C);
	
	return $r;
}
function autoLink($nombre, $id, $tabla, $campo="link", $pre="", $pos="", $campoID="id") {
	$link1=unixName($nombre);
	$link=$link1;
	$count=1;
	$repe=true;
	do {
		$C=mysql_query("SELECT $campoID FROM $tabla WHERE $campo='$pre$link$pos' AND $campoID<>$id") or error();
		if (mysql_fetch_array($C)) {
			$count++;
			$link=$link1."-$count";
		}
		else
			$repe=false;
		
		mysql_free_result($C);
	}
	while ($repe);
	return "$pre$link$pos";
}
?>