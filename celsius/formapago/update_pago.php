<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	background-color: #006599;
	margin-left: 10px;
	margin-right:0px; margin-top:0px; margin-bottom:0px
}
body, td, th {
	color: #000000;
}
a:link {
	color: #006599;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #006599;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #006599;
}
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 9px;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style33 {	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style58 {font-size: 9px}
.style60 {font-family: Arial}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<?
   include_once "../inc/fgenped.php";
   include_once "../inc/fgentrad.php";
  
   global $IdiomaSitio;
   $Mensajes = Comienzo ("fcg-001",$IdiomaSitio);


if ($Recibo=="ON")
{$Recibo1=1;}
else
{$Recibo1=0;}
   
   
   If ($dedonde==0)
   {
	   $Instruccion = "INSERT INTO Forma_Pago (nombre,recibo,descripcion) VALUES('".$Nombre."','".$Recibo1."','".$Descripcion."')";	
	   
	}   
	Else
	{
		$Instruccion = "UPDATE Forma_Pago SET nombre='".$Nombre."' , recibo='".$Recibo1."', descripcion='".$Descripcion."' WHERE Id=".$Id;	
		

	}   
	//echo $Instruccion;
   $result = mysql_query($Instruccion); ?>

<div align="left">
		  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
		  <tr>
			<td bgcolor="#E4E4E4">
			  <hr color="#E4E4E4" size="1">      <div align="center"><center>
				<table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
			  <tr bgcolor="#EFEFEF">
				<td align="center" valign="top" bgcolor="#E4E4E4">
					<div align="center">
					  <center>
					<table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
					  <tr>
						<td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
						  <tr>
							<td colspan="3" align="left" class="style45">
							  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
								<tr>
								  <td valign="top"><div align="center">
									<table width="95%"  border="0" cellpadding="1" cellspacing="1">
																		  <tr>
										<td width="50%" class="style49"><div align="right">Nombre Forma de Pago</div></td>
										<td width="50%" class="style43"><div align="left">  <?echo $Nombre;?></div></td>
									  </tr>
									   <tr>
										<td width="50%" class="style49"><div align="right">Recibo</div></td>
										<td width="50%" class="style43"><div align="left">
										<? if ($Recibo=="ON"){echo 'YES';} else {echo 'NO';}?></div></td>
									  </tr>
									  <tr>
										<td width="50%" class="style49"><div align="right">Descripcion</div></td>
										<td width="50%" class="style43"><div align="left"><?echo $Descripcion; ?></div></td>
									  </tr>
									  <tr>
										<td colspan="2" class="style49"><div align="right"></div>                                  
											<div align="center">
											 <? if ($dedonde==0)
											  { ?>
											   <a href="form_pago.php?dedonde=0"><? echo $Mensajes["h-1"]; ?></a>
											  <?
											  } else { ?>
											   <a href="elige_forma_pago.php" >Modificar Otra Forma de Pago</a>
											  <? } ?>  						  
										   </div></td>
										</tr>
									
			

				</table>
									</div>                            
									</td>
								  </tr>
							  </table>
							</td>
						  </tr>
						</table>
				</td>
              </tr>
            </table>
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style33"><a href="../admin/indexadm.php" target="_self"><? echo $Mensajes["h-3"]; ?></a></span> </div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  <?
   Desconectar();
?>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">fcg-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>




