var Displays;

;(function(global, document, $){

	"use strict";

	Displays = global.Displays = global.Displays || {};

	/*
	 * Variable globales
	 */
		Displays.map = {};


	/*
	 * init
	 * Inicia el objeto.
	 */
		Displays.init = function () {

			// Variable definida en fields.ctp, obtiene la acción y la pasa a minúsculas.
				ACTION_TYPE = ACTION_TYPE.toLowerCase();


			// Defino las siguientes variables globales
				Displays.$InputLat 				= $('#DisplayLat');
				Displays.$InputLng 				= $('#DisplayLng');
				Displays.$InputComuna 			= $('#DisplayComuna');
				Displays.$InputBarrio 			= $('#DisplayBarrio');
				Displays.$InputDireccion 		= $('#DisplayDireccion');

			// Obtengo los valores de los campos (por defecto son "")
				Displays.$InputLatValue 		= Displays.$InputLat.val();
				Displays.$InputLngValue 		= Displays.$InputLng.val();
				Displays.$InputComunaValue 		= Displays.$InputComuna.val();
				Displays.$InputBarrioValue 		= Displays.$InputBarrio.val();
				Displays.$InputDireccionValue 	= Displays.$InputDireccion.val();
				Displays.$InputDireccionObject 	= null;

			
			// Si el tipo de acción es add o edit
				if( ACTION_TYPE == 'add' || ACTION_TYPE == 'edit' )
				{
					// Cargo el AutoCompleter en el input de la dirreción
						var ac = new usig.AutoCompleter(Displays.$InputDireccion.attr('id'), {
								afterGeoCoding: Displays.afterGeoCoding,
								afterSelection: Displays.afterSelection
							}
						);

					// Cuando le hago un submit a los formularios en el add y edit, vuelvo el VALUE de los input a los originales
						$('form').on('submit', function(e) {
							Displays.$InputLat.val( Displays.$InputLatValue );
							Displays.$InputLng.val( Displays.$InputLngValue );
							Displays.$InputComuna.val( Displays.$InputComunaValue );
							Displays.$InputBarrio.val( Displays.$InputBarrioValue );
							Displays.$InputDireccion.val( Displays.$InputDireccionValue );
						});
				}

			// Si el tipo de acción es edit o view
				if( ACTION_TYPE == 'edit' || ACTION_TYPE == 'view' )
				{
					var x = Displays.$InputLng.val() || $('#lng-value').html();
					var y = Displays.$InputLat.val() || $('#lat-value').html();

					var img = usig.MapaEstatico({ x: x, y: y, marcarPunto: true, width: 1024, height: 300 });
					$('#map-container').html(img);
				}

			// Si el tipo de DISPLAYS_MAP es un objeto
				if(typeof(DISPLAYS_MAP) === 'object') {
					// Genero el mapa
						Displays.createMap(DISPLAYS_MAP);
				}

		};


	/*
	 * afterSelection
	 * Se ejecuta después de seleccionar
	 */
		Displays.afterSelection = function(option) {

			// Guardo el valor de la dirección
				if (option instanceof usig.Direccion || option instanceof usig.inventario.Objeto)
				{
					Displays.$InputDireccionObject 	= option;
				}

		};


	/*
	 * afterGeoCoding
	 * Se ejecuta luego de geocodificar la selección
	 */
		Displays.afterGeoCoding = function(point) {

			// Si pt es un punto
				if (point instanceof usig.Punto)
				{
					// Y si la opción seleccionada es una dirección
					if (Displays.$InputDireccionObject instanceof usig.Direccion)
					{
						Displays.$InputLat.val(point.lat);
						Displays.$InputLng.val(point.lon);

						var img = usig.MapaEstatico({ x: point.lon, y: point.lat, marcarPunto: true, width: 1024, height: 300 });
						$('#map-container').html(img);

						Displays.getDatosUtiles(point.lon, point.lat);
					}
				}

		};


	/*
	 * getDatosUtiles
	 * Se ejecuta al finalizar la geocodificación de la dirección
	 */
		Displays.getDatosUtiles = function(x,y) {

			var usigAPI = "//ws.usig.buenosaires.gob.ar/datos_utiles?x=" + x + "&y=" + y + "&callback=?";
			
			$.getJSON( usigAPI )
			.done(function( data ) {

				// Obtengo la comuna y el barrio
					Displays.$InputComuna.val(data.comuna.split(' ')[1]);
					Displays.$InputBarrio.val(data.barrio);

				// Guardo los valores en las variables correspondientes
					Displays.$InputLatValue 		= Displays.$InputLat.val();
					Displays.$InputLngValue 		= Displays.$InputLng.val();
					Displays.$InputComunaValue 		= Displays.$InputComuna.val();
					Displays.$InputBarrioValue 		= Displays.$InputBarrio.val();
					Displays.$InputDireccionValue 	= Displays.$InputDireccion.val();

			});

		};


	/*
	 * createMap
	 * Genera el mapa de la view /map/
	 */
	Displays.createMap = function(data) {

		Displays.map = new usig.MapaInteractivo('map-container', {
			baseLayer: 'mapabsas_default',
			onReady: function() {

				var compiledTemplate = Handlebars.compile($('#tooltip-marker').html());

				var iconUrl = '',
					iconSize = new OpenLayers.Size(25, 36),
					customMarker,
					pantalla,
					currentMinusOneHour = new Date();

				currentMinusOneHour.setHours(currentMinusOneHour.getHours()-1);

				//http://servicios.usig.buenosaires.gob.ar/usig-js/dev/images/

				function addMarker(pantalla, tooltip) {

					if(!pantalla.ip_actual){
						iconUrl = '/img/marker_gris.png';
					}
					else if(pantalla.delayed){
						iconUrl = '/img/marker_rojo.png';
					}
					else {
						iconUrl = '/img/marker_verde.png';
					}

					customMarker = new OpenLayers.Marker(
						new OpenLayers.LonLat( pantalla.lng, pantalla.lat ),
						new OpenLayers.Icon( iconUrl, iconSize )
					);

					Displays.map.addMarker(customMarker, true, tooltip);
				}

				var tooltip;
				
				$(data).each(function(i, e) {
					e = e['Display'];
				
					if(currentMinusOneHour>new Date(e.fecha_ultima_consulta)){
						e.delayed = true;   
					}
					else {
						e.delayed = false;
					}
				
					tooltip = compiledTemplate(e);
				
					addMarker(e,tooltip);
				});

				Displays.map.zoomToMarkers();

				//ver http://servicios.usig.buenosaires.gob.ar/usig-js/dev/ejemplos/gml/capas-gml.html
			}
		});
	};

})(window, document, jQuery);


// Inicia!
window.onload = function() {
	Displays.init(); 
}