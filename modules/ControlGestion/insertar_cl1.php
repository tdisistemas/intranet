<?php
if (array_pop(explode('/', $_SERVER['PHP_SELF'])) != 'dashboard.php') {
    ir("../../dashboard.php");
}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
    //notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
    _wm($usuario_datos[9], 'Acceso Denegado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');
}
_wm($usuario_datos[9], 'Acceso Autorizado en: ' . ucwords(array_pop(explode('/', __dir__))), 'S/I');

?>

<div id="contentHeader">
    <h2>Registro de Proyectos</h2>
</div>

<!-- #contentHeader -->
<div class="container">
    <div class="row">
        <div class="grid-16">
            <div class="widget">
                <div class="widget-header"> <span class="icon-folder-fill"></span>
                    <h3>Primera Fase</h3>
                </div>

                <div class="widget-content">

                    <form class="form validateForm" action="dashboard.php?data=insertar-proy" method="post"  onsubmit="return validarForm(this)" >
                        <div class="grid-2">
                        </div>
                        <div class="grid-10">
                            <div class="field-group">
                                <label>Clase:<br></label>   
                                <div class="field">
                                    <select  name="clase" id="clase">
                                        <option value="">Seleccione</option>
                                        <option value="ClaseI">Clase I</option>
                                        <option value="ClaseII">Clase II</option>
                                        <option value="ClaseIII">Clase III</option>
                                        <option value="ClaseIV">Clase IV</option>
                                        <option value="ClaseV">Clase V</option>
                                    </select>
                                </div>

                                <div class="field-group">
                                    <label for="date">Gerencia Requiriente:</br></label>   
                                    <div class="field">
                                        <select id="gerencia" name="gerencia"  style="width:110px">
                                            <option value=""></option>
                                            <?php
                                            _bienvenido_mysql();
                                            $sql = mysql_query("SELECT gerencia FROM datos_empleado_rrhh GROUP BY gerencia");
                                            while ($row = mysql_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo $row["gerencia"] ?>"><?php echo $row["gerencia"] ?></option>
                                            <?php } _adios_mysql(); ?>
                                        </select>	
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label for="required">Nombre de la Obra/Actividad:</br></label>   
                                    <div class="field">
                                        <input type="text" name="nombre_obra" id="nombre_obra" size="24" placeholder="Nombre de la Obra/Actividad" onChange="conMayusculas(this)" />	
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label for="required">Estatus:</br></label>   
                                    <div class="field">
                                        <select  name="estatus" id="estatus">
                                            <option value="">Seleccione</option>
                                            <option value="1">En Elaboración</option>
                                            <option value="2">Entregado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label for="date">Obra Extra:</br></label>   
                                    <div class="field">
                                        SI<input type="radio" name="obraextrasi" id="txek" value="1" onclick="Block(this,'obraextra')"/>
                                        NO<input type="radio" name="obraextrasi" value="0" onclick="Block(this,'obraextra')" checked />
                                        <select id="obraextra" name="obraextra"  style="width:130px" disabled>
                                            <option value="">Seleccione</option>
                                            <?php
                                            _bienvenido_mysql();
                                            $sql = mysql_query("SELECT obra FROM gc_control_gestion GROUP BY obra");
                                            while ($row = mysql_fetch_array($sql)) {
                                                ?>
                                                <option value="<?php echo $row["obra"] ?>"><?php echo $row["obra"] ?></option>
                                            <?php } _adios_mysql(); ?>
                                        </select>	
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="grid-2">
                        </div>
                        <div class="grid-10">
                            <div class="field-group">
                                <label for="datepicker">Fecha de Ingreso:<br></label>   
                                <div class="field">
                                    <input type="date" name="fecha_ing" id="datepicker" size="14"  placeholder="Fecha de Ingreso" readonly/>
                                </div>
                            </div>
                            <div class="field-group">
                                <label for="required">Responsable del Requerimiento:</br></label>   
                                <div class="field">
                                    <input type="text" name="responsable_req" id="responsable_req" size="22" placeholder="Responsable del Requerimiento" onChange="conMayusculas(this)" onkeypress="return validarLetras(event)"/>
                                </div>
                            </div>

                            <div class="field-group">
                                <label for="required">Documentos Entregados:</br></label>   
                                <div class="field">
                                    <input type="checkbox" name="alcance" id="alcance" value="1" size="14" />&nbsp;&nbsp;Alcance del Proyecto</br>
                                    <input type="checkbox" name="memoriad" id="memoriad" value="1" size="14" />&nbsp;&nbsp;Memoría Descriptiva</br>
                                    <input type="checkbox" name="computos" id="computos" value="1" size="14" />&nbsp;&nbsp;Computos Metricos</br>
                                    <input type="checkbox" name="especificaciones" id="especificaciones" value="1" size="14" />&nbsp;&nbsp;Especificaciones Tecnicas</br>
                                    <input type="checkbox" name="planos" id="planos" value="1" size="14" />&nbsp;&nbsp;Planos</br>
                                    <input type="checkbox" name="anexos" id="anexos" value="1" size="14" />&nbsp;&nbsp;Anexos</br>
                                </div>
                            </div>
                        </div>






                        <div class="grid-24" align="center">
                            <table >
                                <tr>
                                    <td>
                                        <div id="cargador" style="display:none;font-size:14px"> <img src="src/images/loaders/indicator-big.gif" width="10" height="10" /> Cargando </div> 
                                        <div id="cargador_2" style="display:none;font-size:14px"> <img src="src/images/loaders/indicator-big.gif" width="10" height="10" /> Cargando </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td align="center"><button type="submit" name="enviar" class="btn btn-primary">Enviar</button></td>
                                    <td><button type="submit" name="Atras" onclick="javascript:window.history.back();" class="btn btn-error" value="Regresar" >Regresar</button></td>
                                </tr>
                            </table>
                        </div>
 
                    </form>

                </div>
            </div>
        </div>
        <div class="grid-8">				
            <div class="widget">			
                <div class="widget-header">
                    <span class="icon-layers"></span>
                    <h3></h3>
                </div>
                <div class="widget-content">
                    <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]; ?></h3>
                    <p>En esta sección podrá ingresar los datos de la primera fase del proceso</p>
                    <!-- .pad -->
                </div>  
                <?php
                _adios_mysql();
                ?>
            </div>

        </div>
    </div>

