<?
    
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";  
   Conexion();	
   include_once "../inc/"."identif.php"; 
   Administracion();

   if (! isset($dedonde))		$dedonde=0;
   if (! isset($Contenidos))	$Contenidos="";
   if (! isset($Seccion))	$Seccion="";

   
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
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 9px;
}
-->
</style>
<base target="_self">
</head>
<?	  
	    include_once "../inc/"."fgenped.php";
  	    include_once "../inc/"."fgentrad.php";
		global $IdiomaSitio;
	    $Mensajes = Comienzo ("eco-002",$IdiomaSitio);
 ?>

<script language="JavaScript">
tabla_Secciones = new Array;
tabla_val_Secc = new Array;
tabla_Long_Secc = new Array; 
tabla_Idiomas = new Array;
tabla_val_Idiomas = new Array;
tabla_Contenidos = new Array;
tabla_val_Cont = new Array;
tabla_Long_Cont = new Array; 

// Estas representan las opciones que usan Institucion y Dependencia
// lo devuelve como un vector la funcion PHP y se comparan desde
// JavaScript

vector_usa = [<? echo Devuelve_Inst(); ?>];

  <?	  
  		 $Instruccion = "SELECT Id,Nombre FROM Idiomas ORDER BY Nombre";	
         $result = mysql_query($Instruccion);   
         if (mysql_num_rows($result)>0)
         {
           $contidiomas=0;
           while ($row =mysql_fetch_row($result))
           {
             echo "tabla_Idiomas[".$contidiomas."]='".$row[1]."';\n";
             echo "tabla_val_Idiomas[".$contidiomas."]=".$row[0].";\n";
             $contidiomas ++;
             
           }
           echo "contidiomas=".$contidiomas;
         }  
  		  
         echo "// Armo el vector de Instituciones\n";
         echo "\n";
                   
         $Instruccion = "SELECT Codigo_Idioma,Nombre,Id FROM Secciones ORDER BY Codigo_Idioma,Orden,Nombre";	
         $result = mysql_query($Instruccion);  
		 $cod_anterior = "";
         if (mysql_num_rows($result)>0)
         {
           while ($row =mysql_fetch_row($result))
           {

           	 If ($cod_anterior !=$row[0])
           	 {
					$cod_anterior = $row[0];
					$Indice[$row[0]]=0;
					echo "\n";
            		echo "tabla_Secciones[".$row[0]."]=new Array;\n";
            		echo "tabla_val_Secc[".$row[0]."]=new Array;\n";            
        	     }
			 $pos = $Indice[$row[0]];
           	 echo "tabla_Secciones[".$row[0]."][".$pos."]='".$row[1]."';\n";
             echo "tabla_val_Secc[".$row[0]."][".$pos."]=".$row[2].";\n";
           
               $Indice[$row[0]]+=1;
            }
          
            echo "//Reflejo las longitudes de los vectores\n";
            while (list($key,$valor)=each($Indice))
            {	
          		echo "tabla_Long_Secc[".$key."]=".$valor.";\n";
            }		                              
         }
         
		echo "\n";
        echo "//Armo el vector de Dependencias \n";
	
         $Instruccion = "SELECT Id_Seccion,Titulo,Id FROM Contenidos ORDER BY Id_Seccion,Orden,Titulo";	
         $result = mysql_query($Instruccion);   
		 $cod_anterior_seccion = "";
         if (mysql_num_rows($result)>0)
		  {
           while ($row =mysql_fetch_row($result))
           {            
           		
          If ($cod_anterior_seccion  != $row[0])
           	 {
			      $cod_anterior_seccion = $row[0];
                  $Ind[$row[0]]=0;
            	  echo "tabla_Contenidos[".$row[0]."]=new Array;\n";
            	  echo "tabla_val_Cont[".$row[0]."]=new Array;\n";
				  echo "\n";	
        	     }
			 $pos = $Ind[$row[0]];
           	 echo "tabla_Contenidos[".$row[0]."][".$pos."]='".$row[1]."';\n";
             echo "tabla_val_Cont[".$row[0]."][".$pos."]=".$row[2].";\n";
           
               $Ind[$row[0]]+=1;
            }
          
            echo "//Reflejo las longitudes de los vectores\n";
            echo "\n";
            
            while (list($key1,$valor1)=each($Ind))
            {
          		   echo "tabla_Long_Cont[".$key1."]=".$valor1.";\n";
            }		                              
         }
    ?>
    
