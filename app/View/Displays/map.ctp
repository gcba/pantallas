<script type="text/javascript">
	var ACTION_TYPE = "<?php echo $this->request->params['action'] ?>";
</script>

<?php	
	$this->Html->script('//servicios.usig.buenosaires.gob.ar/usig-js/3.1/usig.AutoCompleterFull.min.js', array('inline' => false));
	$this->Html->script('//servicios.usig.buenosaires.gob.ar/usig-js/3.1/usig.MapaEstatico.min.js', array('inline' => false));
	$this->Html->script('//servicios.usig.buenosaires.gob.ar/usig-js/3.1/usig.MapaInteractivo.min.js', array('inline' => false));
	$this->Html->script('displays', array('inline' => false));
?>

<?php
	$this->set('title_for_layout', 'Mapa');
?>

<script type="text/javascript">
	var DISPLAYS_MAP = eval(<?php echo json_encode($display); ?>);
</script>

<!-- PANTALLAS-MAP -->
	<div id="displays-map" class="page-container">
		<div class="panel panel-default">

			<!-- PANEL HEADER -->
				<div class="panel-heading">
					<h1>Mapa de pantallas</h1>
				</div>

			<!-- PANEL BODY -->
				<div class="panel-body col-md-12 col-sm-12 col-xs-12">

					<!-- ACCIONES PRINCIPALES -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">

								<div class="references">
									<strong>REFERENCIAS:</strong>
									<img src="/img/marker_verde.png"/>
									<span>A tiempo.</span>
									<img src="/img/marker_rojo.png"/>
									<span>Con demora.</span>
									<img src="/img/marker_gris.png"/>
									<span>No conectada (Sin IP).</span>
								</div>

							</div>
						</div>

					<!-- MAPA -->
						<div id="map-container" class="col-md-12 col-sm-12 col-xs-12" style="height: 600px;"></div>

				</div>

		</div>
	</div>

<script id="tooltip-marker" type="text/x-handlebars-template">
	<div class='marker'>
		<strong>{{nombre}}</strong>
		<br/>
		{{#if ip_actual}}
			{{#if delayed}}
				<span class="label label-danger">CON RETRASO</span>
			{{else}}
	  			<span class="label label-success">A TIEMPO</span>
	  		{{/if}}
 		{{/if}}
		<a href='/pantallas/play/{{pantalla_id}}' class='btn btn-xs btn-default'>Reproducir</a>
		<a href='/pantallas/view/{{pantalla_id}}' class='btn btn-xs btn-default'>Detalle</a>
		<br/>
		{{direccion}}
		<br/>
		{{#if ip_actual}}
			IP: {{ip_actual}}
		{{else}}
	  		IP: NO TIENE IP DESIGNADA
	  	{{/if}}	
		<br/>
		Última consulta: {{fecha_ultima_consulta}}
	</div>
</script>