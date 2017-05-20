<?php
function videoCodigo($url) {
	$v=new video($url);
	return $v->codigo();
}
function videoURL($codigo) {
	$v=new video($codigo);
	return $v->url();	
}
function videoHTML($codigo, $ancho=640, $ratio=NULL, $autoplay=false, $color="fff") {
	$v=new video($codigo);
	return $v->html($ancho, $ratio, $autoplay, $color);
}
function videoThumb($codigo, $ancho=120, $ratio=0.5625, $alt="") {
	$v=new video($codigo);
	return $v->thumb($ancho, $ratio, $alt);
}

class video {
	private $proveedor;
	private $codigo;
	private $imagenCod;
	private $imagenRatio;
	function __construct($codigo) {
		if (substr($codigo, 0, 4)=="http")
			list($this->proveedor, $this->codigo, $this->imagenCod, $this->imagenRatio)=$this->decodeURL($codigo);
		elseif (substr($codigo, 0, 2)=="1," || substr($codigo, 0, 2)=="2,")
			list($this->proveedor, $this->codigo, $this->imagenCod, $this->imagenRatio)=explode(",", $codigo);
	}
	function decodeURL($url) {
		$proveedor=0;
		$codigo="";
		$imagenCod="";
		$imagenRatio="";
		$codigo=$this->decodeURLyoutube($url);
		if ($codigo)
			$proveedor=1;
		else {
			$codigo=$this->decodeURLvimeo($url);
			if ($codigo) {
				$proveedor=2;
				$x=$this->decodeImagenVimeo($codigo);
				if (count($x)==2)
					list($imagenCod, $imagenRatio)=$x;
			}
		}
		return array($proveedor, $codigo, $imagenCod, $imagenRatio);
	}
	function decodeURLyoutube($url) {
		$url=trim($url);
		if (preg_match("/^(http|https)\:\/\/www\.youtube\.com/", $url) && preg_match("/v\=/", $url)) {
			list($p1, $p2)=explode("v=", $url."&");
			list($p1, $p2)=explode("&", $p2);
			if (preg_match("/^[a-zA-Z0-9\-\_]{11}$/", $p1))
				return $p1;
			else
				return "";
		}
		elseif (preg_match("/^http\:\/\/youtu\.be\//", $url)) {
			$p1=substr($url, 16);
			if (preg_match("/^[a-zA-Z0-9\-\_]{11}$/", $p1))
				return $p1;
			else
				return "";
		}
		else
			return "";		
	}
	function decodeURLvimeo($url) {
		$url=trim($url);
		if (preg_match("/^(http|https)\:\/\/vimeo\.com/", $url)) {
			list($p1, $p2)=explode("vimeo.com/", $url);
			if (preg_match("/^[0-9]+$/", $p2))
				return $p2;
			else
				return "";
		}
		else
			return "";
	}
	function decodeImagenVimeo($codigo) {
		$c=file_get_contents("http://vimeo.com/api/v2/video/$codigo.xml");
		$x=explode("<thumbnail_large>http://i.vimeocdn.com/video/", $c);
		if (isset($x[1])) {
			$x=explode("_640.jpg</thumbnail_large>", $x[1]);
			if (isset($x[0])) {
				list($w, $h)=@getimagesize("http://i.vimeocdn.com/video/".$x[0]."_640.jpg");
				if ($w && $h)
					return array($x[0], round($h/640, 2));
				else
					return array($x[0], "");
			}
			else
				return "";
		}
		else
			return "";
	}
	function codigo() {
		if ($this->proveedor)
			return $this->proveedor.",".$this->codigo.",".$this->imagenCod.",".$this->imagenRatio;
		else
			return "";
	}
	function url() {
		if ($this->proveedor==1)
			return "http://www.youtube.com/watch?v=".$this->codigo;	
		elseif ($this->proveedor==2)
			return "http://vimeo.com/".$this->codigo;
		else
			return "";
	}
	function html($ancho=640, $ratio=NULL, $autoplay=false, $color="fff") {
		$r="";
		$alto=round($ancho*($ratio===NULL ? ($this->proveedor==2 ? $this->imagenRatio : 0.5625) : $ratio));
		if ($this->proveedor==1) {
			$r="<iframe width=\"$ancho\" height=\"$alto\" src=\"//www.youtube.com/embed/".$this->codigo."?rel=0&showinfo=0".($autoplay ? "&autoplay=1" : "")."\" frameborder=\"0\" allowfullscreen></iframe>\n";
		}
		elseif ($this->proveedor==2) {
			$r="<iframe src=\"//player.vimeo.com/video/".$this->codigo."?title=0&amp;byline=0&amp;portrait=0&amp;color=$color".($autoplay ? "$amp&amp;autoplay=1" : "")."\" width=\"$ancho\" height=\"$alto\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>\n";
		}
		return $r;
	}
	function thumb($ancho=120, $ratio=0.5625, $alt="") {
		$src="";
		$h=$ancho*$ratio;
		$alto=round($ancho*0.75);
		if ($this->proveedor==1) {
			if ($ancho<=120)
				$src="http://img.youtube.com/vi/".$this->codigo."/default.jpg";
			else
				$src="http://img.youtube.com/vi/".$this->codigo."/0.jpg";
		}
		elseif ($this->proveedor==2) {
			if ($ancho<=100)
				$src="http://i.vimeocdn.com/video/".$this->imagenCod."_100x75.jpg";
			elseif ($ancho<=200)
				$src="http://i.vimeocdn.com/video/".$this->imagenCod."_200x150.jpg";
			else {
				$src="http://i.vimeocdn.com/video/".$this->imagenCod."_640.jpg";
				if ($this->imagenRatio)
					$alto=round($ancho/$this->imagenRatio);
				else
					$alto="";
			}
		}
		if ($src) {
			return "<span class=\"thVideo\"><img".($h!=$alto && $alto ? " style=\"margin: ".round(($h-$alto)/2)."px 0px;\"" : "")." src=\"$src\" width=\"$ancho\"".($alto ? " height=\"$alto\"" : "")." alt=\"$alt\"></span>\n";
		}
		else
			return "";
	}
}
?>