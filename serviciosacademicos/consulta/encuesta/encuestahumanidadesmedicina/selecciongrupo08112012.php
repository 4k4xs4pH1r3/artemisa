<?php
function selecciongrupo($objetobase,$formulario,$codigoperiodo) {
    echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
    echo "	<form id=\"formescogemateria\" name=\"formescogemateria\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$idencuestaaleatorio."\">";
 $usuario=$formulario->datos_usuario();
    if($usuario["idusuario"]==4186) {
    //if(1) {
        //codigomodalidadacademica='".$_SESSION['admisiones_codigomodalidadacademica']."'
        $condicion="now()  between fechainiciocarrera and fechavencimientocarrera
                and codigomodalidadacademica like '2%' and codigocarrera in(10,11)
			order by nombrecarrera2";
        $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
        $formulario->filatmp[""]="Seleccionar";
    }
    else {
        $condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
        $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
        $formulario->filatmp[""]="Seleccionar";
    }
    $menu="menu_fila";
    $parametrosmenu="'codigocarrera','".$_POST['codigocarrera']."','onchange=\'enviar();\''";
    //$formulario->dibujar_campo($menu,$parametrosmenu,"Carrera","tdtitulogris","codigocarrera","requerido");



   /* $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta
            and e.codigocarrera='".$_POST['codigocarrera']."'";
    $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("encuesta e","idencuesta","nombreencuesta",$condicion);
    $formulario->filatmp[""]="Seleccionar";
    $menu="menu_fila";
    $condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$rowmateria["codigomateria"]."'";
    $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","e.codigocarrera",$_POST['codigocarrera']," and ".$condicion,"",0);

    $parametrosmenu="'idencuesta','".$_POST["idencuesta"]."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Encuesta","tdtitulogris","idencuesta","requerido");*/

    $condicion="m.codigomateria in (select codigomateria from encuestamateria em , encuesta e 
where em.idencuesta=e.idencuesta and e.fechafinalencuesta and e.idencuesta in(64))order by nombremateria";
    $tablas="materia m ";
    $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila($tablas, "m.codigomateria","m.nombremateria",$condicion,"",0);
    $formulario->filatmp[""]="Seleccionar";

    $parametrosmenu="'codigomateria','".$_POST["codigomateria"]."','onchange=\'enviarmateria();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Materia","tdtitulogris","codigomateria","requerido");
    
     $condicion="g.codigomateria='".$_POST["codigomateria"]."'
        and g.numerodocumento=d.numerodocumento  and
        g.codigoperiodo='".$_SESSION["codigoperiodo_autoenfermeria"]."'
        group by d.iddocente
        order by nombredocentecompleto
        ";
    $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("grupo g, docente d", "d.iddocente","concat(g.idgrupo,') ',d.apellidodocente,' ',d.nombredocente) nombredocentecompleto",$condicion,"",0,0);
    $formulario->filatmp[""]="Seleccionar";
    $parametrosmenu="'iddocente','".$_POST["iddocente"]."','onchange=\'enviar();\''";
    $formulario->dibujar_campo($menu,$parametrosmenu,"Grupo) Docente","tdtitulogris","iddocente","requerido");

    $parametrosmenu="'button','Exportar','Exportar','onclick=\'enviarexportar();\''";
    $formulario->dibujar_campo("boton_tipo",$parametrosmenu,"Enviar","tdtitulogris","exportar","");
    echo "</form></table>";
}
?>
