<?php
function adaptar($var, $origenDB=true, $ajax=false) {
    if (!is_array($var)) {
        if ($ajax)
            $var=utf8_decode($var);
       
        if (!get_magic_quotes_gpc() || $origenDB) {
            $or=$var;
            $db=addslashes($var);
        }
        else {
            $or=stripslashes($var);
            $db=$var;
        }
        if (defined("ENT_IGNORE"))
            $form=htmlspecialchars($or, ENT_COMPAT ^ ENT_IGNORE, "ISO-8859-1");
        else
            $form=htmlspecialchars($or, ENT_COMPAT);
       
        return array($or, $db, $form);
    }
    else {
        $aO=array();
        $aD=array();
        $aF=array();
        foreach ($var as $v => $val) {
            list($aO[$v], $aD[$v], $aF[$v])=adaptar($val, $origenDB, $ajax);
        }
        return array($aO, $aD, $aF);
    }
}
function asp() {
	if (isset($_POST["asp"]))
		return (((int)substr($_POST["asp"], 0, 3)*3-11)==(int)substr($_POST["asp"], 4, 3));
	else
		return false;
}
function truncarTexto($txt, $numCar, $estricto=false) {
	$txt=trim($txt);
	if (strlen($txt)>($numCar-3)) {
		$txt1=substr($txt, 0, $numCar-3);
		if (!$estricto) {
			$ult=substr($txt1, -1);
			if ($ult!="." && $ult!="," && $ult!=";" && $ult!=":" && $ult!=" ") {
				$txt2=explode(" ", $txt1);
				unset($txt2[count($txt2)-1]);
				$txt1=join(" ", $txt2);
			}
		}
		$txt1=trim($txt1);
		$ult=substr($txt1, -1);
		if ($ult=="." || $ult=="," || $ult==";" || $ult==":")
			$txt1=substr($txt1, 0, -1);
		
		$txt=$txt1."...";
	}
	return $txt;
}
function truncarLink($txt) {
	$txt=trim($txt);
	if (strlen($txt)>100)
		$txt=substr($txt, 0, 100);
	
	return unixName($txt);
}
function unixName($txt) {
	$pat=array("/[ÁÀÄÂáàäâ]/", "/[ÉÈËÊéèëê]/", "/[ÍÌÏÎíìïî]/", "/[ÓÒÖÔóòöô]/", "/['ÚÙÜÛúùüû]/", "/[Çç]/", "/[Ññ]/", "/[İıÿ]/", "/[^a-z0-9\-]/");
	$rem=array("a", "e", "i", "o", "u", "c", "n", "y", "-");
	$txt=strtolower(trim($txt));
	$txt=preg_replace($pat, $rem, $txt);
	do {
		$txt2=$txt;
		$txt=str_replace("--", "-", $txt);
	}
	while ($txt!=$txt2);
	$txt=preg_replace("/(^\-|\-$)/", "", $txt);
	return $txt;
}
function error() {
	if (DEBUG)
		echo "<br>".mysql_error()."</br>\n";
}

function socialBar($twTexto="") {
	$twTexto=textoContent($twTexto);
	if (strlen($twTexto)>119)
		$twTexto=substr($twTexto, 0, 118)."&hellip;";
?>
<div class="socialBar">

<div class="btnSB">
<div class="fb-share-button" data-type="box_count" data-width="69"></div>
</div>

<div class="btnSB">
<a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-lang="<?php echo IDIOMA; ?>"<?php echo ($twTexto ? " data-text=\"$twTexto\"" : ""); ?>>Tweetear</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>

<div class="btnSB">
<div class="g-plusone" data-size="tall" data-width="58"></div>
</div>

</div>
<!-- fin socialBar -->
<?php
}

function textoContent($txt, $numCar=NULL, $estricto=false) {
	$txt=preg_replace(array("/\"/", "/\n/", "/(\t|\r)/"), array("'", " ", ""), strip_tags($txt)); 
	if ($numCar)
		$txt=truncarTexto($txt, $numCar, $estricto);
		
	return $txt;
}
function echoCopyright($anoIni=false) {
	echo "&copy; Copyright ";
	$y=(int)gmdate("Y", time()+3600*HUSO);
	if ($anoIni) {
		if ($anoIni<$y)
			echo "$anoIni-";
	}
	echo $y;
}
?>