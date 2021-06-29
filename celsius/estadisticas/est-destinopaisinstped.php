<?
$pageName = "estadisticas1";
require_once "../common/includes.php";
require_once "metodos_estadisticas.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?


// Estas funciones son específicas de cálculo
// mas abajo están las específicas de graficación

function Calcular() {
	global $result;
	global $Suma_Total;
	global $Total_General;
	global $Anio;
	global $row;
	global $SumaAnios;
	global $SumaPaises;
	global $hash;

	while ($rowg = mysql_fetch_row($result)) {
		// Si $rowg[3]==0 implica que son Pedidos Cancelados
		// que no llegaron a pedirse a ningun país

		if ($rowg[3] > 0) {

			$filacorrecta = $hash[$rowg[3]];

			$row[$filacorrecta][$rowg[0] - $Anio +1] += $rowg[2];
			$SumaAnios[$rowg[0] - $Anio +1] += $rowg[2];
			$SumaPaises[$filacorrecta] += $rowg[2];
			$Total_General += $rowg[2];
		}

	}

}

function Armar_Instruccion($dedonde) {
	global $TPed;
	global $Anio;
	global $AnioFinal;
	global $Caja;
	global $Pais;

	$Instruccion = "SELECT YEAR(Fecha_Alta_Pedido) AS p,instituciones.Nombre,COUNT(*),Ultima_Institucion_Solicitado ";
	if ($dedonde == 1) {
		$Instruccion .= "FROM pedhist ";
		$Instruccion .= "LEFT JOIN instituciones ON instituciones.Codigo=pedhist.Ultima_Institucion_Solicitado ";
	} else {
		$Instruccion .= "FROM pedidos ";
		$Instruccion .= "LEFT JOIN instituciones ON instituciones.Codigo=pedidos.Ultima_Institucion_Solicitado ";
	}
	$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal . " AND Ultimo_Pais_Solicitado=" . $Pais;
	$Instruccion .= " AND Tipo_Pedido=" . $TPed;

	if ($Caja == ESTADO__ENTREGADO_IMPRESO || $Caja == ESTADO__CANCELADO) {
		if ($dedonde == 1) {
			$Instruccion .= " AND Estado=" . $Caja;
		} else {
			$Instruccion .= " AND Estado=" . ESTADO__RECIBIDO;
		}
	}
	if ($Caja == ESTADO__DESCAGADO_POR_EL_USUARIO || $Caja == ESTADO__CANCELADO) {
		if ($dedonde == 1) {
			$Instruccion .= " AND Estado=" . $Caja;
		} else {
			$Instruccion .= " AND Estado=" . ESTADO__LISTO_PARA_BAJARSE;
		}
	}

	$Instruccion .= " GROUP BY p,Ultima_Institucion_Solicitado";
	$Instruccion .= " ORDER BY p,instituciones.Nombre";

	return $Instruccion;
}

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>

