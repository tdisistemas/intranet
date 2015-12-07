<?php
if (isset($_GET["data"])) {
    $t = strip_tags($_GET["data"]);
} else {
    $t = 'inicio';
}
switch ($t) {
    /*     * ******************************************** */
    /*     * ******** ASUNTOS INTERNOS ADMIN ************ */
    /*     * ******************************************** */
    case ("admin_ai"):include('modules/SIIT-Metro(Admin)/ai_admin.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("investigadores"):include('modules/SIIT-Metro(Admin)/ai_investigadores.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("add_investigadores"):include('modules/SIIT-Metro(Admin)/add_investigadores.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("investigador-ai-info"):include('modules/SIIT-Metro(Admin)/ai_investigador_info.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("investigador-ai-eliminar"):include('modules/SIIT-Metro(Admin)/ai_eliminar_investigador.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("denuncias-ai"):include('modules/SIIT-Metro(Admin)/ai_denuncias.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("add_denuncias"):include('modules/SIIT-Metro(Admin)/add_denuncias.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("denuncia-ai-eliminar"):include('modules/SIIT-Metro(Admin)/ai_eliminar_denuncia.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("denuncia-ai-info"):include('modules/SIIT-Metro(Admin)/ai_denuncia_info.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("oficios-ai"):include('modules/SIIT-Metro(Admin)/ai_oficios.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("add_oficios"):include('modules/SIIT-Metro(Admin)/add_oficios.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("oficios-ai-eliminar"):include('modules/SIIT-Metro(Admin)/ai_eliminar_oficios.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("oficios-ai-info"):include('modules/SIIT-Metro(Admin)/ai_oficios_info.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("investigacion-ai-info"):include('modules/SIIT-Metro(Admin)/ai_investigacion_info.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("add_investigacion"):include('modules/SIIT-Metro(Admin)/add_investigaciones.php');
        ?><script>activame('admin_ai');</script><?php
        break;

    /*     * ******************************************** */
    /*     * *********** ASUNTOS INTERNOS *************** */
    /*     * ******************************************** */
    case ("usuario-ai"):include('modules/SIIT-Metro/usuarios_ai.php');
        ?><script>activame('investigacion');</script><?php
        break;
    case ("averiguaciones-ai"):include('modules/SIIT-Metro/ai_investigaciones.php');
        ?><script>activame('investigacion');</script><?php
        break;
    case ("averiguaciones-ai-info"):include('modules/SIIT-Metro/ai_investigacion_info.php');
        ?><script>activame('investigacion');</script><?php
        break;
    case ("usuario-ai-info"):include('modules/SIIT-Metro/info_empleado_ai.php');
        ?><script>activame('investigacion');</script><?php
        break;
    case ("historial-ai"):include('modules/SIIT-Metro/historial_empleado.php');
        ?><script>activame('investigacion');</script><?php
        break;
    /*     * ** INICIO *** */
    case ("inicio"):include('modules/metroinforma/metroinforma.php');
        ?><script>activame('inicio');</script><?php
        break;

    /*     * ******************************************** */
    /*     * ******** ASUNTOS INTERNOS ADMIN ************ */
    /*     * ******************************************** */
    case ("admin_ai"):include('modules/SIIT-Metro(Admin)/ai_admin.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("investigadores"):include('modules/SIIT-Metro(Admin)/ai_investigadores.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("add_investigadores"):include('modules/SIIT-Metro(Admin)/add_investigadores.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("investigador-ai-info"):include('modules/SIIT-Metro(Admin)/ai_investigador_info.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("investigador-ai-eliminar"):include('modules/SIIT-Metro(Admin)/ai_eliminar_investigador.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("denuncias-ai"):include('modules/SIIT-Metro(Admin)/ai_denuncias.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("add_denuncias"):include('modules/SIIT-Metro(Admin)/add_denuncias.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("denuncia-ai-eliminar"):include('modules/SIIT-Metro(Admin)/ai_eliminar_denuncia.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("denuncia-ai-info"):include('modules/SIIT-Metro(Admin)/ai_denuncia_info.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("oficios-ai"):include('modules/SIIT-Metro(Admin)/ai_oficios.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("add_oficios"):include('modules/SIIT-Metro(Admin)/add_oficios.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("oficios-ai-eliminar"):include('modules/SIIT-Metro(Admin)/ai_eliminar_oficios.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("oficios-ai-info"):include('modules/SIIT-Metro(Admin)/ai_oficios_info.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("investigacion-ai-info"):include('modules/SIIT-Metro(Admin)/ai_investigacion_info.php');
        ?><script>activame('admin_ai');</script><?php
        break;
    case ("add_investigacion"):include('modules/SIIT-Metro(Admin)/add_investigaciones.php');
        ?><script>activame('admin_ai');</script><?php
        break;

    /*     * ******************************************** */
    /*     * *********** ASUNTOS INTERNOS *************** */
    /*     * ******************************************** */
    case ("usuario-ai"):include('modules/SIIT-Metro/usuarios_ai.php');
        ?><script>activame('investigacion');</script><?php
        break;
    case ("averiguaciones-ai"):include('modules/SIIT-Metro/ai_investigaciones.php');
        ?><script>activame('investigacion');</script><?php
        break;
    case ("averiguaciones-ai-info"):include('modules/SIIT-Metro/ai_investigacion_info.php');
        ?><script>activame('investigacion');</script><?php
        break;
    case ("usuario-ai-info"):include('modules/SIIT-Metro/info_empleado_ai.php');
        ?><script>activame('investigacion');</script><?php
        break;
    case ("historial-ai"):include('modules/SIIT-Metro/historial_empleado.php');
        ?><script>activame('investigacion');</script><?php
        break;

    /*     * ** PRUEBA *** */
    case ("pruebainsert"):include('modules/ModuloPrueba/NuevoUsuario.php');
        ?><script>activame('prueba');</script><?php
        break;
    case ("pruebadelete"):include('modules/ModuloPrueba/Eliminar_Usuario.php');
        ?><script>activame('prueba');</script><?php
        break;
    case ("pruebaupdate"):include('modules/ModuloPrueba/Editar_Usuario.php');
        ?><script>activame('prueba');</script><?php
        break;
    case ("prueba"):include('modules/ModuloPrueba/Ver_Usuarios.php');
        ?><script>activame('prueba');</script><?php
        break;

    /*     * ** CONTROL Y GESTIÓN *** */
    case ("controlg"):include('modules/ControlGestion/registro_cl1.php');
        ?><script>activame('controlgestion');</script><?php
        break;
    case ("insertar_cl1"):include('modules/ControlGestion/insertar_cl1.php');
        ?><script>activame('controlgestion');</script><?php
        break;
    case ("insertar-proy"):include('modules/ControlGestion/insertar-proy.php');
        ?><script>activame('controlg');</script><?php
        break;
    case ("edicion_reg"):include('modules/ControlGestion/edicion.php');
        ?><script>activame('controlgestion');</script><?php
        break;
    case ("edicion_reg2"):include('modules/ControlGestion/edicion2.php');
        ?><script>activame('controlgestion');</script><?php
        break;
    case ("edicion_reg4"):include('modules/ControlGestion/edicion4.php');
        ?><script>activame('controlgestion');</script><?php
        break;
    case ("seg_fase"):include('modules/ControlGestion/segunda_fase.php');
        ?><script>activame('controlgestion');</script><?php
        break;
    case ("seg_fase1"):include('modules/ControlGestion/segunda_fase1.php');
        ?><script>activame('controlgestion');</script><?php
        break;
    case ("seg_fase2"):include('modules/ControlGestion/segunda_fase2.php');
        ?><script>activame('controlgestion');</script><?php
        break;
    case ("consultar"):include('modules/ControlGestion/consulta.php');
        ?><script>activame('controlgestion');</script><?php
        break;
    case ("puntoc"):include('modules/ControlGestion/puntocuenta.php');
        ?><script>activame('controlgestion');</script><?php
        break;
     
    /*     * ** CONTROL Y GESTIÓN ADMINISTRADOR *** */
    case ("control_gestion_reporte"):include('modules/ControlGestionAdmin/cg_reportes.php');
        ?><script>activame('controlgestionadmin');</script><?php
        break;
    

    /*     * ** NOTIFICACION *** */
    case ("notificar"):include('../notificar.php');
        break;

    /*     * ** LISTINES *** */
    case ("listines"):include('modules/listines/listinesv4.php');
        ?><script>activame('listines');</script><?php
        break;
    case ("listines-r"):include('modules/listines/listinesv4r.php');
        ?><script>activame('listines');</script><?php
        break;
    case ("listines-arc"):include('modules/listines/listinesv4arc.php');
        ?><script>activame('listines');</script><?php
        break;

    /*     * ** AME *** */
    case ("ame"):include('modules/ame/intro.php');
        ?><script>activame('ame');</script><?php
        break;
    case ("amee"):include('modules/ame/extro.php');
        ?><script>activame('ame');</script><?php
        break;

    /*     * ** AME ADMIN*** */
    case ("ameadmin"):include('modules/ameadmin/ameadmin.php');
        ?><script>activame('ameadmin');</script><?php
        break;

    /*     * ** AHORRO *** */
    case ("cahorro"):include('modules/ahorro/intro.php');
        ?><script>activame('cahorro');</script><?php
        break;
    case ("cahorroe"):include('modules/ahorro/extro.php');
        ?><script>activame('cahorro');</script><?php
        break;
    case ("gestionca"):include('modules/ahorro/gestion.php');
        ?><script>activame('cahorro');</script><?php
        break;

    /*     * ** AHORRO ADMIN*** */
    case ("cahorroadmin"):include('modules/ahorroadmin/ahorroadmin.php');
        ?><script>activame('cahorroadmin');</script><?php
        break;

    /*     * ** PLAN VACACIONAL FRONT*** */
    case ("plan-vacacional"):include('modules/planvacacionalfront/intro.php');
        ?><script>activame('plan-vacacional');</script><?php
        break;

    /*     * ** PLAN VACACIONAL ADMIN*** */
    case ("plan-vacacional-admin"):include('modules/planvacacionaladmin/planvreport.php');
        ?><script>activame('plan-vacacional-admin');</script><?php
        break;

    /*     * ** COMUNICACIONES *** */
    case ("comunicaciones"):include('modules/comunicaciones/generador.php');
        ?><script>activame('comunicaciones');</script><?php
        break;
    case ("comunicacionesv2"):include('modules/comunicacionesv2/intro.php');
        ?><script>activame('comunicacionesv2');</script><?php
        break;

    /*     * ** DIRECTORIO *** */
    case ("directorio"):include('modules/directorio/directoriot.php');
        ?><script>activame('directorio');</script><?php
        break;

    /*     * ** DOCUMENTOS *** */
    case ("documentos"):include('modules/documentos/paneldocumentos.php');
        ?><script>activame('documentos');</script><?php
        break;

    /*     * ** CLASIFICADOS *** */
    case ("clasificados"):include('modules/clasificados/aclasificados.php');
        ?><script>activame('clasificados');</script><?php
        break;

    /*     * ** CLASIFICADOS *** */
    case ("permisos"):include('modules/permisos/mpermisos.php');
        ?><script>activame('permisos');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2013 *** */
    case ("dea2013"):include('modules/desdeelanden/ediciones_dea2013.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2013-1 *** */
    case ("dea01"):include('modules/desdeelanden/ediciones_dea_1.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2013-2 *** */
    case ("dea02"):include('modules/desdeelanden/ediciones_dea_2.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2013-3 *** */
    case ("dea03"):include('modules/desdeelanden/ediciones_dea_3.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2013-4 *** */
    case ("dea04"):include('modules/desdeelanden/ediciones_dea_4.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2014-5 *** */
    case ("dea05"):include('modules/desdeelanden/ediciones_dea_5.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2014-6 *** */
    case ("dea06"):include('modules/desdeelanden/ediciones_dea_6.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2014-7 *** */
    case ("dea07"):include('modules/desdeelanden/ediciones_dea_7.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2014-8 *** */
    case ("dea08"):include('modules/desdeelanden/ediciones_dea_8.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** DESDE EL ANDEN-2014-9 (Edicion Especial) *** */
    case ("dea09"):include('modules/desdeelanden/ediciones_dea_9.php');
        ?><script>activame('dea');</script><?php
        break;


    /*     * ** DESDE EL ANDEN-2014 *** */
    case ("dea2014"):include('modules/desdeelanden/ediciones_dea2014.php');
        ?><script>activame('dea');</script><?php
        break;

    /*     * ** ADMINISTRAR METRO INFORMA *** */
    case ("admin-mi"):include('modules/metroinforma/ver_mi.php');
        ?><script>activame('metroinforma');</script><?php
        break;

    case ("agregar-mi"): include('modules/metroinforma/nueva_mi.php');
        ?><script>activame('metroinforma');</script><?php
        break;
    case ("editar-mi"): include('modules/metroinforma/editar_mi.php');
        ?><script>activame('metroinforma');</script><?php
        break;
    case ("eliminar-mi"):include('modules/metroinforma/eliminar_mi.php');
        ?><script>activame('metroinforma');</script><?php
        break;

    /*     * ** GENERADOR MD5 *** */
    case ("genmd5"):include('modules/generadormd5/generadormd5.php');
        ?><script>activame('generadormd5');</script><?php
        break;

    /*     * ** DATOS DEL EMPLEADO Y DE FAMILIARES *** */
    case ("actualizar"):include('modules/actualizacion/actualizacion.php');
        break;
    case ("actualizarcf"):include('modules/actualizacion/actualizacioncf.php');
        break;

    /*     * **  PERFIL DEL USUARIO *** */
    case ("perfil"):include('modules/perfil/perfil.php');
        break;

    /*     * **  CIERRE DE SESION *** */
    case ("bye"):include('modules/bye/bye.php');
        break;

    /*     * **  REINTEGROS *** */
    case ("reintegros"):include('modules/reintegros/reintegrosapp.php');
        ?><script>activame('reintegros');</script><?php
        break;

    /*     * **  RESERVA *** */
    case ("recursos"):include('modules/recursos/recursosapp.php');
        ?><script>activame('reserva');</script><?php
        break;

    /*     * **  RECEPCION DE CARTAS *** */
    case ("recep"):include('modules/recepcion/recepcion.php');
        ?><script>activame('recep');</script><?php
        break;

    /*     * **  PERFILES DE USUARIOS *** */

    case ("perfiles"):include('modules/auth/perfiles.php');
        ?><script>activame('auth');</script><?php
        break;

    case ("agregar-pe"): include('modules/auth/nueva_pe.php');
        ?><script>activame('auth');</script><?php
        break;
    case ("editar-pe"): include('modules/auth/editar_pe.php');
        ?><script>activame('auth');</script><?php
        break;
    case ("eliminar-pe"):include('modules/auth/eliminar_pe.php');
        ?><script>activame('auth');</script><?php
        break;

    case ("auth-reload"):include('modules/auth/reload.php');
        ?><script>activame('auth');</script><?php
        break;

    /*     * **  USUARIOS *** */

    case ("usuarios"):include('modules/auth/usuarios.php');
        ?><script>activame('auth');</script><?php
        break;

    case ("agregar-us"): include('modules/auth/nuevo_us.php');
        ?><script>activame('auth');</script><?php
        break;
    case ("editar-us"): include('modules/auth/editar_us.php');
        ?><script>activame('auth');</script><?php
        break;
    case ("eliminar-us"):include('modules/auth/eliminar_us.php');
        ?><script>activame('auth');</script><?php
        break;

    /*     * ** ADMINISTRADOR DE BASE DE DATOS *** */

    case ("admindb"):include('modules/admindb/admindb.php');
        ?><script>activame('admindb');</script><?php
        break;

    /*     * ** ADMINISTRADOR DE BASE DE DATOS *** */

    case ("admindb"):include('modules/admindb/admindb.php');
        ?><script>activame('admindb');</script><?php
        break;

    /*     * ** ADMINISTRADOR DE BASE DE DATOS *** */

    case ("servfami"):include('modules/serviciosfamiliares/serviciofamiliar.php');
        break;

    /*     * ** ADMINISTRADOS DE NOTIFICACIONES Y MENSAJERIA *** */

    case ("notiadmin"):include('modules/notificacionesadmin/notiadmin.php');
        ?><script>activame('notificacionesadmin');</script><?php
        break;
    case ("notihistorial"):include('notihistorial.php');
        break;

    /*     * ** ADMINISTRADOS DE NOTIFICACIONES Y MENSAJERIA *** */

    case ("wmlauncher"):include('modules/webmail/launcher.php');
        ?><script>activame('webmail');</script><?php
        break;




    /*     * ** EJEMPLO *** */

    case ("ejemploinsert"):include('modules/modulo_ejemplo/ejempinsert.php');
        ?><script>activame('ejemplo');</script><?php
        break;

    /*     * ** ADMINISTRADOR DE CV *** */

    case ("cvadmin"):include('modules/cvadmin/cvadmin.php');
        ?><script>activame('cvadmin');</script><?php
        break;
    case ("det-asp"):include('modules/cvadmin/reporte_asp.php');
        ?><script>activame('cvadmin');</script><?php
        break;
    case ("carga-cv-rh"):include('modules/cvadmin/carga_cv_rh.php');
        ?><script>activame('cvadmin');</script><?php
        break;
    case ("proc-cv-rh"):include('modules/cvadmin/proc_cv_rh.php');
        ?><script>activame('cvadmin');</script><?php
        break;
    case ("sav-cv-rh"):include('modules/cvadmin/guardar_cv_rh.php');
        ?><script>activame('cvadmin');</script><?php
        break;
}
?>
