<?php
function writeMenu($active) {
?>
<div id="menuPrincipal">
    <ul class="littleSmaller">
        <li <?php if($active==1) { ?>class="active"<?php } ?>><a href="./index.php">Gestionar Periodicidades</a></li>
        <li <?php if($active==2) { ?>class="active"<?php } ?>><a href="./registro.php">Registrar Nueva Periodicidad</a></li>
        <li <?php if($active==3) { ?>class="active"<?php } ?>><a href="./inactivos.php">Periodicidades Inactivas</a></li>
    </ul>            
</div>

<script type="text/javascript">
    calculateWidthMenu();
    //Para que arregle el menu al cambiar el tamaño de la página
    $(window).resize(function() {
         calculateWidthMenu();
    }); 
</script>
<?php } ?>