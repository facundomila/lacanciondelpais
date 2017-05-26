<div class="container-fluid">
  <div class="row">
    <div class="col-md-1" style="padding-left:5px !important;"></div>
    <div class="col-md-2" style="min-width:170px; height:80px; border-left: solid 1px #ff4330; padding: 0 25px 0 7px; margin-bottom:15px">
      <div class="name"><a href="/lacanciondelpais.com.ar/"><img style="width:140px;position:relative;top:-5px;" src="img/iso_header.png"></a></div>
      <div class="logo"><a href="/lacanciondelpais.com.ar/"><img src="img/lcpd_conefecto_sinfondo.png"></a></div>
    </div>
    <div class="col-md-2" style="min-width:170px; height:80px; border-left: solid 1px #ff4330; padding: 0 15px 0 7px; margin-bottom:15px">
      <div class="horarios">
        LUN A VIE | 15 A 16 HS.<br>
        <span style="font-size:16px; color: #ff4330 !important; line-height: 32px">FM 103.3</span><br>
        RADIO<br>UNIVERSIDAD<br>ROSARIO
      </div>
    </div>
    <div id="menu-links" class="col-md-2" style="min-width:170px; height:80px; border-left: solid 1px #ff4330; padding: 0 25px 0 7px; margin-bottom:15px">
      <nav class="links">
          <ul>
            <li><a href="/lacanciondelpais.com.ar/notas/musica">MÚSICA</a></li>
            <li><a href="/lacanciondelpais.com.ar/notas/literatura">LITERATURA</a></li>
            <li><a href="/lacanciondelpais.com.ar/notas/arte">ARTE</a></li>
            <li><a href="/lacanciondelpais.com.ar/notas/audiovisuales">AUDIOVISUALES</a></li>
          </ul>
      </nav>
    </div>
  <div id="menu-links" class="col-md-2" style="min-width:170px; height:80px; border-left: solid 1px #ff4330; padding: 0 25px 0 7px; margin-bottom:15px">
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
    <div class="col-md-1"><button class="menu-phone" onclick=showMenu()><i class="fa fa-bars" aria-hidden="true"></i></button></div>
  </div>
</div>
<div class="links-phone-menu">
    <nav class="phone-links">
        <ul>
            <li><a href="/lacanciondelpais.com.ar/notas/musica">MÚSICA</a></li><hr>
            <li><a href="/lacanciondelpais.com.ar/notas/literatura">LITERATURA</a></li><hr>
            <li><a href="/lacanciondelpais.com.ar/notas/arte">ARTE</a></li><hr>
            <li><a href="/lacanciondelpais.com.ar/notas/audiovisuales">AUDIOVISUALES</a></li><hr>
            <li><a href="/lacanciondelpais.com.ar/notas/escenicas">ESCÉNICAS</a></li><hr>
            <li><a href="/lacanciondelpais.com.ar/contacto.html">SOCIEDAD</a></li><hr>
            <li><a href="/lacanciondelpais.com.ar/contacto.html">CONTACTO</a></li><hr>
            <li><a href="/lacanciondelpais.com.ar/contacto.html">AGENDA</a></li>
        </ul>
    </nav>
</div>
<script>
  $(".menu-phone").click(function(){
      $(".links-phone-menu").toggle();
  });
</script>