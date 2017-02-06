PlayerExample.prototype = new PlayerBase();


	/**
	* Función: 		PlayerExample
	* Descripción: 	Constructor del módulo
	*
	* return (void)
	*/
		function PlayerExample() {

			// Le mando los argumentos al PlayerBase
				PlayerBase.apply(this, arguments);


			// Variable del módulo
			// Lo ideal es trabajar todas las variables del módulo acá adentro 
			// para evitar sobre escribir variables de otros módulos
				this.Example = {
					
				};

		}








	/**
	*
	* Funciones del módulo
	* (borrarlas en el caso de no utilizarlas)
	*
	*/

		/**
		* Función: 		myFunction
		* Descripción: 	
		*
		* return (void)
		*/
		 	PlayerExample.prototype.myFunction = function () {

		 	}


		/**
		* Función: 		createHandlebarsHelpers
		* Descripción: 	Crea los helpers para el Handlebars
		*
		* return (void)
		*/
			PlayerExample.prototype.createHandlebarsHelpers = function() {

		 	}


		/**
		* Función: 		loadStylesAndScripts
		* Descripción: 	Carga los styles y scripts del módulo
		*
		* return (void)
		*/
			PlayerExample.prototype.loadStylesAndScripts = function() {

		 	}


		/**
		* Función: 		retrieveExternalDataCallback
		* Descripción: 	Recibe la información
		*
		* return (void)
		*/
			PlayerExample.prototype.retrieveExternalDataCallback = function(data, that) {

				// Obtengo la external data del callback
					that.setExternalData(data);

				// Renderizo nuevamente la vista
					that.render();

				// Y llamo al _afterProcess
					that._afterProcess();

			}








	/**
	*
	* Hooks para sobreescribir
	* (borrarlos en el caso de no utilizarlos)
	*
	*/

		/**
		* Función: 		_afterInit
		* Descripción: 	Se ejecuta luego de cargar el constructor del módulo
		*
		* return (void)
		*/
			PlayerExample.prototype._afterInit = function () {

				// Do nothing

			}

		/**
		* Función: 		_end
		* Descripción: 	Se ejecuta antes de finalizar la ejecución del módulo
		* Importante: 	DEBE ejecutar la función this.end() antes de finalizar
		*
		* return (void)
		*/
			PlayerExample.prototype._end = function () {

				// Llamo a la función end
					this.end();

			}

		/**
		* Función: 		_finishProcess
		* Descripción: 	Se llama sólo cuando se termina de obtener el json del contenido
		*
		* return (void)
		*/
			PlayerExample.prototype._finishProcess = function () {

				// Busco la data externa
					this.retrieveExternalData( '', {} );

			}

		/**
		* Función: 		_afterProcess
		* Descripción: 	Notifica que el módulo está listo
		* Importante: 	DEBE ejecutarse después de la función this.render()
		*
		* return (void)
		*/
			PlayerExample.prototype._afterProcess = function () {

				// Llamo a la función ready
					this.ready();
					
			}

		/**
		* Función: 		_beforeShow
		* Descripción: 	Muestra el módulo
		* Importante: 	DEBE ejecutar a la función this.show() antes de finalizar
		*
		* return (void)
		*/
			PlayerExample.prototype._beforeShow = function () {

				// Llamo a la función show
					this.show();

			}

		/**
		* Función: 		_afterShow
		* Descripción: 	Se ejecuta inmediatamente después de this.show
		*
		* return (void)
		*/
			PlayerExample.prototype._afterShow = function () {

			}

		/**
		* Función: 		_beforeHide
		* Descripción: 	Oculta el módulo
		* Importante: 	DEBE ejecutar a la función this.show() antes de finalizar
		*
		* return (void)
		*/
			PlayerExample.prototype._beforeHide = function () {

				// Llamo a la función hide
					this.hide();

			}
			
		/**
		* Función: 		_afterHide
		* Descripción: 	Se ejecuta inmediatamente después de this.hide
		*
		* return (void)
		*/
			PlayerExample.prototype._afterHide = function () {

			}

		/**
		* Función: 		_goOffline
		* Descripción: 	Se ejecuta cuando se cae el internet en la pantalla
		*
		* return (void)
		*/
			PlayerExample.prototype._goOffline = function () {


			}

		/**
		* Función: 		_goOnline
		* Descripción: 	Se ejecuta cuando vuelve el internet en la pantalla
		*
		* return (void)
		*/
			PlayerExample.prototype._goOnline = function () {


			}


PlayerMain.addAvailableModule(PlayerExample.name, PlayerExample);