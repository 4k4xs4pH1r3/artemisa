<?
$pageName = "estadisticas1";
require_once "../common/includes.php";
require_once "metodos_estadisticas.php";
?>
<?

require "../layouts/top_layout_admin.php";
// Estas funciones son específicas de cálculo
// mas abajo están las específicas de graficación

function Calcular() {
	global $result;
	global $Modalidad;
	global $Suma_Total;
	global $Total_General;
	global $Anio;
	global $columnas;
	global $row;

	while ($rowg = mysql_fetch_row($result)) {

		if ($Modalidad == 1) {
			$row[$rowg[2]][$rowg[1]] += $rowg[3];
			$row[$rowg[2]][13] += $rowg[3];
			$Suma_Total[$rowg[1]] += $rowg[3];
			$Total_General += $rowg[3];
		} else {

			$row[$rowg[1]][$rowg[0] - $Anio +1] += $rowg[2];
			$row[$rowg[1]][$columnas +1] += $rowg[2];
			$Suma_Total[$rowg[0] - $Anio +1] += $rowg[2];
			$Total_General += $rowg[2];
		}

	}

}

function Armar_Instruccion($dedonde) {
	global $Modalidad;
	global $TPed;
	global $Anio;
	global $AnioFinal;
	global $Caja;

	if ($Modalidad == 1) {
		$Instruccion = "SELECT YEAR(Fecha_Alta_Pedido) AS p, MONTH(Fecha_Alta_Pedido) AS m, Tipo_Material, COUNT(*) ";
		if ($dedonde == 1) {
			$Instruccion .= "FROM pedhist ";
		} else {
			$Instruccion .= "FROM pedidos ";
		}
		$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
		$Instruccion .= " AND Tipo_Pedido=" . $TPed;
	} else {
		$Instruccion = "SELECT YEAR(Fecha_Alta_Pedido) AS p,Tipo_Material, COUNT(*) ";
		if ($dedonde == 1) {
			$Instruccion .= "FROM pedhist ";
		} else {
			$Instruccion .= "FROM pedidos ";
		}
		$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
		$Instruccion .= " AND Tipo_Pedido=" . $TPed;

	}

	if ($Caja == ESTADO__ENTREGADO_IMPRESO || $Caja == ESTADO__CANCELADO) {
		if ($dedonde == 1) {
			$Instruccion .= " AND Estado=" . $Caja;
		} else {
			$Instruccion .= " AND Estado=" . ESTADO__RECIBIDO;
		}
	}

	if ($Modalidad == 1) {
		$Instruccion .= " GROUP BY p,m,Tipo_Material";
	} else {
		$Instruccion .= " GROUP BY p,Tipo_Material";
	}
	return $Instruccion;
}

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!isset ($Modalidad))
	$Modalidad = 2;

// Completo con cero los valores de la matriz que se 
// va a usar para presentar la tabla

$filas = 5;
for ($j = 1; $j <= $filas; $j++) {
	for ($i = 0; $i <= 13; $i++) {
		$row[$j][$i] = 0;
	}
}

// Estos son los totalizadores por columna
for ($i = 1; $i <= 13; $i++) {
	$porcentaje[$i] = 0;
	$Suma_Total[$i] = 0;
}
$Total_General = 0;

// Completo los valores apropiados para encabezados de fila
for ($i = 1; $i <= 5; $i++) {
	$row[$i][0] = TraduccionesUtils :: Traducir_Tipo_Material($VectorIdioma, $i);
}

if ($Modalidad != 1) {
	$columnas = $AnioFinal - $Anio +1;
	// Completo con los valores de columnas apropiados
	for ($i = $Anio; $i <= $AnioFinal; $i++) {
		$row[0][$i - $Anio +1] = $i;
	}

}

$Instruccion = Armar_Instruccion(1);
$result = mysql_query($Instruccion);
echo mysql_error();
Calcular($row);
mysql_free_result($result);

if ($Caja != ESTADO__CANCELADO) {
	$Instruccion = Armar_Instruccion(2);
	$result = mysql_query($Instruccion);
	echo mysql_error();
	Calcular($row);
	mysql_free_result($result);
}

// Hay que calcular porcentajes
// fijarse que Modalidad en 2 es cuando hay mas de un año
// dar posibilidad de graficar barras o columnas

if ($Modalidad == 1) {

	for ($i = 1; $i <= $filas; $i++) {
		$Suma_Total[13] += $row[$i][13];
	}

	// Calculo los porcentajes
	for ($i = 1; $i <= 13; $i++) {
		if ($Total_General > 0) {
			$porcentaje[$i] = (100 * $Suma_Total[$i]) / $Total_General;
		}

	}
} else {
	for ($i = 1; $i <= $columnas; $i++) {
		$Suma_Total[$columnas +1] += $Suma_Total[$i];
	}

	// Calculo los porcentajes
	for ($i = 1; $i <= $columnas +1; $i++) {
		if ($Total_General > 0) {
			$porcentaje[$i] = (100 * $Suma_Total[$i]) / $Total_General;
		}
	}
}
?>

<head>
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

