<?php
//CAMBIAR PARAMETROS
require("../../conexiones_config.php");
session_start();
if (!isset($_SESSION[md5('usuario_datos' . $ecret)])) {
    ir("../../index.php");
}
$usuario_datos = $_SESSION[md5('usuario_datos' . $ecret)];
$usuario_permisos = $_SESSION[md5('usuario_permisos' . $ecret)];
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
if ($_SESSION['tokeconst'] != $_GET['token']) {
    alerta('Autenticacion de token de seguridad fallido, se procederá a recargar la página, Disculpen las molestias causadas, pero recuerde que es por seguridad.');
    ir("../../dashboard.php?data=solicitud");
}
unset($_SESSION['tokeconst']);
?>
<head>  
    <?php
    $pos = strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox');
    if ($pos === false) {
        ?><link rel="stylesheet" type="text/css" href="chrome.css" /><?php
    } else {
        ?><link rel="stylesheet" type="text/css" href="mozilla.css" /><?php
    }
    ?>
</head> 
<style>
    table {
        width: 100%;
        border: 1px solid #000;

    }
    th,  td {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
        width: 25%;
        text-align: left;
        vertical-align: top;
        border: 1px solid #000;
        border-collapse: collapse;
    }
</style>
<?php
_bienvenido_mysql();
$fecha_ingreso = _dametipoempyfechainicio($usuario_datos[3], 2);

$empleado2 = $_POST["familiar"];
$fuma = $_POST["fuma"];
$poliza = $_POST["poliza"];
$maternidad = $_POST["maternidad"];
$ano=date('Y');
$codigo=  mysql_fetch_array("select consecutivo('RRHH','FAS','$ano')");
if (isset($_POST['familiares']) && !empty($_POST['familiares'])) {
    $i = 1;
    $aux = 0;
    $elementos = array();

    foreach ($_POST['familiares'] as $arreglo) {

        $elementos[$aux] = $arreglo;

        if (fmod($i, 3) == 0) {


            $elementos[0]; //cedula_familiar
            $elementos[1]; //enfermedad
            $elementos[2]; //vida


            $sql = mysql_query("INSERT INTO `metro_inextranet`.`fas` (cedula_empleado,`cedula_familiar`, `enfermedad`,vida,accidente,codigo) VALUES ($usuario_datos[3],'$elementos[0]', '$elementos[1]','$elementos[2]', '$elementos[2]','$codigo');");
            $aux = -1;
            
        } $i++;
        $aux++;
    }
}


