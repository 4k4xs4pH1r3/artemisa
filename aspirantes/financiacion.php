<?php
@session_start();
if(isset($_SESSION))
{
	unset($_SESSION);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Universidad El Bosque</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type=text/css>
<!--
Body { 
scrollbar-face-color : #999999; 
scrollbar-highlight-color : #999999; 
scrollbar-3dlight-color : #999999;
scrollbar-darkshadow-color : #999999; 
scrollbar-arrow-color : #999999; 
scrollbar-shadow-color : #999999; 
scrollbar-track-color: #999999 
} 
-->
</style>
<style type="text/css">
<!--
body {
	margin-top: 0px;
	background-image: url();
	background-color: #FFD8A4;
}
a:link {
	color: #FFA800;
	text-decoration: none;
}
a:visited {
	color: #FFA800;
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
	color: #FFA800;
}
a:active {
	text-decoration: none;
	color: #FFA800;
}
BODY
{
	scrollbar-face-color:#FFFFFF;
	scrollbar-shadow-color:#D5D5D5;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-3dlight-color:#909090;
	scrollbar-darkshadow-color:#909090;
	scrollbar-track-color:#EFEFEF;
	scrollbar-arrow-color:#909090;
	background-color: #FFFFFF;
}
.Estilo16 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FFFFFF;
}
.Estilo18 {font-size: 9px}
.Estilo21 {font-size: 11px}
.Estilo23 {font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo24 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 11px;
	color: #FFFFFF;
}
.Estilo27 {font-size: 10px}
.Estilo28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo13 {font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
}
.Estilo29 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 11px;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body onLoad="MM_preloadImages('imagenes/aspirantes_inicioover.gif','imagenes/aspirantes_pregradoover.gif','imagenes/aspirantes_postgradoover.gif','imagenes/aspirantes_maetriasover.gif','imagenes/aspirantes_doctoradoover.gif','imagenes/aspirantes_educacioncontinuadaover.gif','imagenes/aspirantes_trasferenciasover.gif','imagenes/aspirantes_apoyofinancieroover.gif')">
<table width="750" height="475" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="752" height="475" valign="top" bordercolor="#CCCCCC"><table width="750"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100%" height="122"><img src="imagenes/aspirantes_banner.jpg" width="755" height="125"></td>
      </tr>
      <tr>
        <td height="10" valign="top" bgcolor="#F5F3EF"><table width="755" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="55"><a href="../index.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Inicio','','imagenes/aspirantes_inicioover.gif',1)"><img src="imagenes/aspirantes_inicio.gif" name="Inicio" width="55" height="16" border="0"></a></td>
            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>
            <td width="67"><a href="../admisiones/pregrado.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Pregrado','','imagenes/aspirantes_pregradoover.gif',1)"><img src="imagenes/aspirantes_pregrado.gif" name="Pregrado" width="67" height="16" border="0"></a></td>
            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>
            <td width="69"><a href="../admisiones/especializacion.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Postgrados','','imagenes/aspirantes_postgradoover.gif',1)"><img src="imagenes/aspirantes_postgrado.gif" name="Postgrados" width="69" height="16" border="0"></a></td>
            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>
            <td width="68"><a href="../admisiones/maestrias.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Maestrias','','imagenes/aspirantes_maetriasover.gif',1)"><img src="imagenes/aspirantes_maetrias.gif" name="Maestrias" width="68" height="16" border="0"></a></td>
            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>
            <td width="75"><a href="http://www.bioeticaunbosque.edu.co/" target="_blank" onMouseOver="MM_swapImage('Doctorado','','imagenes/aspirantes_doctoradoover.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="imagenes/aspirantes_doctorado.gif" name="Doctorado" width="75" height="16" border="0"></a></td>
            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>
            <td width="132"><a href="../admisiones/educontinuada.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Edu Continuada','','imagenes/aspirantes_educacioncontinuadaover.gif',1)"><img src="imagenes/aspirantes_educacioncontinuada.gif" name="Edu Continuada" width="132" height="16" border="0"></a></td>
            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>
            <td width="84"><a href="transferencias.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Transferencias','','imagenes/aspirantes_trasferenciasover.gif',1)"><img src="imagenes/aspirantes_trasferencias.gif" name="Transferencias" width="84" height="16" border="0"></a></td>
            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>
            <td width="107"><a href="financiacion.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Financiacion','','imagenes/aspirantes_apoyofinancieroover.gif',1)"><img src="imagenes/aspirantes_apoyofinanciero.gif" name="Financiacion" width="107" height="16" border="0"></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="323" valign="top">
		<table width="755"  border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="80%" valign="top" bgcolor="#F5F3EF"><table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="Estilo27"><div align="justify"><strong><span class="Estilo28">                          <br>
                          <span class="Estilo13"><span class="Estilo21"> <img src="imagenes/6.gif" width="248" height="29"><br>
                          </span></span></span></strong><span class="Estilo28">                          <br>
                          La Universidad cuenta con personal dispuesto a atender tus necesidades econ&oacute;micas. <br>
                          <br>
                          El Departamento de Cr&eacute;dito y Cartera se encargar&aacute; de orientarte u orientar a tus padres sobre las diferentes alternativas de financiaci&oacute;n que ofrece la Universidad y las diferentes entidades financieras con quienes la Universidad tiene establecidos convenios de cooperaci&oacute;n. <br>
                          <br>
                        Si deseas obtener m&aacute;s informaci&oacute;n haz clic </span><span class="Estilo29"><a href="../admisiones/financiacion.htm">aqu&iacute;</a></span><span class="Estilo28">. </span></div></td>
              </tr>
            </table>              </td>
            <td width="20%" valign="top" bgcolor="#475138">
				<div align="center">
              <p>                <span class="Estilo21"><strong><span class="Estilo23"><img src="imagenes/imagenedificio.jpg" width="152" height="189"><br>
                        <span class="Estilo24"><a href="https://www.unbosque.edu.co/aspirantes/enlinea.php?interesado&link_origen=../../../../aspirantes/aspirantes.php"><img src="imagenes/uno.gif" width="165" height="20" border="0"></a><br>
                        </span><a href="https://www.unbosque.edu.co/aspirantes/enlinea.php"><img src="imagenes/dos.gif" width="165" height="20" border="0"></a><br>
                      </span></strong></span>
                <a href="https://www.unbosque.edu.co/aspirantes/aspirantessec.php"><br>
                <img src="imagenes/ingresoinscritos.gif" width="165" height="60" border="0"></a>              
              <p class="Estilo16 Estilo18"><img src="imagenes/verde.jpg" width="152" height="61"><br>
                <br>
              </p>
            </div>			</td>
          </tr>
        </table>          </td>
      </tr>
    </table></td>

  </tr>
</table>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-1974241-1");
pageTracker._setLocalRemoteServerMode();
pageTracker._initData();
pageTracker._trackPageview();
</script>
</body>
</html>
