
	/**
	*
	* READY
	*
	*/
		$(document).ready(function(){

			//Prevent context menu
				// document.oncontextmenu = document.body.oncontextmenu = function() { return false; }

			// Alinea los tooltips hacia abajo
				$('[data-toggle="tooltip"]').tooltip( { placement: 'bottom' } );

			// Previene que los formularios se envien con enter
				$('form').not('#users-login .form').keypress(function(e) {
					var code = e.keyCode || e.which;

					if(code == 13) {
						return false;
					}
				});

		});





	/**
	*
	* FUNCIONES AUXILIARES
	*
	*/

		/**
		* Función: 		isInteger
		* Descripción: 	Chequea si una variable es de tipo integer
		*
		* return (boolean)
		*/
			function isInteger( value ) {

				if( typeof(value) === "number" && Math.floor(value) == value ) {
					return true;
				}

				return false;

			}

		/**
		* Función: 		isBoolean
		* Descripción: 	Chequea si una variable es de tipo boolean
		*
		* return (boolean)
		*/
			function isBoolean( value ) {

				if( typeof(value) === "boolean" ) {
					return true;
				}

				return false;

			}

		/**
		* Función: 		isArray
		* Descripción: 	Chequea si una variable es de tipo object
		*
		* return (boolean)
		*/
			function isArray ( value ) {

				if( value instanceof Array ) {
					return true;
				}

				return false;

			}

		/**
		* Función: 		isObject
		* Descripción: 	Chequea si una variable es de tipo boolean
		*
		* return (boolean)
		*/
			function isObject( value ) {

				if( typeof(value) === "object" ) {
					return true;
				}

				return false;

			}

		/**
		* Función: 		isFunction
		* Descripción: 	Chequea si una variable es de tipo function
		*
		* return (boolean)
		*/
			function isFunction ( value ) {

				if( typeof(value) === "function" ) {
					return true;
				}

				return false;

			}

		/**
		* Función: 		isEmptyObject
		* Descripción: 	Chequea si un object está vacío o no
		*
		* return (boolean)
		*/
			function isEmptyObject ( obj = {} ) {

				if( this.isObject(obj) )
				{
					for( var prop in obj ) {
						if( obj.hasOwnProperty(prop) ) {
							return false;
						}
					}

					return JSON.stringify(obj) === JSON.stringify({});
				}
				
				return false;

			}

		/**
		* Función: 		getObjectLength
		* Descripción: 	Devuelve la longitud de un objeto
		*
		* return (int)
		*/
			function getObjectLength( obj = {} ) {
				
				if( this.isObject(obj) )
				{
					var size = 0;

					for (var key in obj) {
						if (obj.hasOwnProperty(key)) {
							size++;
						}
					}

					return size;
				}
				
				return -1;

			}

		/**
		* Función: 		inArray
		* Descripción: 	Chequea si un valor está o no en un array
		*
		* return (boolean)
		*/
			function inArray ( array = [], value = null ) {

				if( value )
				{
					for (var i = 0; i < array.length; i++) {
						if( array[i] === value ) {
							return true;
						}
					}
				}

				return false;

			}

		/**
		* Función: 		shuffleArray
		* Descripción: 	Shuffles array in place.
		*
		* return (Array)
		*/
			function shuffleArray ( array = [] ) {

				var j, x, i;
				
				for (i = array.length; i; i--)
				{
					j = Math.floor(Math.random() * i);
					x = array[i - 1];
					array[i - 1] = array[j];
					array[j] = x;
				}

				return array;

			}