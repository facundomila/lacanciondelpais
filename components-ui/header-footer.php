<style>
div.name {
    max-width: 120px;
    line-height: 24px;
	  font-family: 'Titillium Web', sans-serif !important;
    font-size: 22px;
    font-weight: bolder;
    color: #1b4b5e;
    padding-bottom: 7px;
}
div.name a:hover{
    color: #ff4330;
    text-decoration: none;
}
div.horarios {
    line-height: 12px;
    font-size: 12px;
    font-weight: bolder;
    color: #1b4b5e;
}
nav ul{
    margin: 0;
    padding: 0;
}
nav li{
    list-style-type: none;
    margin: -5px 0;
    padding: 0;
}
nav.links a{
    line-height: 25px;
    font-size: 12px;
    font-weight: bolder;
    color: #1b4b5e;
}
nav.links a:hover{
    color: #ff4330;
    text-decoration: none;
}
div.contacto ul{
    margin: 0;
    padding: 0;
 }
div.contacto li{
    list-style-type: none;
    margin: -5px 0;
    padding: 0;
}
div.contacto a{
    line-height: 13px;
    font-size: 13px;
    font-weight: bolder;
    color: #265d8c;
}
div.contacto a:hover{
    color: #ff4330;
    text-decoration: none;
}
div.contacto input{
   width: 100%;
   box-sizing: border-box;
   border: 2px solid #ccc;
   color: #666;
   border-radius: 4px;
   font-size: 14px;
   background-color: #e5e5e5;
   background-repeat: no-repeat;
   padding: 5px 10px;
   margin-top: 5px;
}
div.contacto .btn{
   border: 0px;
   color: white;
   background-color: #ff4330;
   border-radius: 0px;
   font-size: 12px;
   padding: 2px 6px;
   width: 100%;
   cursor: pointer;
}
div.social a{
    line-height: 13px;
    font-size: 32px;
    font-weight: bolder;
    color: #1b4b5e;
}
div.social a:hover{
    color: #ff4330;
    text-decoration: none;
}
div.social input{
   width: 92%;
   box-sizing: border-box;
   border: 0px;
   color: #fff;
   border-radius: 3px;
   font-size: 11px;
   background-color: #d0d0d0;
   padding: 2px 6px;
   margin: 26px 2% 0 0;
}
div.social .btn{
   width: 6%;
   color: #ff4330;
   margin-top: 18px;
   background-color: transparent;
   font-size: 14px;
   cursor: pointer;
   float: right;
   padding: 7px 2px;
}
div.logo {
  position: relative;
  overflow: hidden;
  width: 46px;
  height: 26px;
}
div.logo img{
  position: relative;
  width: 65px;
  height: 65px;
  top: -17px;
  left: -10px;
}
</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-1" style="padding-left:5px !important;"></div>
    <div class="col-md-2" style="min-width:170px; height:80px; border-left: solid 1px #ff4330; padding: 0 25px 0 7px; margin-bottom:15px">
      <div class="name"><a href="/lacanciondelpais.com.ar/">LA CANCIÓN DEL PAÍS</a></div>
      <div class="logo"><a href="/lacanciondelpais.com.ar/"><img src="img/lcpd_conefecto_sinfondo.png"></a></div>
    </div>
    <div class="col-md-2" style="min-width:170px; height:80px; border-left: solid 1px #ff4330; padding: 0 15px 0 7px; margin-bottom:15px">
      <div class="horarios">
        LUN A VIE | 15 A 16 HS.<br>
        <span style="font-size:16px; color: #ff4330 !important; line-height: 32px">FM 103.3</span><br>
        RADIO<br>UNIVERSIDAD<br>ROSARIO
      </div>
    </div>
    <div class="col-md-2" style="min-width:170px; height:80px; border-left: solid 1px #ff4330; padding: 0 25px 0 7px; margin-bottom:15px">
      <nav class="links">
          <ul>
            <li><a href="/lacanciondelpais.com.ar/notas/musica">MÚSICA</a></li>
            <li><a href="/lacanciondelpais.com.ar/notas/literatura">LITERATURA</a></li>
            <li><a href="/lacanciondelpais.com.ar/notas/arte">ARTE</a></li>
            <li><a href="/lacanciondelpais.com.ar/notas/audiovisuales">AUDIOVISUALES</a></li>
          </ul>
      </nav>
    </div>
  <div class="col-md-2" style="min-width:170px; height:80px; border-left: solid 1px #ff4330; padding: 0 25px 0 7px; margin-bottom:15px">
    <nav class="links">
      <ul>
        <li><a href="/lacanciondelpais.com.ar/notas/escenicas">ESCÉNICAS</a></li>
        <li><a href="/lacanciondelpais.com.ar/contacto.html">SOCIEDAD</a></li>
        <li><a href="/lacanciondelpais.com.ar/contacto.html">CONTACTO</a></li>
        <li><a href="/lacanciondelpais.com.ar/contacto.html">AGENDA</a></li>
      </ul>
    </nav>
  </div>
    <div class="col-md-2" style="min-width:170px; height:80px; border-left: solid 1px #ff4330; padding: 0 7px 0 5px;">
      <div class="social">
          <span><a target="_blank" href="http://nubroadcast.com.ar/universidad/"><i class="fa fa-youtube"></i></a>
          <a target="_blank" href="https://www.facebook.com/profile.php?id=100000182077268"><i class="fa fa-facebook"></i></a>
          <a target="_blank" href="http://twitter.com/canciondelpais"><i class="fa fa-twitter"></i></a>
          </span>
      <form method="get" action="busqueda" onsubmit="return qCheck();">
      <span>
        <input type="text" id="q" name="q" value="<?php echo (isset($_GF["q"]) ? $_GF["q"] : "Buscar..."); ?>" onblur="if(this.value=='') this.value='Buscar...'" onfocus="if(this.value=='Buscar...') this.value='';">
        <button class="btn" id="q" name="q" onclick="submit();"><i class="fa fa-search"></i></button>
      </span>
      </form>
      </div>
    </div>
    <div class="col-md-1"></div>
  </div>
</div>
