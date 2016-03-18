<?php

include('../../conexiones_config.php');

if (isset($_GET['acc'])) {
    $acc = $_GET['acc'];
    _bienvenido_mysql();

    if ($acc == 'Proveedores') {

        $sqlcode = "SELECT a.id_proveedor,a.nombre,a.direccion,a.rif FROM fas_proveedores a WHERE a.nombre LIKE '%".$_GET['buscar']."%'";
        $sql = mysql_query($sqlcode);
        $i=0;
        while ($result = mysql_fetch_array($sql)) {
            $datos[$i] = array(
                'proveedor' => $result['id_proveedor'],
                'nombre' => $result['nombre'],
                'direccion' => $result['direccion'],
                'rif' => $result['rif']
            );
            $i++;
        }

        echo json_encode($datos);
    }
    if ($acc == '') {
        
    }
    if ($acc == '') {
        
    }



    _adios_mysql();
}
?>