<title>PrEBi </title>
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
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
	color: #000000;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style54 {font-family: verdana; font-size: 10px; color: #000000; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style63 {
	font-size: 9px;
	font-family: Arial, Helvetica, sans-serif;
}
.style66 {color: #FFFFFF}
-->
</style>
<base target="_self">
<link rel="stylesheet" type="text/css" href="../css/celsiusStyles.css">
</head>

<body topmargin="0">
<div align="left">
  <form method="POST" action="est-destinopaisinstped.php">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
            <hr color="#E4E4E4" size="1">
                  <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4">
                <table width="97%"  border="0" cellpadding="0" cellspacing="0" class="table-form">
                <tr>
                	<td height="20" colspan="2" align="left" bgcolor="#006599" class="style45"><img src="../images/square-lb.gif" width="8" height="8" border="0"/>
                   		<? echo $Mensajes["tit-28"]; ?>
                   	</td>
                </tr>
                <tr>
                    <td height="15" colspan="2" align="left" class="style45"><br>                      
                    <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
                    <tr>
                        <th width='150'>
                        	<? echo $Mensajes["tf-1"]; ?>
                        </th>
                        <td width="179" align="left">
                        	<input name="Anio" value="<? echo $Anio; ?>" type="text" class="style43" />
                        	<input type="hidden" name="TPed" value="<? echo $TPed; ?>" />
                        </td>
                        <th width='150'>
                        	<? echo $Mensajes["tf-2"]; ?>
                        </th>
                        <td width="179" align="left">
                        	<input name="AnioFinal" value="<? echo $AnioFinal; ?>" type="text" class="style54" />
                        </td>
                    </tr>
                    <tr>
                        <th width='150'>
                        	<? echo $Mensajes["tf-8"]; ?>
                        </th>
                        <td width="179" align="left">
                        	<select name="Pais" class="style54" size="1" style="width:170px">
                        	<? 
        					$paises= $servicesFacade->getPaises();
        					foreach($paises as $pais){?>
			   					<option value="<? echo $pais["Id"]; ?>" <? if ((!empty($Pais))&&($Pais == $pais["Id"])) echo "selected"?>>
			   						<? echo $pais["Nombre"]." (".$pais["Abreviatura"].")" ?>
			   					</option>	
							<?}?>
							</select>
	                   		
	                   		
	                   		       	
	                   		
	                   		
	                   		
                        </td>
                        <th width='150'>
                        	<? echo $Mensajes["tf-6"]; ?>
                        </th>
                        <td width="179" align="left">
                        	<select name="TipoGrafico" class="style54" size="1" style="width:170px"><? if (!isset($TipoGrafico)) { $TipoGrafico = 0;} ?>
                        		<option <? if ($TipoGrafico==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["otg-1"]; ?></option>
                        		<option <? if ($TipoGrafico!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["otg-2"]; ?></option>
	                        </select>
	                    </td>
                    </tr>
                    <tr>
                        <th width='150'>
                        	<? echo $Mensajes["tf-3"]; ?>
                        </th>
                        <td width="179" align="left">
                        	<select name="Modalidad" class="style54" size="1" style="width:170px"><? if (!isset($Modalidad)) { $Modalidad = 0;} ?>
                        		<option <? if ($Modalidad==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["opc-3"]; ?></option>
                        		<option <? if ($Modalidad!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["opc-4"]; ?></option>
                        	</select>
                        </td>
                        <th width='150'>&nbsp;</th>
                        <td width="179" align="left">&nbsp;</td>
                    </tr>
                    <tr>
                        <th width='150'>
                        	<? echo $Mensajes["tf-5"]; ?>
                        </th>
                        <td width="179" align="left">
                        	<select name="Caja" class="style54" size="1" style="width:170px"><? if (!isset($Caja)) { $Caja = 0;} ?>
                        		<option <? if ($Caja==0) { echo "selected"; } ?> value="0"><? echo $Mensajes["otp-1"]; ?></option>
                        		<option <? if ($Caja==ESTADO__ENTREGADO_IMPRESO) { echo "selected"; } ?> value="<? echo ESTADO__ENTREGADO_IMPRESO; ?>"><? echo $Mensajes["otp-2"]; ?></option>
								<option <? if ($Caja==ESTADO__DESCAGADO_POR_EL_USUARIO) { echo "selected"; } ?> value="<? echo ESTADO__DESCAGADO_POR_EL_USUARIO; ?>">Pedidos On-Line Entregados</option>
                        		<option <? if ($Caja==ESTADO__CANCELADO) { echo "selected"; } ?> value="<? echo ESTADO__CANCELADO; ?>"><? echo $Mensajes["otp-3"]; ?></option>
                        	</select>
                        </td>
                        <th width='150'>&nbsp;</td>
                        <td width="179">&nbsp;</td>
                    </tr>
                    <tr valign="middle">
                        <td colspan="4" class="style43">
                        	<div align="center">
                            	<input name="B1" type="submit" class="style43" value="<? echo $Mensajes["bot-1"];?>" />
                            </div>
                        </td>
                    </tr>
                    </table>
                    </form>
                    <hr></td>
                  </tr>

                        <?


if (!empty($Pais)) {
?>

  <tr valign="top">
                    <td colspan="2" align="left" class="style45">
                      <div align="left">
                        <p><span class="style54"><img src="../images/sa6.gif" width="8" height="10">
<?


	// Obtengo la tabla con todos las instituciones del país seleccionado
	$Instruccion = "SELECT Codigo,Nombre FROM instituciones WHERE Codigo_Pais=$Pais ORDER BY Nombre";
	$result = mysql_query($Instruccion);
	$tope = mysql_num_rows($result);

	// Genero el encabezado de la matriz con el nombre del país
	// y un vector que el código de país dice donde esta en la matriz
	// este pais. Necesario para mantener el orden alfabetico

	for ($i = 1; $i <= $tope; $i++) {
		$resultado = mysql_fetch_row($result);
		$row[$i][0] = $resultado[1];
		$hash[$resultado[0]] = $i;
		$de[$i] = $resultado[0];
	}

	$columnastope = $AnioFinal - $Anio +1;
	for ($filas = 1; $filas <= $tope; $filas++) {
		for ($columnas = 1; $columnas <= $columnastope; $columnas++) {
			$row[$filas][$columnas] = 0;
		}
	}

	// Inicializo otros totales la Suma por paises
	// los porcentajes por Países y las Sumas por Columnas, es decir años
	for ($filas = 1; $filas <= $tope; $filas++) {
		$SumaPaises[$filas] = 0;
		$PorcentajePaises[$filas] = 0;
	}

	for ($columnas = 1; $columnas <= $columnastope; $columnas++) {
		$SumaAnios[$columnas] = 0;
		$PorcentajeAnios[$columnas] = 0;
	}

	// Encabezo las columnas con los valores que corresponden a los años
	$Total_General = 0;
	for ($i = $Anio; $i <= $AnioFinal; $i++) {
		$row[0][$i - $Anio +1] = $i;
	}

	$Instruccion = Armar_Instruccion(1);
	$result = mysql_query($Instruccion);
	echo mysql_error();
	Calcular();
	mysql_free_result($result);

	if ($Caja != ESTADO__CANCELADO) {
		$Instruccion = Armar_Instruccion(2);
		$result = mysql_query($Instruccion);
		echo mysql_error();
		Calcular();
		mysql_free_result($result);
	}

	// Calculo los porcentajes
	for ($i = 1; $i <= $tope; $i++) {
		if ($SumaPaises[$i] > 0) {
			$PorcentajePaises[$i] = (100 * $SumaPaises[$i]) / $Total_General;
		}
	}

	for ($i = 1; $i <= $columnastope; $i++) {
		if ($SumaAnios[$i] > 0) {
			$PorcentajeAnios[$i] = (100 * $SumaAnios[$i]) / $Total_General;
		}
	}

	switch ($Caja) {
		case ESTADO__ENTREGADO_IMPRESO :
			$Titulo = $Mensajes["otp-2"];
			break;
		case ESTADO__CANCELADO :
			$Titulo = $Mensajes["otp-3"];
			break;
		default :
			$Titulo = $Mensajes["otp-1"];
			break;
	}

	$buffer = '';
	$Titulo .= " - " . $Mensajes["tit-9"];
	echo $Titulo . " - " . $Mensajes["tf-4"];
?></span></p>
                        </div>
     <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" class="style43">
        <tr bordercolor="#CCCCCC" bgcolor="#006699" class="style28">
           <td align="right"><span class="style66"><? echo $Mensajes["ec-10"]; $buffer .= $Mensajes["ec-10"];?></span></td>
          <?


	if ($Modalidad == 1) {
		for ($i = 1; $i <= $columnastope; $i++) {
?>
                   <td align="center" class="style28"><span class="style66"><? echo $row[0][$i]; $buffer .= ','.$row[0][$i]; ?></span></td>
                 <?


		}
	}
?>
                  <td align="center" class="style28"><? echo $Mensajes["ec-8"]; $buffer .= ','.$Mensajes["ec-8"];?></td>
                  <td align="center" class="style28"><? echo $Mensajes["ec-9"]; $buffer .= ','.$Mensajes["ec-9"];?></td>
              </tr>
                <?


	$buffer .= "\n";
	$descuento = 0;
	for ($i = 1; $i <= $tope; $i++) {
		if ($SumaPaises[$i] > 0) {
?>
                   <tr bordercolor="#CCCCCC">
                      <td align="right" bgcolor="#CCCCCC"><a href="est-destinodepeped.php?Anio=<? echo $Anio;?>&TPed=<? echo $TPed;?>&AnioFinal=<? echo $AnioFinal;?>&Pais=<? echo $Pais; ?>&Institucion=<? echo $de[$i];?>"><? echo $row[$i][0]; $buffer .= " \n ".$row[$i][0];?>&nbsp;</a></td>
                      <?


			// descuento sirve para descontar las filas de países que
			// no voy a contar. A fines de graficar
			if ($Modalidad == 1) {
				for ($j = 1; $j <= $columnastope; $j++) {
?>
                               <td align="center" bgcolor="#ECECEC"><? echo $row[$i][$j]; $buffer .= ','.$row[$i][$j]; ?></td>
                       	<?


				}
			}
?>
                        <td align="center" bgcolor="#ECECEC"><? echo $SumaPaises[$i]; $buffer .= ','.$SumaPaises[$i];?></td>
                        <td align="center" bgcolor="#ECECEC"><? echo number_format($PorcentajePaises[$i],2)."%"; $buffer .= ','.number_format($PorcentajePaises[$i],2)."%"; ?></td>
                        </tr>
                          <?


		} else {
			$descuento += 1;
		}
	}
?>
                      <tr bordercolor="#CCCCCC">
                       <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-3"]; $buffer .= " \n ".$Mensajes["ec-3"]; ?></td>
                             <?


	if ($Modalidad == 1) {
		for ($i = 1; $i <= $columnastope; $i++) {
?>
                                    <td align="center" bgcolor="#ECECEC"><? echo $SumaAnios[$i]; $buffer .= ','.$SumaAnios[$i];?></td>
                          <?


		}
	}
?>
                           <td align="center" bgcolor="#ECECEC"><? echo $Total_General; $buffer .= ','.$Total_General; ?></td>
                          <td align="center" bgcolor="#ECECEC"><? echo "100.00%"; $buffer .= ','."100.00%"; ?></td>
                      </tr>
                      <tr bordercolor="#CCCCCC">
                          <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-4"]; $buffer .= " \n ".$Mensajes["ec-4"]; ?></td>
                           <?


	if ($Modalidad == 1) {
		for ($i = 1; $i <= $columnastope; $i++) {
?>
                              <td align="center" bgcolor="#ECECEC"><? echo number_format($PorcentajeAnios[$i],2)."%"; $buffer .= ','.number_format($PorcentajeAnios[$i],2)."%";?></td>
                          <?


		}
	}
?>
                            <td align="center" bgcolor="#ECECEC"><? echo "100.00%"; $buffer .= ", 100.00%";?></td>
                            <td align="center" bgcolor="#ECECEC"></td>
                        </tr>
                      </table>
                      <br>
                      <hr></td>
                    <?


	// Estas funciones son específicas de
	// graficación

	function retornar_labels($Modalidad) {
		global $row;
		global $columnastope;
		global $VectorIdioma;
		global $Mensajes;

		if ($Modalidad == 1) {
			$cadena = "";
			for ($j = 1; $j <= $columnastope; $j++) {
				$cadena .= $row[0][$j] . ",";
			}
			$cadena = substr($cadena, 0, strlen($cadena) - 1);
			return "<param name=sampleLabels value=" . $cadena . ">";
		} else {
			return "<param name=sampleLabels value=" . $Mensajes["opc-4"] . ">";
		}

	}

	function retornar_series() {
		global $row;
		global $tope;
		global $SumaPaises;

		$cadena = "";
		for ($j = 1; $j <= $tope; $j++) {
			if ($SumaPaises[$j] > 0) {
				$cadena .= $row[$j][0] . ",";
			}
		}
		$cadena = substr($cadena, 0, strlen($cadena) - 1);
		return "<param name=seriesLabels value=\"" . $cadena . "\">";

	}

	function retornar_valores($Modalidad) {
		global $row;
		global $tope;
		global $columnastope;
		global $SumaPaises;

		$valores = "";
		$indice = 0;
		for ($j = 1; $j <= $tope; $j++) {
			if ($SumaPaises[$j] > 0) {
				$cadena = "";
				if ($Modalidad == 1) {
					for ($i = 1; $i <= $columnastope; $i++) {
						$cadena .= $row[$j][$i] . ",";
					}
				} else {
					$cadena = $SumaPaises[$j] . ",";
				}

				$cadena = substr($cadena, 0, strlen($cadena) - 1);
				$valores .= "<param name=sampleValues_" . $indice++ . " value=" . $cadena . ">\n";
			}
		}
		return $valores;
	}
?>

                    </tr>
                  <tr valign="top">
                    <td colspan="2" align="left" class="style45"><p class="style54"><img src="../images/sa6.gif" width="8" height="10"> <? echo $Mensajes["mensaje.distribucionPorInstitucion"]?> </p>
                      <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>	<?


	// Calculo el tamaño del gráfico de acuerdo a la cantidad
	// de series a presentar

	$alto = 580;
	$ancho = 270;
?>
 	<?


	if ($TipoGrafico == 1) {
?>

		<applet code="com.objectplanet.gui.BarChartApplet" archive=com.objectplanet.gui.BarChartApplet.jar
		width=<? echo $alto; ?> height=<? echo $ancho; ?> name="BarChart" VIEWASTEXT>
		<param name=seriesCount value="<? echo ($tope - $descuento) ?>">

		<param name=sampleCount value="<?  echo $columnastope;  ?>">
		<?


		echo retornar_valores($Modalidad);
?>
		<param name=barLabelsOn value=true>
		<param name=legendOn value=true>
		<param name=valueLinesOn value=true>
		<param name=multiColorOn value=true>
		<param name=barOutlineOff value=true>
		<param name=3DModeOn value=true>
		<param name=chartTitle value="<? echo $Titulo; ?>">

		<?


		echo retornar_series();
		echo retornar_labels($Modalidad);
?>

		<param name=barWidth value="0.6">
		<param name=titleFont value="Ms Sans Serif, bold, 14">
		<param name=sampleColors value="<? echo Opciones_Color()?>">

		<param name=multiSeriesOn value=true>
		</applet>
		<?


	} else {
?>
		<applet code=com.objectplanet.gui.PieChartApplet archive=com.objectplanet.gui.PieChartApplet.jar
		   width=<? echo $alto; ?> height=<? echo $ancho; ?>>
		<param name=seriesCount value="<? echo ($tope - $descuento); ?>">
		<?


		echo retornar_valores($Modalidad);
?>
		<param name=chartTitle value="<? echo $Titulo; ?>">
		<?


		echo retornar_series();
		echo retornar_labels($Modalidad);
?>
		<param name=graphInsets value="-1,-1,-1,-1">
		<param name=sampleColors value=<? echo Opciones_Color(); ?>>
		<param name=titleFont value="Ms Sans Serif, bold, 14">
		<param name=valueLabelsOn value=true>
		<param name=sampleLabelsOn value=true>
		<param name=percentLabelsOn value=true>
		<param name=pieLabelsOn value=true>
		<param name=legendOn value=true>
		<param name=3DModeOn value=true>
		<param name=sliceSeperatorOn value=true>
		<PARAM NAME="selectionstyle" VALUE="detached">
		<PARAM NAME="detacheddistance" VALUE="0.2">
		</applet>

		<? } ?></td>
                        </tr>
                      </table>
                      <div align="right"><br>
                      </div>
                      <div align="center"><a href='javascript:direct_export()'><img src="../images/files/xls.jpg" width="17" height="17" border="0"></a></div></td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118" border="0"><br>
                <span class="style54"><a href="main-estadisticas.php"><? echo $Mensajes["h-1"]; ?></a></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  <form name="formExport" action="exp_est.php">
  <input type='hidden' name='datos' value='<? echo $buffer; ?>'>
  <input type='hidden' name='mifilename' value='destinopaisinstped.csv'>

</form>

<script>
function direct_export()
{
  document.forms.formExport.submit();
}
</script>

<?


	}
else {
?>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	<td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">

          <table width="100%" bgcolor="#ececec">
            <tr>

              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118" border="0"><br>


                <span class="style54"><a href="main-estadisticas.php"><? echo $Mensajes["h-1"]?></a></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
</td>
<hr>
 <?


}
?>
        <?php


DibujarBarraInferior();
?>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logos/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11 style63">npm-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>
