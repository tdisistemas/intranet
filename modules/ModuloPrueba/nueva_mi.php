<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {header("Location: ../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
	notificar("Usted no tiene permisos para esta Sección/Módulo", "dashboard.php?data=notificar", "notify-error");
	_wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
?>

<!-- Load TinyMCE -->
<script type="text/javascript" src="src/javascripts/tinymce/js/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
tinymce.init({
selector: "textarea",
plugins: [
	"advlist autolink lists link image charmap print preview anchor",
	"searchreplace visualblocks code fullscreen",
	"insertdatetime media table contextmenu paste moxiemanager"
],
toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>

<script language="JavaScript" type="text/javascript" src="src/javascripts/ajax.js"></script>

<div id="contentHeader">
<h2>Agregar Metro Informa</h2>
</div> <!-- #contentHeader -->	

<?php 

if (@$_POST['titulo']){
	
	$titulo=_antinyeccionSQL($_POST["titulo"]);
	$fecha=_antinyeccionSQL($_POST["fecha"]);
	$noticia=$_POST["noticia"];

	_bienvenido_mysql();

	$result = mysql_query ("INSERT INTO metroinforma(titulo,fecha,noticia) VALUES('".$titulo."','".$fecha."','".$noticia."')") or die("Error al Agregar Registro.");
	
	if($result){
		notificar("Metro informa ingresado con éxito", "dashboard.php?data=admin-mi", "notify-success");
	}
	else {
		die(mysql_error());
	}			
}
else { ?>

<div class="container">
	<div class="grid-24">
		<div class="widget">
			<div class="widget-content">
				
				<form class="form uniformForm validateForm" name="from_envio_mi" method="post" action="#" >
					
					<div class="field-group">
						<label for="email">Titulo:</label>
						<div class="field">
							<input type="text" name="titulo" id="titulo" size="32" class="validate[required]" autofocus />	
						</div>
					</div> <!-- .field-group -->
					
					<div class="field-group">
						<label for="date">Fecha actual:</label>
						<div class="field">
							<input type="text" name="fecha" id="fecha" size="15" class="" value="<?php echo date("Y-m-d H:i:s"); ?>" readonly />
							<label for="date">Fecha y Ahora actuales.</label>	
						</div>
					</div> <!-- .field-group -->
					
					<div class="field-group">
						<label for="url">Noticia:</label>
						<div class="field">
							<textarea id="noticia" name="noticia" rows="15" cols="80" style="width: 80%" class="tinymce"></textarea>
							<label for="url"></label>
						</div>
					</div> <!-- .field-group -->
				
					<input type="hidden" name="not_env" value="1" />
					
					<div class="actions" style="text-aling:right">
						
						<button name="Send" type="submit" class="btn btn-error">Agrega Registro</button>
						
					</div> <!-- .actions -->
					
				</form>
				
				
			</div> <!-- .widget-content -->
			
		</div> <!-- .widget -->	
	</div>
</div> <!-- .container -->

<?php } ?>

<div id="output"></div>