function Generar_Contenidos (ContSel){     

        		Codigo_Seccion=document.forms.form1.Secciones.options[document.forms.form1.Secciones.selectedIndex].value;    			
        		if (tabla_Long_Cont[Codigo_Seccion]!=null)
        		{
        		 seleccion = 0;
     			 document.forms.form1.Contenidos.length =tabla_Long_Cont[Codigo_Seccion]+1;    			
      			 for (i=0;i<tabla_Long_Cont[Codigo_Seccion];i++)
                {             	
                 document.forms.form1.Contenidos.options[i].text=tabla_Contenidos [Codigo_Seccion][i];
                 if (tabla_val_Cont [Codigo_Seccion][i]==ContSel)
                 {
                   seleccion = i;
                 }
                 document.forms.form1.Contenidos.options[i].value=tabla_val_Cont [Codigo_Seccion][i];
                }       
                document.forms.form1.Contenidos.length=i;	 
     			
              document.forms.form1.Contenidos.selectedIndex=seleccion;
			  return null;
			   }
			   else
			   {       		
			    	document.forms.form1.Contenidos.length = 0;			    	

			   } 
		}	    		

function Generar_Secciones(SeccSel,ContSel)
{     

          if (document.forms.form1.Idiomas.length>0)
          {
              seleccion = 0;
    		  Codigo_Idioma=document.forms.form1.Idiomas.options[document.forms.form1.Idiomas.selectedIndex].value;    			
    		  if (tabla_Long_Secc[Codigo_Idioma]!=null)
              {
     			  document.forms.form1.Secciones.length = tabla_Long_Secc[Codigo_Idioma]+1;    			
     			  for (i=0;i<tabla_Long_Secc[Codigo_Idioma];i++)
                  {             	
                    document.forms.form1.Secciones.options[i].text=tabla_Secciones [Codigo_Idioma][i];
                    if (tabla_val_Secc [Codigo_Idioma][i]==SeccSel)
                      { seleccion = i; }
                 
                    document.forms.form1.Secciones.options[i].value=tabla_val_Secc [Codigo_Idioma][i];
                  }       
                  document.forms.form1.Secciones.length=i;	 
     			
                  document.forms.form1.Secciones.selectedIndex=seleccion;
			      Generar_Contenidos(ContSel);
			   }
			   else
			   {
			    	document.forms.form1.Secciones.length = 0;
			    	document.forms.form1.Contenidos.length = 0;			    	
			   } 
			}    
  			return null;
}	    
		
function Generar_Idiomas (IdiomaSel){     
    
            document.forms.form1.Idiomas.length = <? echo $contidiomas; ?>;
            seleccion = 0;
     		for (i=0;i<<? echo $contidiomas; ?>;i++)
            {             	
                 document.forms.form1.Idiomas.options[i].text=tabla_Idiomas [i];
                 document.forms.form1.Idiomas.options[i].value=tabla_val_Idiomas [i];
                 if (tabla_val_Idiomas [i]==IdiomaSel)
                 {
                   seleccion = i;
                 }

            }       
            document.forms.form1.Idiomas.length=i;	      			
            document.forms.form1.Idiomas.selectedIndex=seleccion;
			return null;
		}	    
		
function confirmar()
 {
 	if (confirm("<? echo $Mensajes["pre-1"]; ?>"))
 	{
 		return true
 	}
 	else
 	{
 		return false
 	}
 	
 }    
</script>    

