<?
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";
   Conexion();	
   include_once "../inc/"."identif.php";
   Administracion();
   global  $IdiomaSitio ; 
   if (! isset($Id))	 $Id="";
   if (! isset($operacion))	 $operacion=0;

   
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
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
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 11px;
}
.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
.style39 {color: #006699}
.style40 {
	color: #FFFFFF;
	font-family: Verdana;
	font-size: 11px;
}
.style41 {color: #006599}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
   $Mensajes = Comienzo ("pau-001",$IdiomaSitio);
  
   
?>
<script language="JavaScript">

tabla_Instituciones = new Array;
tabla_val_Instit = new Array;
tabla_Long_Instit = new Array; 
tabla_Paises = new Array;
tabla_val_Paises = new Array;
tabla_Dependencias = new Array;
tabla_val_Dep = new Array;
tabla_Long_Dep = new Array; 

// Estas representan las opciones que usan Institucion y Dependencia
// lo devuelve como un vector la funcion PHP y se comparan desde
// JavaScript

vector_usa = [<? echo Devuelve_Inst(); ?>];

<?

		include_once "../inc/pidu.inc.php";
		armarScriptInstituciones("tabla_Instituciones" , "tabla_val_Instit" , "tabla_Long_Instit");	
		armarScriptDependencia("tabla_Dependencias" , "tabla_val_Dep" , "tabla_Long_Dep");			
		armarScriptPaises("tabla_Paises" , "tabla_val_Paises")



     
		

?>    
function Generar_Dependencias (DepSel){     

        	    	Codigo_Instit=document.forms.form1.Instituciones.options[document.forms.form1.Instituciones.selectedIndex].value;    			
        		if (tabla_Long_Dep[Codigo_Instit]!=null)
        		{
        		 seleccion = 0;
     			 
				 document.forms.form1.Dependencias.length =tabla_Long_Dep[Codigo_Instit]+1;    			
      			 
				 for (i=0;i<tabla_Long_Dep[Codigo_Instit];i++)
                {             	
                 document.forms.form1.Dependencias.options[i].text=tabla_Dependencias [Codigo_Instit][i];
                 if (tabla_val_Dep [Codigo_Instit][i]==DepSel)
                 {
                   seleccion = i;
                 }
                 document.forms.form1.Dependencias.options[i].value=tabla_val_Dep [Codigo_Instit][i];
                }       
                document.forms.form1.Dependencias.length=i;	 
     			
              document.forms.form1.Dependencias.selectedIndex=seleccion;
			    return null;
			   }
			   else
			   {       		
			    	document.forms.form1.Dependencias.length = 0;			    	

			   } 
		}	    		

function Generar_Instituciones(InstSel,DepSel)
{     

         
		  if (document.forms.form1.Paises.length>0)
          {
              seleccion = 0;
    			Codigo_Pais=document.forms.form1.Paises.options[document.forms.form1.Paises.selectedIndex].value;    			
    			if (tabla_Long_Instit[Codigo_Pais]!=null)
              {
	   			  document.forms.form1.Instituciones.length = tabla_Long_Instit[Codigo_Pais]+1;    			
     			  for (i=0;i<tabla_Long_Instit[Codigo_Pais];i++)
                {             	
                 document.forms.form1.Instituciones.options[i].text=tabla_Instituciones [Codigo_Pais][i];
                 if (tabla_val_Instit [Codigo_Pais][i]==InstSel)
                 { seleccion = i; }
                 
                 document.forms.form1.Instituciones.options[i].value=tabla_val_Instit [Codigo_Pais][i];
                }       
                document.forms.form1.Instituciones.length=i;	 
     			
               document.forms.form1.Instituciones.selectedIndex=seleccion;
			   
                Generar_Dependencias(DepSel);
			     }
			    else
			    {
			    	document.forms.form1.Instituciones.length = 0;
			    	document.forms.form1.Dependencias.length = 0;			    	
			    } 
			}    
  			return null;
}	    
		
function Generar_Paises (PaisSel){     
    
          window.document.forms.form1.Paises.length = contpaises;
          seleccion = 0;
     		for (i=0;i<contpaises;i++)
                {             	
                 window.document.forms.form1.Paises.options[i]=new Option(tabla_Paises [i],tabla_val_Paises [i]);
                 if (tabla_val_Paises [i]==PaisSel)
                 {
                   seleccion = i;
                 }

                }       
            window.document.forms.form1.Paises.length=i;	      			
            window.document.forms.form1.Paises.selectedIndex=seleccion;
            
		}	    

function verifica_Apellido()
{
	
	if (document.forms.form1.Apellido.value.length==0 || document.forms.form1.Apellido.value.substring(0,3)=="***")	 
		{
		  document.forms.form1.Apellido.value = "*** <? echo $Mensajes["me-1"];?>";
		  return false;
		}
    else
       {
         return true;
      }
 }        
 
function verifica_Nombre()
{
	if (document.forms.form1.Nombres.value.length==0 || document.forms.form1.Nombres.value.substring(0,3)=="***")	 
		{
		  document.forms.form1.Nombres.value = "*** <? echo $Mensajes["me-1"];?>";
		  return false;
		}
    else
       {
         return true;
      }
 }        
 
function verifica_Email()
{
	if (document.forms.form1.Mail.value.length==0 || document.forms.form1.Mail.value.substring(0,3)=="***")	 
		{
		  document.forms.form1.Mail.value = "*** <? echo $Mensajes["me-1"];?>";
		  return false;
		}
   else {
         if (document.forms.form1.Mail.value.indexOf('@',0)== -1 || document.forms.form1.Mail.value.indexOf('.',0)== -1)
           {
       		  document.forms.form1.Mail.value = "*** <? echo $Mensajes["me-2"];?>";
	            return false; }
		  else {
		      return true; }
         } 

}         

function verifica_Pais()
{
	if (document.forms.form1.Paises.value==0)	 
		{
			alert ("<? echo $Mensajes["me-3"];?>")
			return false;
		}
	else
	{
		return true;
	}	

}         

function verifica_Institucion()
{
	if (document.forms.form1.Instituciones.value==0)	 
		{
			alert ("<? echo $Mensajes["me-4"];?>")
			return false;
		}
	else
	{
		return true;	
	}
	
}

function enviar_campos (){
// Estos campos los envío para presentarle al usuario

	   document.forms.form1.InstDesc.value=document.forms.form1.Instituciones.options[document.forms.form1.Instituciones.selectedIndex].text;
	   if (document.forms.form1.Dependencias.selectedIndex>=0)
	   {
        document.forms.form1.DepDesc.value=document.forms.form1.Dependencias.options[document.forms.form1.Dependencias.selectedIndex].text;			  
      }
      else
      {
      	 document.forms.form1.DepDesc.value="<? echo $Mensajes["me-5"];?>";      
      }  
      return null;			    
}

          
function verifica_campos()
{
	valor1 = true;
	valor1 = (valor1 && verifica_Apellido());
	valor1 = (valor1 && verifica_Nombre());	
	valor1 = (valor1 && verifica_Email());
   valor1 = (valor1 && verifica_Pais());
   valor1 = (valor1 && verifica_Institucion());

	if (valor1==true)
	{
		enviar_campos();
      
       document.forms.form1.action = "form_usu2.php";
		document.forms.form1.submit();
	} 
	
} 		
</script>    

<?
 if ($operacion==1)
  {
   $expresion = "SELECT Apellido,Nombres,EMail,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia";
   $expresion = $expresion.",Direccion,Codigo_Categoria,Telefonos,Codigo_Unidad,Codigo_Localidad,Login,Password,Comentarios,"; 
   $expresion = $expresion."Codigo_FormaPago,Personal,Bibliotecario,Staff,Orden_Staff,Cargo ";
   $expresion = $expresion."FROM Usuarios WHERE Usuarios.Id =".$Id;
   $result = mysql_query($expresion);
   
   echo mysql_error();
   $rowg = mysql_fetch_row($result);   
   
  }	
?>


<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">            <div align="center">
              <center>
               <form name="form1" method="POST"  onSubmit ="return false">
			    <?  ?>
				<input type="hidden" name="Localidadval" value =" <? if ( isset($rowg)) echo $rowg[10]; ?>">
                <input type="hidden" name="Loginv" value =" <? if ( isset($rowg)) echo $rowg[11]; ?>">
                <input type="hidden" name="Passwordv" value =" <? if ( isset($rowg)) echo $rowg[12]; ?>">
                <input type="hidden" name="Unidadval" value =" <? if ( isset($rowg)) echo $rowg[9]; ?>">
		        <input type="hidden" name="Comentariosval" value =" <? if ( isset($rowg)) echo $rowg[13]; ?>">
	         	<input type="hidden" name="FormaPagoval" value =" <? if ( isset($rowg)) echo $rowg[14]; ?>">
		        <input type="hidden" name="Personalval" value =" <? if ( isset($rowg)) echo $rowg[15]; ?>">
		        <input type="hidden" name="Bibliotecarioval" value =" <? if ( isset($rowg)) echo $rowg[16]; ?>">
		        <input type="hidden" name="Staffval" value =" <? if ( isset($rowg)) echo $rowg[17]; ?>">
		        <input type="hidden" name="OrdenStaffval" value =" <? if ( isset($rowg)) echo $rowg[18]; ?>">
		        <input type="hidden" name="CargoStaffval" value =" <? if ( isset($rowg)) echo $rowg[19]; ?>">
		        <input type="hidden" name="InstDesc">
                <input type="hidden" name="DepDesc">
                <input type="hidden" name="operacion" value="<? echo $operacion; ?>">
 	            <input type="hidden" name="Id" value="<? echo $Id; ?>">

				<table width="97%">
                  <tr>
                    <td height="20" colspan="2" align="right" valign="middle" bgcolor="#006699" class="style22"><div align="left" class="style40"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?></div></td>
                    </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-1"]; ?></div></td>
                    <td width="*" height="20" align="left" valign="top" >
                      <div align="left">
                        <input type="text" class="style22" name="Apellido" size="54" value="<? if ( isset($rowg)) echo $rowg[0]; ?>">
                      </div></td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-2"]; ?></div></td>
                    <td height="20" align="left" valign="top">
                      <div align="left">
                     <input type="text" name="Nombres" size="54" class="style22" value="<? if ( isset($rowg)) echo $rowg[1]; ?>">
                      </div></td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-3"]; ?></div></td>
                    <td height="20" align="left" valign="top">
                      <div align="left">
                        <input type="text" name="Mail" size="54" class="style22" value="<? if ( isset($rowg)) echo $rowg[2]; ?>">
						
                          </div></td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-4"]; ?></div></td>
                    <td height="20" align="left" valign="top"><select name="Paises" class="style22" onChange="Generar_Instituciones()">		         
                   </select>
      </td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-5"]; ?></div></td>
                    <td height="20" align="left" valign="top"><select size="1" class="style22" name="Instituciones" OnChange="Generar_Dependencias()">
               </select>    </td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-6"]; ?></div></td>
                    <td height="20" align="left" valign="top"><select name="Dependencias" class="style22">
        </select>                     </td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-7"]; ?></div></td>
                    <td height="20" align="left" valign="top"> <input type="text" name="Direccion" size="41" value="<? if ( isset($rowg)) echo $rowg[6]; ?>" class="style22"> </td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><? echo $Mensajes["et-8"]; ?></td>
                    <td height="20" align="left" valign="top"> <input type="text" name="Telefono" size="41" value="<? if ( isset($rowg)) echo $rowg[8]; ?>" class="style22" ></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><? echo $Mensajes["et-9"]; ?></td>
                    <td height="20" align="left" valign="top"><select name="Categoria" size="1" class="style22">
						  <?
						  $Instruccion = "SELECT Id,Nombre FROM Tab_Categ_usuarios ORDER BY Nombre";	
						  $result = mysql_query($Instruccion); 
						  while ($row =mysql_fetch_row($result))
						  {

							 if( isset($rowg) && ($row[0]==$rowg[7])){    
										echo "<option selected value='".$row[0]."'>".$row[1]."</option>";}
							 else { echo "<option value='".$row[0]."'>".$row[1]."</option>";}          
										
						   }       
						?>
						</select></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="style22"><div align="right"></div>                      
                      <div align="center">
                        <input type="submit" class="style22" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" onClick="verifica_campos()">
						<input type="reset" class="style22" value="<? echo $Mensajes["bot-2"]; ?>" name="B2">                 
                      </div></td>
                    </tr>
                </table>
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#Ececec"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes['et-006']; ?></a></span></p>
                  </div>                  </td>
              </tr>
            </table>
            </div>
        </div></td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  <?
   include_once "../inc/barrainferior.php";
   DibujarBarraInferior($IdiomaSitio)

  ?>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">pau-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
 </form>
<script language='JavaScript'>
 <? if ( isset($rowg))  { ?>
	Generar_Paises(<? echo $rowg[3]; ?>);<?
	
	if ($operacion==1) {?>
		Generar_Instituciones(<? echo $rowg[4].",".$rowg[5]; ?>);<? 
		} 
		else 
		{ ?>
		Generar_Instituciones();<?
		} 
	}
	else
	{?>
		Generar_Paises(0);
		Generar_Instituciones();
		<?
	}
	?>


</script>    
<? 
   mysql_free_result($result);
	Desconectar();
 ?>
</div>
</body>
</html>