</div>



<script type="text/javascript">
    function Block(esto,id)
   {
    if(esto.value==1)
     {
		id=document.getElementById(id);
		id.disabled=false;		
	 }	
	else
	 {
		id=document.getElementById(id);
		id.disabled=true;				
	 }
   }
    function validarForm(formulario) {
        if (formulario.clase.value.length == 0) { //¿Tiene 0 caracteres?
            formulario.clase.focus();    // Damos el foco al control
            alert('Debe seleccionar una clase'); //Mostramos el mensaje
            return false; //devolvemos el foco
        }
        if (formulario.datepicker.value.length == 0) { //¿Tiene 0 caracteres?
            formulario.datepicker.focus();    // Damos el foco al control
            alert('Debe incluir la fecha de ingreso'); //Mostramos el mensaje
            return false; //devolvemos el foco
        }
        if (formulario.gerencia.value.length == 0) { //¿Tiene 0 caracteres?
            formulario.gerencia.focus();    // Damos el foco al control
            alert('Debe seleccionar la Gerencia Requiriente'); //Mostramos el mensaje
            return false; //devolvemos el foco
        }
        if (formulario.responsable_req.value.length == 0) { //¿Tiene 0 caracteres?
            formulario.responsable_req.focus();    // Damos el foco al control
            alert('Debe ingresar el responsable del requerimiento'); //Mostramos el mensaje
            return false; //devolvemos el foco
        }
        
        if (formulario.nombre_obra.value.length == 0) { //¿Tiene 0 caracteres?
            formulario.nombre_obra.focus();    // Damos el foco al control
            alert('Debe ingresar el nombre de la Obra/Actividad'); //Mostramos el mensaje
            return false; //devolvemos el foco
        }
     
        if (formulario.estatus.value.length == 0) { //¿Tiene 0 caracteres?
            formulario.gerencia.focus();    // Damos el foco al control
            alert('Debe seleccionar el estatus'); //Mostramos el mensaje
            return false; //devolvemos el foco
        }
    }
    $(function () {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "1950:2014"
        });
    });
    function conMayusculas(field) {
        field.value = field.value.toUpperCase()
    }
    function validarLetras(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; // backspace
        if (tecla==32) return true; // espacio
        if (e.ctrlKey && tecla==86) { return true;} //Ctrl v
        if (e.ctrlKey && tecla==67) { return true;} //Ctrl c
        if (e.ctrlKey && tecla==88) { return true;} //Ctrl x
 
        patron = /[a-zA-Z]/; //patron
 
        te = String.fromCharCode(tecla);
        return patron.test(te); // prueba de patron
    }  
    javascript</script>








