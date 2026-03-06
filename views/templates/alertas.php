<?php
// Si no hay alertas, no hacemos nada
// Si hay alertas, las mostramos
    foreach($alertas as $key => $mensajes): 
        foreach($mensajes as $mensaje): 
?>
        <div class="alerta <?php echo $key; ?>">
            <?php echo $mensaje; ?>
        </div>
<?php
        endforeach;
endforeach;

?>