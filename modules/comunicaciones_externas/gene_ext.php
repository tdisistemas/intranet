<?php 
if (array_pop(explode('/', $_SERVER['PHP_SELF']))!='dashboard.php') {header("Location: ../../dashboard.php");}
if (!in_array(ucwords(array_pop(explode('/', __dir__))), $usuario_permisos)) {
  notificar("Usted no tiene permisos para esta Seccion/Modulo", "dashboard.php?data=notificar", "notify-error");
  _wm($usuario_datos[9],'Acceso Denegado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');
} 
_wm($usuario_datos[9],'Acceso Autorizado en: '.ucwords(array_pop(explode('/', __dir__))),'S/I');



?>
<div id="contentHeader">
	<h2>Comunicaciones</h2>
</div>
<div class="container">
	<div class="grid-17">
		<br/>
		<div class="widget widget-table">
			<div class="widget-header">
				<span class="icon-cog"></span>
				<h3 class="icon chart">Comunicaciones Externas</h3>
			</div>
			<tr>
				<div class="widget-content">
					<table class="table table-bordered ">
					<form action="modules/comunicar/pdf_ext.php?token=<?php
echo  $anticachecret;?>" target="_blank" method="POST" name="ddd" id="ddd">
				
                                            <tr>
                                                <center>
				<div class="control-group">
  
    <br>

					<div>
                                        
					 	<label>Para<br>
						</label>
			
						<input type="text" id="buscar" size="42"  class="input-large" required="Este campo es necesario" onChange="conMayusculas(this)"  name="para"/>
					</div>
    <div class="control-group">
    <br>
  <label class="control-label" for="asunto">Asunto</label>
  <div class="controls">
    <input id="asunto" name="asunto" size="40%" type="text" placeholder="" class="input-large" required="" value="<?php echo $asunto; ?>" />    
  </div>
</div>
					
				<div class="control-group">
   <div class="controls">
      <input id="de" name="de" type="hidden" placeholder="" class="input-large" size="42%" readonly value="<?php echo  _damecargo($usuario_datos[3]); ?>" required="" />
  </div>
</div>

<!-- Text input-->

<!-- Text input-->
    <input id="fecha" name="fecha" type="hidden" placeholder="" class="input-medium" value="<?php echo date("d/m/Y"); ?>" required="" readonly />
 
  
	<br>

                                        <label>Cuerpo de la Comunicación</label><br>
      <textarea name="texto" class="input-large" cols="100" rows="20"></textarea>

<!-- Button (Double) --> 
<div class="control-group">
	<label class="control-label" action="dashboard.php?data=cuerpo" for="generar"></label>
	<div class="controls">
            <center>
		<input style="width:25%; margin-top:10px;" type="submit" class="btn btn-danger" value="Generar Comunicación" name="enviar" id="enviar" />
	</div>
</div>
</fieldset>
</form>
<br>

 </tbody>
        </table>
     
      </div>
    
</div>
   
 </div>
     
        
   <div class="grid-7"> 
				
				<div class="box">
					 <h3>Estimado, <?php echo $usuario_datos[1] . ' ' . $usuario_datos[2]; ?></h3>
                <p>En esta sección podrá realizar Comunicaciones Externas</p> 
				
        
					
					
				</div> 
     </div>
						</div>
					</div> <!-- .row -->
			</div> <!-- .container -->
    </div>
				</tr>
				</table>
				</center>
			</tr>

 <script language="javascript" type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js"> </script>
  
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontsizeselect,|,cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,",
		theme_advanced_buttons2 : "undo,redo,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,tablecontrols,|,hr,removeformat,|,sub,sup,|,charmap,advhr,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		// Example content CSS (should be your site CSS)
		content_css : "tinymce/css/content.css",
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "tinymce/lists/template_list.js",
		external_link_list_url : "tinymce/lists/link_list.js",
		external_image_list_url : "tinymce/lists/image_list.js",
		media_external_list_url : "tinymce/lists/media_list.js",
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],
		// Replace values for the template plugin		
	});
</script>
<script >
 function conMayusculas(field) {
field.value = field.value.toUpperCase()
}
	
</script>
		</form>
		</table>
	</div>
</div>
</div>
</div>  