<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<?

 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";
 Conexion();

 include_once "../inc/"."identif.php";
 Usuario();

?>
<html>
<head>
<?

   include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php";
   include_once "../inc/"."conexion.inc.php";
   include_once "../inc/"."validacion.inc";
   global $IdiomaSitio;
   $Mensajes = Comienzo ("app-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   $Campos = ObtenerVectorCampos ($IdiomaSitio,2);
   $CamposFijos = ObtenerVectorCampos ($IdiomaSitio,0);



?>

<title><? echo Devolver_Tipo_Material($VectorIdioma,2); ?> - <? echo Titulo_Sitio(); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">

<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
}
body, td, th {
	color: #000000;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style29 {
	color: #006599;
	font-family: Verdana;
	font-size: 11px;
	font-weight: bold;
}
.style42 {color: #FFFFFF; font-size: 11px; font-family: verdana; }
-->
</style>
<script language="JavaScript">
function ver_evento(Id)
{
  ventana=window.open("ver_evento.php?Id="+Id+"&Tabla=<? echo $Tabla; ?>","Evento", "dependent=yes,toolbar=no,width=530,height=270");
}
function ayuda (tabla,campo)
{
  ventana=window.open("ayuda.php?Tabla="+tabla+"&campo="+campo,"Ayuda","dependent=yes,toolbar=no,width=530,height=120");
}
function verifica_campos()
{
   <? Devuelve_validacion_libros($Campos); ?>
}

</script>

<base target="_self">
</head>

<body topmargin="0">
<?
    $Instruccion = "SELECT Tipo_Pedido,Titulo_Libro,Autor_Libro,Editor_Libro,Anio_Libro,Desea_Indice,Capitulo_Libro,Autor_Detalle1,Autor_Detalle2,Autor_Detalle3,Pagina_Desde,Pagina_Hasta,Biblioteca_Sugerida,Observaciones,Usuarios.Apellido,Usuarios.Nombres";
    $Instruccion = $Instruccion.",Tardanza_Atencion,Tardanza_Busqueda,Tardanza_Recepcion,Fecha_Alta_Pedido,Usu2.Apellido,Usu2.Nombres";

	// Tabla lo mando como un parámetro
	// Porque este mismo módulo se usa para consultar-cambiar
	// Pedidos, Históricos o Anulados

	switch ($Tabla)
	{
	  case 1:
         $Instruccion.=" FROM Pedidos LEFT JOIN Usuarios ON Pedidos.Codigo_usuario=Usuarios.Id LEFT JOIN Usuarios AS Usu2 ON Pedidos.Usuario_Creador=Usu2.Id";
		 $Instruccion.=" WHERE Pedidos.Id='".$Id."'";
		 break;
	  case 2:
	     $Instruccion.=" FROM PedHist LEFT JOIN Usuarios ON PedHist.Codigo_usuario=Usuarios.Id LEFT JOIN Usuarios AS Usu2 ON PedHist.Usuario_Creador=Usu2.Id";
		 $Instruccion.=" WHERE PedHist.Id='".$Id."'";
		 break;
	  case 3:
	     $Instruccion.=" FROM PedAnula LEFT JOIN Usuarios ON PedAnula.Codigo_usuario=Usuarios.Id LEFT JOIN Usuarios AS Usu2 ON PedAnula.Usuario_Creador=Usu2.Id";
		 $Instruccion.=" WHERE PedAnula.Id='".$Id."'";

    }

	$result = mysql_query($Instruccion);
    echo mysql_error();
    $row = mysql_fetch_row($result);


    $Comunidad = $row [14].", ".$row[15];
 ?>

<div align="left">
  <table width="670"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ececec">
  <form name="form1" method="POST" action='upd_pedido.php'>
    <tr align="center" bgcolor="#0099FF">
      <td height="20" colspan="2" class="style42">
        <div align="center" class="style42"> <? echo $Comunidad; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $Id; ?></div></td>
      <td height="20" class="style42"><a href='javascript:window.print()'><img src="../images/printer.gif" width="32" border=0 height="33"></a></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $CamposFijos[200][0]; ?>:</div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
       <?
                 $opcion1="Operacion_1";
           	     $opcion2="Operacion_2";
             		echo "<select class='style23' name='Tipo_Pedido'>";
             		$st1="";
             		$st2="";

             		if ($row[0]==1)
             		{ $st1="selected"; }
             		else
             		{ $st2="selected"; }

                 echo "<option $st1 value='1'>$VectorIdioma[$opcion1]</option> ";
			       echo "<option $st2 value='2'>$VectorIdioma[$opcion2]</option> ";
			       echo "</select>";

	  ?>


      </td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
          <a href="javascript:ayuda(0,200)"><img src="../images/help.gif" width="22" height="22" border=0></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
          <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right">
         <? echo $Campos[1][0]; ?>
                          <? if ($row[18]!=0)
             {
            ?>
            <img border="0" src="../images/marca.gif"></td>
           <?
              }

             // Titulo Recien llegado superpone $row[1] con la idea
             // de presentar el titulo que el tipo seleccionó


             if (isset($Titulo_Recien_Llegado))
             {
             	$row[1]=stripslashes($Titulo_Recien_Llegado);
             }

           // Unifico quien tiene el valor del codigo de coleccion
           // $row[18] puede o no tener el codigo de coleccion
           // si tiene 0 y el tipo selecciono algo. $Id_Col va a tener ese codigo
           // El asterisco solo lo presenta despues de cambiar el valor

           if (!isset($Id_Col))
           {
           	$Id_Col=$row[18];
           }

          ?>
    </div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="Titulo" value="<? echo $row[1]; ?>" class="style23" size="75">
                 
      </td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC">
      <div align="center"><a href="javascript:ayuda(2,1)"> <img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
          <div align="right"><? echo $Campos[2][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="AutorTitulo" value="<? echo $row[2]; ?>" class="style23" size="60">
      </td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC">
        <div align="center"><a href="javascript:ayuda(2,2)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $Campos[3][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="Editorial" value="<? echo $row[3]; ?>" class="style23" size="60"></td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
          <a href="javascript:ayuda(2,3)"> <img src="../images/help.gif" border=0 width="22" height="22"> </a> </div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"> <? echo $Campos[4][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
         <input type="text" name="AnioLibro" value="<? echo $row[4]; ?>" class="style23" size="25"></td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(2,4)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"> <? echo $Campos[5][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
         <input type="checkbox" name="Indice" value="ON" <? if ($row[5]==1) { echo "checked"; } ?> class="style23"> </td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(2,5)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>

    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $Campos[6][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="Capitulo_Libro" value = "<? echo $row[6]; ?>" class="style23" size="60"></td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(2,6)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $Campos[7][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="Autor1" value = "<? echo $row[7]; ?>" class="style23" size="60"></td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(2,7)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $Campos[7][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="Autor2" value = "<? echo $row[8]; ?>" class="style23" size="60"></td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(2,7)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $Campos[7][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="Autor3" value = "<? echo $row[9]; ?>" class="style23" size="60"></td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(2,7)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>

    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right">
      <? echo $Campos[8][0]; ?> </div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="PagDesde" size="12" value="<? echo $row[10]; ?>" class="style23">
      </div> </td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(2,8)"><img src="../images/help.gif" border=0 width="22" height="22"></a> </div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $Campos[9][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="PagHasta" value="<? echo $row[11]; ?>" class="style23" size="12"></td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(2,9)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $CamposFijos[201][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="TardanzaAtencion" size="12" class="style23" value="<? echo $row[16]; ?>"></td>
    </tr>
       <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $CamposFijos[202][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="TardanzaBusqueda" size="12" class="style23" value="<? echo $row[17]; ?>"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $CamposFijos[203][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="TardanzaRecepcion" size="12" class="style23" value="<? echo $row[18]; ?>"></td>
    </tr>

    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $CamposFijos[204][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="Biblioteca" value = "<? echo $row[12]; ?>" class="style23" size="60"></td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(0,204)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="top" bgcolor="#CCCCCC" class="style23">
      <div align="right"><? echo $CamposFijos[205][0]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <textarea rows="4" name="Observaciones" cols="60" class="style23"><? echo $row[13]; ?></textarea></td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      <a href="javascript:ayuda(0,205)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td align="center" bgcolor="#ECECEC" class="style23">
        <div align="center"> </div></td>
      <td align="center" bgcolor="#ECECEC" class="style23"><div align="left">
       <? if ($dedonde==2 && (!isset($EsHistorico)))
          {
          ?>
          <input type="submit" value="<? echo $Mensajes["botc-1"]; ?>" OnClick="return verifica_campos()" class="style23">
         <? } ?>
          <input name="cerrador" type="button" class="style23" value="<? echo $Mensajes["botc-2"]; ?>" OnClick="javascript:window.opener.document.forms[0].submit(); self.close()">
      </div></td>
      <td width="30" bgcolor="#ECECEC">&nbsp;</td>
    </tr>
  </table>

	   <input type="hidden" name="Id" value=<? echo $Id; ?>>
	   <input type="hidden" name="TipoMaterial" value=2>
       <input type="hidden" name="Tabla" value=<? echo $Tabla; ?>>
   </form>
  <br>
  <table width="650"  border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#ECECEC">
    <tr align="center" valign="middle" bgcolor="#0099FF">
      <td height="20" colspan="7" class="style42"><div align="center"><? echo $Mensajes["tfd-1"]." ".$row[19]." ".$Mensajes["tfd-2"]." ".$row[20].", ".$row[21]." "; ?></div></td>
    </tr>
    <tr align="center" valign="middle" class="style23">
      <td height="20">&nbsp;</td>
      <td height="20" class="style29"><? echo $Mensajes["tf-4"]; ?></td>
      <td height="20" class="style29"><? echo $Mensajes["tf-5"]; ?></td>
      <td height="20" class="style29"><? echo $Mensajes["tf-6"]; ?></td>
   <!-- </tr>
    <tr align="center" valign="middle" class="style23">
    <td height="20">&nbsp;</td>-->
      <td height="20" class="style29"><? echo $Mensajes["tf-7"]; ?></td>
      <td height="20" class="style29"><? echo $Mensajes["tf-8"]; ?></td>
      <td height="20" class="style29"><? echo $Mensajes["tf-9"]; ?></td>
    </tr>
     <?
     $Instruccion = Armar_select_Eventos ($dedonde,$Id,$Tabla);

     $result = mysql_query($Instruccion);
     echo mysql_error();
     while($row = mysql_fetch_row($result))
     {

  ?>
    <tr align="center" valign="middle" class="style23">
      <td width="20" height="20"><a href="javascript:ver_evento(<? echo $row[7]; ?>)"><img src="../images/mas.gif" border=0 width="9" height="9"></a></td>
      <td height="20"><? echo $row[1]; ?></td>
      <td height="20"><? echo Devolver_Evento($row[0],$VectorIdioma); ?></td>
      <td height="20"><? echo $row[5].",".$row[6]; ?></td>
    <!--</tr>
    <tr align="center" valign="middle" class="style23">
      <td height="20">&nbsp;</td>-->
      <td height="20"><? echo $row[2]; ?></td>
      <td height="20"><? echo $row[3]; ?></td>
      <td height="20"><? echo $row[4]; ?><? if ($row[8]!="" && $row[8]!=0) { echo "<br>"; ?><img border="0" src="../images/mail.gif"><? } ?></td>
    </tr>
    <tr>
      <td height="20">&nbsp;</td>
      <td height="20">&nbsp;</td>
      <td height="20">&nbsp;</td>
      <td height="20">&nbsp;</td>
    </tr>
   <?
    }
    ?>
  </table>
</div>
<?
 mysql_free_result($result);
 Desconectar();
?>
<br>
</body>
</html>