$sqlq = mysql_query("call datos_personales_completos($usuario_datos[3]) ");
$row = mysql_fetch_array($sqlq);
?>
<body style="overflow: scroll;">  
    <div class="contenedor" >
        <div class="header" >

            <img  style="width: 70px important ;" src="../../src/images/fas.jpg" /> 
                

            <img class="img-empleado" style="width: 70px important ;" src="../../src/images/FOTOS/<?php echo $usuario_datos[3]; ?>.jpg" /> 

        

            <div class="cuerpo" >
                <h4 class="titulo-pp" align="center">PLANILLA DE INSCRIPCION
                    FONDO AUTOADMINISTRADO DE SALUD (FAS)
                </h4>
                <table border=1>
                    <tr>
                        <td colspan="">
                            Año: <?php echo date("Y"); ?>
                        </td>
                         <td colspan="">
                            Documento: <?php $codigo; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            Nombres: <?php echo $usuario_datos[1] ?>
                        </td>
                        <td colspan="4">
                            Apellidos: <?php echo $usuario_datos[2] ?>
                        </td>
                    </tr>
                    <tr>
                        <td >
                            C.I:  <?php echo $usuario_datos[3] ?>
                        </td>
                        <td >
                            Fecha de Nacimiento: <?php echo $row["fecha_nac"] ?>
                        </td>
                        <td >
                            Edad: <?php echo calculaedad($row["fecha_nac"]) ?>
                        </td>
                        <td  >
                            Sexo: <?php echo $row["sexo"] ?>
                        </td>
                        <td colspan=2 >
                            Estado Civil: <?php echo $row["estado_civil"] ?>
                        </td>
                        <td >
                            Tipo de Sangre: <?php echo $row["tipo_sangre"] . ' ' . $row["factor_rh"] ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Lugar de Nacimiento:<?php $row["descripcion_m"] ?>
                        </td>
                        <td >
                            Estado: <?php echo $row["descripcion_e"] ?>
                        </td>
                        <td colspan="2">
                            País:<?php if ($row["nac_tra"]='V'){echo 'Venezuela';}else{echo 'Extranjera';} ?>
                        </td>
                        <td colspan="2">
                            Nacionalidad:<?php if ($row["nac_tra"]='V'){echo 'Venezolano';}else{echo 'Extranjero';} ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            Dirección de Habitación: <?php echo $row["direccion_habitacion"] ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Teléfono(s): <?php echo $row["celular"] . ' ' . $row["telefono_habitacion"] ?>
                        </td>
                        <td colspan="3">
                            Persona(s) Contacto: <?php echo $row["persona_contacto"] . ' ' . $row["telefono_contacto"] ?>
                        </td>
                        <td colspan="2">
                            Fecha de Ingreso:<?php echo $fecha_ingreso; ?>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2">
                            Cargo: <?php echo $row["cargo"] ?>
                        </td>
                        <td colspan="3">
                            Profesión: <?php echo $row["profesion_p"].' '.$row["profesion_t"] ?>
                        </td>
                        <td colspan="2">
                            Gerencia: <?php echo $row["gerencia"] ?>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="7" style="text-align:center">
                            <b>  BENEFICIARIOS Y/O FAMILIARES A SER INCLUIDO</b>
                        </td>

                    </tr>
                    <tr>
                        <td rowspan="2" >
                            Nombres y Apellidos
                        </td>
                        <td rowspan="2" align="center">
                            C.I
                        </td>
                        <td rowspan="2" align="center">
                            Parentesco
                        </td>
                        <td rowspan="2" align="center">
                            Edad
                        </td>
                        <td rowspan="2" align="center">
                            Fecha de Nacimiento
                        </td>
                        <td colspan="2" align="center">
                            Distribución Suma Aseguradora
                        </td>

                    </tr>
                    <tr>
                        <td>
                            Vida
                        </td>
                        <td>
                            Accidente
                        </td>
                    </tr>
                    </thead>



                    <?php
                    _bienvenido_mysql();
                 
          if (isset($_POST['familiares']) && !empty($_POST['familiares'])) {
    $i = 1;
    $aux = 0;
    $elemento = array();

    foreach ($_POST['familiares'] as $arreglo) {

        $elemento[$aux] = $arreglo;

        if (fmod($i, 3) == 0) {


            $elemento[0]; //cedula_familiar
            $elemento[1]; //enfermedad
            $elemento[2]; //vida


          
           
        
$aux = -1;
                        $sql = mysql_query("SELECT * FROM `datos_familiares_rrhh`  d left join fas f on(d.cedula_familiar=f.cedula_familiar)  WHERE d.cedula_empleado=$usuario_datos[3] and d.parentesco!='titular' and d.cedula_familiar=$elemento[0] ");
                       
                       $row_cont = mysql_fetch_array($sql);

                            $cedula = $row_cont['cedula_familiar'];
                            ?>

                            <tr class="gradeA">
                                <td><?php echo $row_cont["nombres"] ?></td>
                                <td><?php
                                    if ($cedula == 0) {
                                        echo $row_cont["cedula_empleado"];
                                    } else {
                                        echo $row_cont["cedula_familiar"];
                                    }
                                    ?></td>

                                <td><?php echo $row_cont["parentesco"] ?></td>


                                <td><?php echo calculaedad($row_cont["fecha_nac"]) ?></td>
                                <td><?php echo $row_cont["fecha_nac"] ?></td>             
                                <td><?php echo $row_cont["vida"] ?> %</td>	
                                <td><?php echo $row_cont["accidente"] ?> %</td>
                            </tr>	
                            <?php
        } $i++;
        $aux++; }}
                    
                    ?>    
                    <tr>
                        <td colspan="7" style="text-align:center"><b>IFORMACIÓN ADICIONAL</b></td>
                    </tr>
                    <tr>
                        <td colspan="7" >Incluye Maternidad: <?php echo $maternidad ?></td>

                    </tr>
                    <tr>
                        <td colspan="7" >Posee algún familiar dentro de la empresa: <?php echo $empleado2 ?></td>

                    </tr>
                    <tr>
                        <td colspan="7" >Posee algún seguro privado: <?php echo $poliza ?></td>

                    </tr>
                    <tr>
                        <td colspan="" >Es ud. alergico:</td>
                        <td colspan="6"><?php
                            if ($row["alergico"] = '') {
                                echo 'Si a:';
                            } else {
                                echo 'No';
                            } echo ' ' . $row["alergico"]
                            ?></td>
                    </tr>
                    <tr>
                        <td colspan="7" >Fuma Habitualmente: <?php echo $fuma ?></td>

                    </tr>
                    <?php
                    _bienvenido_mysql();
                     if (isset($_POST['familiares']) && !empty($_POST['familiares'])) {
    $i = 1;
    $aux = 0;
    $elemento = array();

    foreach ($_POST['familiares'] as $arreglo) {

        $elemento[$aux] = $arreglo;

        if (fmod($i, 3) == 0) {


            $elemento[0]; //cedula_familiar
            $elemento[1]; //enfermedad
            $elemento[2]; //vida


                
        
$aux = -1;

                        $sql = mysql_query("SELECT * FROM `datos_familiares_rrhh`  d left join fas f on(d.cedula_familiar=f.cedula_familiar)  WHERE d.cedula_empleado=$usuario_datos[3] and d.parentesco!='titular' and d.cedula_familiar=$elemento[0] ");
                
                       $row_cont = mysql_fetch_array($sql); 

                            $cedula = $row_cont['cedula_familiar'];
                            ?>

                            <tr class="gradeA">
                                <td colspan="7"><b>Padece de alguna enfermedad cronica o discapacidad: <?php echo '(' . $row_cont["parentesco"] . ') ' . strtoupper($row_cont["enfermedad"]); ?></b></td>
                            </tr>
                            <?php
                      } $i++;
        $aux++; }}
                    ?>
                </table>

                <p align="justify"><b>AUTORIZACION:</b><br><br>
                    <b>YO,</b> <u><?php echo $usuario_datos[1] . ' ' . $usuario_datos[2] ?></u>  <b>TITULAR DE CEDULA DE IDENTIDAD,</b><u><?php echo $usuario_datos[3] ?></u><br><br>
                DECLARO QUE TODOS LOS DATOS SUMINISTRADOS SON VERDADEROS; DE NO SER ASI LA EMPRESA TOMARA LAS ACCIONES
                COMPETENTES AL CASO; ASIMISMO AUTORIZO A LA EMPRESA REALIZAR EL DESCUENTO POR NOMINA DE LA CUOTA QUE
                CORRESPONDA SEGÚN LO INDICADO POR MI CARGA DE BENEFICIARIOS.
                <br><br>

                <b>FECHA:</b> <u><?php echo date('Y-d-m') ?></u>. 
                </p>
                </td> </tr>

                </center>    


                <?php
                $parametros = "ct=" . $check;
                $parametros = _desordenar($parametros);
                ?>
            </div>



        </div>

    </div>

</div>
</div>
</div>
</div>
</div>
<div class="contenedor-boton centrar"><button class="botonimprimir" style="margin-top: 290px;"
                                              onclick="window.print();">Imprimir Planilla de Inscripción</button>

 <br> <input   onclick="javascript:window.history.back();" class="btn btn-error"  type="submit" align='center' name="buscar" value="Atrás" />
                  
</div>

<center>

</body>   