<body topmargin="0">

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr>
        <td valign="top">            <div align="center">
              <center>
    <?      
      if ($dedonde==2)
     {
      	 
		 		  $expresion = "SELECT Archivo_Elemento FROM ElemContenidos WHERE Id=".$Id; 	
				  $result = mysql_query($expresion);
				  $row = mysql_fetch_row($result);
				  //unlink (Destino().$row[0]);
				  
		          $expresion = "DELETE FROM ElemContenidos WHERE Id=".$Id;                 	   
      		      $result = mysql_query($expresion);
		       	
        
      }
             
      if ($Contenidos==0)
      {      	
     ?> 
     <form name="form1" method="POST" action="elige_econt.php">
    
				
				<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["et-1"]; ?></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
                        <tr>
                          <td width="150" class="style22"><div align="right"><? echo $Mensajes["ec-1"]; ?></div></td>
                          <td>
                            <div align="left">
                            <select class="style22" size="1" name="Idiomas" onChange="Generar_Secciones(0,0)"">             
                            </select>
                          </div></td>
                        </tr>
                       <tr>
            <td width="150" class="style22"><div align="right"><? echo $Mensajes["ec-2"]; ?></div></td>
                          <td>
                            <div align="left">
                            <select class="style22" size="1" name="Secciones" onChange="Generar_Contenidos()">
              </select></td>
                     </tr>  
						<tr>
            <td width="150" class="style22"><div align="right"><? echo $Mensajes["ec-3"]; ?></div></td>
                          <td>
                            <div align="left">
                            <select size="1" name="Contenidos" class="style22">             
              </select></td>
                     </tr>			
						


						
						<tr>
                          <td>&nbsp;</td>
                          <td><input type="submit" class="style22" value="<? echo $Mensajes["bot-4"]; ?>" name="B1">    </td>
                        </tr>
                      </table>
    </form>
   
					  </div>                      </td>
                    </tr>
                </table>
    <?
      }
     else
     { 
     ?>    


<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"> <? echo $Mensajes["ec-7"];?> </span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
<?   
  
   $expresion = "SELECT Archivo_Elemento,Nombre,Id FROM ElemContenidos WHERE Id_Contenido=".$Contenidos." ORDER BY Orden";   
   $result = mysql_query($expresion);
     
   while ($row = mysql_fetch_array($result))
   {
  
?><br>
    </p>
    <div align="center">
      <center>
         <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
                <tr>
                   <td width="150" class="style22"><div align="right"><? echo $Mensajes["ec-6"]; ?></div></td>
                          <td class="style33"><? echo $row[0]." - ".$row[1]; ?></td>
                        </tr>
                        <tr>
                          <td><div align="right"></div></td>
                          <td><div align="right" class="style33"><a href="elige_econt.php?dedonde=2&Id=<? echo $row[2]; ?>&Contenidos=<? echo $Contenidos; ?>" ><? echo $Mensajes["et-3"]; ?></a>|<a href="elige_cont.php?dedonde=2&Id=<? echo $row[1]; ?>&Seccion=<? echo $Seccion; ?>" onClick="return confirmar()"><? echo $Mensajes["et-2"]; ?> </a></div></td>
                        </tr>
                      </table>

      </center>
    </div>

<?
 }
	 ?> 


   </td>
 </tr>
 </table>
 <?
  mysql_free_result ($result);
  
	 }

 
  
?>
                </center>
            </div>            </td>
        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#ECECEC"><div align="center">
                          <p><img src="../images/image001.jpg" width="150" height="118"><br>
                              <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-2"];?></a></span></p>
                      </div></td>
                    </tr>
                  </table>
                  </div></td>
              </tr>
            </table>
            </div>
        </div></td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
    
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">eco-002</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>

<?
	 Desconectar();
  
if ($Contenidos==0)
{
?>
<script language="JavaScript">
  Generar_Idiomas(0); 
  Generar_Secciones(0,0);
</script>
<? }
?>