<table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
            <form method="POST" action="est-tipomaterial.php">
              <center>
<table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" colspan="2" align="left" bgcolor="#006599" class="style45"><img src="../images/square-lb.gif" width="8" height="8" border="0"> <span class="style28"><? echo $Mensajes["ec-50"]?>	
</span></td>
                  </tr>
                  <tr>
                    <td height="15" colspan="2" align="left" class="style45"><br>                      
                    <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-1"];?></div>
                        </th>
                        <td width="179" align="left">
                        	<input name="Anio" type="text" class="style43" value="<? echo $Anio; ?>">                  
							<input type="hidden" name="TPed" value="<? echo $TPed; ?>">
						</td>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-2"];?></div>
                        </th>
                        <td width="179" align="left">
                        	<input name="AnioFinal" type="text" class="style54" value="<? echo $AnioFinal; ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-3"];?></div>
                        </th>
                        <td width="179" align="left">
                        	<select name="Modalidad" class="style54" size="1" style="width:150px">
                         		<option <? if ($Modalidad==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["opc-1"];?></option>
                         		<option <? if ($Modalidad!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["opc-2"];?></option>
       				     	</select>
       				    </td>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-6"];?></div>
                        </th>
                        <td width="179" align="left">
                        	<select name="TipoGrafico" class="style54" size="1" style="width:150px">
                        		<option <? if ($TipoGrafico==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["otg-1"];?></option>
                        		<option <? if ($TipoGrafico!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["otg-2"];?></option>
     						</select>
     					</td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-5"]; ?></div>
                        </th>
                        <td width="179" align="left">
                        	<select name="Caja" class="style54" size="1" style="width:150px">
								<option <? if ($Caja==0) { echo "selected"; } ?> value="0"><? echo $Mensajes["ec-30"]; ?></option>
                        		<option <? if ($Caja==ESTADO__ENTREGADO_IMPRESO) { echo "selected"; } ?> value="<? echo ESTADO__ENTREGADO_IMPRESO; ?>"><? echo $Mensajes["ec-28"]; ?></option>
                        		<option <? if ($Caja==ESTADO__CANCELADO) { echo "selected"; } ?> value="<? echo ESTADO__CANCELADO; ?>"><? echo $Mensajes["ec-29"]; ?></option>
		                    </select>
		                </td>
                        <th>
                        	<div align="right"></div>
                       	</th>
                        <td width="179" align="left">&nbsp;</td>
                    </tr>
                    <tr valign="middle">
                        <td colspan="4" class="style43">
                        	<div align="center">
                            	<input name="B1" type="submit" class="style43" value="<? echo $Mensajes["bot-1"];?>">                        
                          	</div>
                        </td>
                    </tr>
                    </table>                
					</form>
                      <hr></td>
                  </tr>
      
      <?

switch ($Caja) {
	case ESTADO__ENTREGADO_IMPRESO :
		$Titulo = $Mensajes["ec-28"];
		break;
	case ESTADO__CANCELADO :
		$Titulo = $Mensajes["ec-29"];
		break;
	default :
		$Titulo = $Mensajes["ec-30"];
		break;
}

if ($Modalidad == 1) {
	$Titulo .= $Mensajes["ec-46"];
} else {
	$Titulo .= $Mensajes["ec-47"];
}
?>
                  <tr valign="top">
                    <td colspan="2" align="left" class="style45">
                      <div align="left">
                        <p><span class="style54"><img src="../images/sa6.gif" width="8" height="10"><? echo $Titulo.$Mensajes["tf-4"]; ?>.</span></p>
                        </div>                      
                      <?

$buffer = '';
if ($Modalidad == 1) {
?>
					  <table width="70%"  border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" class="style43">
                        <? } else { ?>
                     <table border="0" cellpadding="1" cellspacing="1" width="60%" bordercolor="#CCCCCC" align="center" class="style43">
                        <? } ?> 
					<tr bordercolor="#CCCCCC" bgcolor="#006699" class="style28">
  				    <td align="right"><span class="style66"><? echo $Mensajes["ec-48"]?> </span></td>
                   <?

	if ($Modalidad == 1) {
		for ($i = 1; $i <= 12; $i++) {
?>    
						 	  <td align="center"><span class="style66"><?

			echo TraduccionesUtils :: Traducir_Mes($i, $VectorIdioma, true);
			$buffer .= "," . TraduccionesUtils :: Traducir_Mes($i, $VectorIdioma, true);
?></span></td>
                      <?

		}
	} else {
		// Esto va a imprimir las columnas de años correspondientes
		for ($i = 1; $i <= $columnas; $i++) {
?>   
  						  <td align="center" class="style28"><? echo $row[0][$i]; $buffer .= ','.$row[0][$i]; ?></td>
                        	<?

		}
	}
?>  
                         <td align="center" class="style28"><? echo $Mensajes["ec-49"]; $buffer .= ', '.$Mensajes["ec-49"]; ?></td>
                        
						  </tr>
						<?

	for ($i = 1; $i <= $filas; $i++) {
?>            
                        <tr bordercolor="#CCCCCC">
                          <td align="right" bgcolor="#CCCCCC"><? echo $row[$i][0]; $buffer .= "\n".$row[$i][0]; ?></td>
						    <?

		if ($Modalidad == 1) {
			$Limite = 13;
		} else {
			$Limite = $columnas +1;
		}
		for ($j = 1; $j <= $Limite; $j++) {
?>  
                                 <td align="center" bgcolor="#ECECEC"><? echo $row[$i][$j]; $buffer .= ','.$row[$i][$j]; ?></td>
                           <? } ?> 
				</tr>
                   <? } ?>
					<tr bordercolor="#CCCCCC">
                    <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-3"]; $buffer .= "\n ".$Mensajes["ec-3"]; ?></td>
              <?

			for ($i = 1; $i <= $Limite; $i++) {
?>
						  <td align="center" bgcolor="#ECECEC"><? echo $Suma_Total[$i]; $buffer .= ','.$Suma_Total[$i]; ?></td>
                   <?

			}
?> 
			</tr>
                  	<tr bordercolor="#CCCCCC">
                        <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-4"]; $buffer .= "\n ".$Mensajes["ec-4"]; ?></td>
              <?

			for ($i = 1; $i <= $Limite; $i++) {
?>    
						  <td align="center" bgcolor="#ECECEC"><? echo number_format($porcentaje[$i],2)."%"; $buffer .= ','.number_format($porcentaje[$i],2)."%"; ?></td>
				   <?

			}
?> 
                
                 </tr>
                 </table>                      
                 <br>
<?


			// Estas funciones son específicas de 
			// graficación

			function retornar_labels($Modalidad) {
				global $row;
				global $columnas;
				global $VectorIdioma;

				if ($Modalidad == 1) {
					$cadena = "";
					for ($i = 1; $i <= 12; $i++) {
						$cadena .= TraduccionesUtils :: Traducir_Mes($i, $VectorIdioma) . ",";
					}
					$cadena = substr($cadena, 0, strlen($cadena) - 1);
					return "<param name=sampleLabels value=" . $cadena . ">";
				} else {
					$cadena = "";
					for ($j = 1; $j <= $columnas; $j++) {
						$cadena .= $row[0][$j] . ",";
					}
					$cadena = substr($cadena, 0, strlen($cadena) - 1);
					return "<param name=sampleLabels value=" . $cadena . ">";
				}

			}

			function retornar_series() {
				global $row;
				global $filas;
				global $SumaPaises;

				$cadena = "";
				for ($j = 1; $j <= $filas; $j++) {
					$cadena .= $row[$j][0] . ",";

				}
				$cadena = substr($cadena, 0, strlen($cadena) - 1);
				return "<param name=seriesLabels value=\"" . $cadena . "\">";

			}

			function retornar_valores($Modalidad) {
				global $row;
				global $filas;
				global $columnas;

				$valores = "";
				for ($j = 1; $j <= $filas; $j++) {
					$cadena = "";
					if ($Modalidad == 1) {
						$Limite = 12;
					} else {
						$Limite = $columnas;
					}
					for ($i = 1; $i <= $Limite; $i++) {
						$cadena .= $row[$j][$i] . ",";
					}

					$indice = $j -1;
					$cadena = substr($cadena, 0, strlen($cadena) - 1);
					$valores .= "<param name=sampleValues_" . $indice . " value=" . $cadena . ">\n";
				}
				return $valores;
			}
?>


          <hr></td>
          </tr>
          <tr valign="top">
          <td colspan="2" align="left" class="style45"><p class="style54"><img src="../images/sa6.gif" width="8" height="10"> <? echo $Mensajes["ec-50"]; ?> </p>
          <table width="70%"  border="0" align="center" cellpadding="0" cellspacing="0">
             <tr>
              <td>				<?

			// Calculo el tamaño del gráfico de acuerdo a la cantidad
			// de series a presentar

			$alto = 580;
			$ancho = 300;
?>

   	<table width="70%">
	 <tr> <td width="70%">

			<?


			if ($TipoGrafico == 1) {
?>
		
		<applet code="com.objectplanet.gui.BarChartApplet" archive=com.objectplanet.gui.BarChartApplet.jar
		width=<? echo $alto; ?> height=<? echo $ancho; ?> name="BarChart" VIEWASTEXT>
		<param name=seriesCount value="<? echo $filas ?>">
		
		<param name=sampleCount value="<? if ($Modalidad==1) { echo "12";} else { echo $columnas; } ?>">
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
		<param name=seriesCount value="<? echo $filas; ?>">
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
		
		<? } ?>

</td>
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
        <form name="formExport" action="exp_est.php">
  			<input type='hidden' name='datos' value='<? echo $buffer; ?>'>
  			<input type='hidden' name='mifilename' value='tipomaterial.csv'>
		</form>

		<script>
			function direct_export()
			{
  			document.forms.formExport.submit();
			}
		</script>
        
        
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118" border="0"><br>
                <span class="style54"><a href="main-estadisticas.php"><? echo $Mensajes["h-1"]; ?></a></font></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>  
<?

				$pageName = "estadisticas1";
				require "../layouts/base_layout_admin.php";
?>