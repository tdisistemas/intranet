function do_upload() {
			// subir al servidor
			document.getElementById('upload_results').innerHTML = '<h1>Cargando al servidor...</h1>';
			webcam.upload();
}	
function my_completion_handler(msg) {
	// Muestra la imagen en la pantalla
	document.getElementById('upload_results').innerHTML = 
	'<img src="fotos/' + msg + '.jpg">'+
	'<form action="gestion_foto.php" method="post">'+
	'<input type="hidden" name="id_foto" id="id_foto" value="' + msg + '"  /><br>'+
	'<label>Nombre </label><input type="text" name="nombre_foto" id="nombre_foto"/></br>'+
	'<label>Descripcion </label><input type="text" name="des" id="des"/>'+
	'<input type="submit" name="button" id="button" value="Enviar" /></form>';
	// reset camera for another shot
	webcam.reset();

}
function mostrarboton() {
btn = document.getElementById('btnsubir');
btn.style.display = '';
}

function ocultarboton() {
btn = document.getElementById('btnsubir');
btn.style.display='none';
}