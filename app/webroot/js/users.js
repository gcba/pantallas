var Users;

;(function(global, document, $) {

	"use strict";

	Users = global.Users = global.Users || {};


	/*
	 * init
	 * Inicia el objeto.
	 */
		Users.init = function () {

			// Variable definida en fields.ctp, obtiene la acción y la pasa a minúsculas.
				ACTION_TYPE = ACTION_TYPE.toLowerCase();

			
			// Si el tipo de acción es add o edit
				if( ACTION_TYPE == 'add' || ACTION_TYPE == 'edit' )
				{
					// Defino las siguientes variables globales
						Users.$InputRole 	= $('#UserRole');
						Users.$InputTag 	= $('#UserTagGroup');

					// Evento cuando cambia el valor del rol
						Users.$InputRole.on('change', function(e) {
							Users.checkTagsField();
						});

					// Y de todas formas lo chequeo la primera vez que lo inicio
						Users.checkTagsField();
				}

		};


	/*
	 * checkTagsField
	 * Chequea si tiene que mostrar o no el campo para agregar TAGS.
	 */
		Users.checkTagsField = function () {

			var value = Users.$InputRole.find(':selected').val();

			// Si el VALUE del Rol seleccionado está vacío o es SUPER-ADMIN (Root)
			if( value == '' || value == 'SUPER-ADMIN' ) {
				// Oculto los tags
					Users.$InputTag.hide();
			}
			else {
				// Los muestro
					Users.$InputTag.show();
			}

		};


})(window, document, jQuery);


// Inicia!
window.onload = function() {
	Users.init(); 
}