var Contents;

;(function(global, document, $){

	"use strict";

	Contents = global.Contents = global.Contents || {};


	/*
	 * Variables Globales
	 */
		Contents.settings = null;


	/*
	 * init
	 * Inicia el objeto.
	 */
		Contents.init = function () {
				
			// Variable definida en fields.ctp, obtiene la acción y la pasa a minúsculas.
				ACTION_TYPE = ACTION_TYPE.toLowerCase();
			

			// Variables auxiliares
				Contents.$Form 						= $($('#AddContentForm')[0] || $('#EditContentForm')[0]);
				Contents.$Origin 					= $('#ContentOrigenId');
				Contents.$OriginGroup 				= $('#OriginGroup');
				Contents.$ContentSettings 			= $('#ContentSettings');
				Contents.$ContentSettingsEditor 	= $('#ContentSettingsEditor');
				Contents.$SettingsFields 			= $('#SettingsFields');

			
			// Si el tipo de acción es add
				if( ACTION_TYPE == 'add' )
				{
					// Evento cuando cambia el origen
						Contents.$Origin.on('change', function(e) {
							Contents.changeOrigin();
						});
				}


			// Si el tipo de acción es edit
				if( ACTION_TYPE == 'edit' )
				{
					// Escondo el select
						Contents.$OriginGroup.hide();
				}


			// Si el tipo de acción NO ES view
				if( ACTION_TYPE != 'view' )
				{
					// Y de todas formas lo chequeo la primera vez que lo inicio
						Contents.changeOrigin();

					// Obtengo el formulario
						Contents.$Form.on('submit', function(e) {

							var fields 		= Contents.$SettingsFields.find('.form-control'),
								settings 	= {};

							for(var i = 0; i < fields.length; i++)
							{
								var key 	= $(fields[i]).data('key'),
									value 	= $(fields[i]).val();

								Contents.settings[key].value = value;
							}

							Contents.$ContentSettings.val( JSON.stringify(Contents.settings) );

						});
				}
				else {

					if( Contents.$ContentSettings.val().trim() != '' ) {
						Contents.$ContentSettings.val( JSON.stringify(JSON.parse(Contents.$ContentSettings.val()), null, 4) );
					}
					
				}

		};


	/*
	 * setupSettings
	 */
		Contents.setupSettings = function ( settings = null ) {

			// Si las configuraciones que vienen por parámetro son válidas
				if( settings && typeof settings !== 'undefined' && settings != '' )
				{
					// Variables auxiliares
						Contents.settings = {};

					// Obtengo las configuraciones locales
						var localSettings 	= ( Contents.$ContentSettings.val() != '' ? JSON.parse(Contents.$ContentSettings.val()) : {} );
							settings 		= JSON.parse(settings);

					// Recorro cada item para mostrarlos como campos
						for(var item in settings) {
							if( !settings[item].editable ) {
								delete settings[item];
							}
							else {
								// delete settings[item].label;
								// delete settings[item].editable;
							}
						}

						for (var item in settings) {
							if( !(item in localSettings) ) {
								Contents.settings[item] = settings[item];
							}
							else {
								Contents.settings[item] = localSettings[item];
							}
						}

					// Recorro cada item para mostrarlos como campos
						for(var item in Contents.settings)
						{
							var formGroup = $('<div/>', { class: 'form-group' });
							var data = {
								key: item
							};

							$('<label/>', {
								text: settings[item].label
							})
							.appendTo( formGroup );

							$('<input/>', {
								value: Contents.settings[item].value,
								class: 'form-control'
							})
							.attr('data-key', item)
							.appendTo( formGroup );

							formGroup.appendTo( Contents.$SettingsFields );
						}

					// Junto las configuraciones globales y locales (las locales por sobre las globales)
						// $.extend( true, Contents.settings, settings, localSettings );

					// Las guardo en el campo de Settings
						Contents.$ContentSettings.val(JSON.stringify(Contents.settings));

				}
			// O sino limpio los campos
				else
				{
					Contents.$ContentSettings.val('');
					Contents.$SettingsFields.html('');
				}

		}


	/*
	 * changeOrigin
	 */
		Contents.changeOrigin = function() {

			// Configuraciones del contenido
				Contents.$SettingsFields.html('');
				Contents.setupSettings( ORIGIN_SETTINGS[Contents.$Origin.val()] );

		};

})(window, document, jQuery);


// Inicia!
window.onload = function() {
	Contents.init(); 
}