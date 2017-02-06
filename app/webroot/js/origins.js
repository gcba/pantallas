var Origins;

;(function(global, document, $){

	"use strict";

	Origins = global.Origins = global.Origins || {};


	/*
	 * init
	 * Inicia el objeto.
	 */
		Origins.init = function () {

			// Variable definida en fields.ctp, obtiene la acción y la pasa a minúsculas.
				ACTION_TYPE = ACTION_TYPE.toLowerCase();


			// Variables auxiliares
				Origins.editor 					= null;
				Origins.$Form 					= $($('#AddOriginForm')[0] || $('#EditOriginForm')[0]);
				Origins.$OriginSettings 		= $('#OriginSettings');
				Origins.$OriginSettingsEditor 	= $('#OriginSettingsEditor');
			

			// Si el tipo de acción NO ES view
				if( ACTION_TYPE != 'view' )
				{
					// Obtengo el formulario
						Origins.$Form.on('submit', function(e) {
							Origins.$OriginSettings.val( Origins.editor.getText() );
						});


					// Cargo las configuraciones
						Origins.setupSettings();
				}
				else {

					if( Origins.$OriginSettings.val().trim() != '' ) {
						Origins.$OriginSettings.val( JSON.stringify(JSON.parse(Origins.$OriginSettings.val()), null, 4) );
					}
					
				}

		};


	/*
	 * setupSettings
	 */
		Origins.setupSettings = function () {

			// Parseo las configuraciones
				var settings = Origins.$OriginSettings.val();

				if( ACTION_TYPE != 'add' ) {
					if( settings != '' ) {
						settings = JSON.parse(settings);
					}
					else {
						settings = {};
					}
				}
				else {
					settings = {
						fullscreen: {
							label: "Pantalla completa",
							value: false,
							editable: false
						},
						showTimer: {
							label: "Muestra el contador",
							value: true,
							editable: false
						},
						touchContent: {
							label: "Tiene contenido táctil",
							value: false,
							editable: false
						},
						requireOnline: {
							label: "Requiere estar online para funcionar",
							value: false,
							editable: false
						},
						instanceDuration: {
							label: "Tiempo de duración del contenido (en segundos)",
							value: 10,
							editable: true
						}
					};
				}

			// Pongo lindo el JSON
				Origins.editor = new JSONEditor(Origins.$OriginSettingsEditor[0], {});
				Origins.editor.set(settings);

		}


	/*
	 * setupSettings
	 */
		// Origins.setupSettings = function () {

		// 	// Pongo lindo el JSON
		// 		Origins.$OriginSettings.html(
		// 			JSON.stringify(
		// 				JSON.parse(
		// 					Origins.$OriginSettings.html()
		// 				),
		// 				undefined,
		// 				4
		// 			)
		// 		);

		// }


})(window, document, jQuery);


// Inicia!
window.onload = function() {
	Origins.init(); 
}