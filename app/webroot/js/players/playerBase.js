	
	/**
	* Función: 		PlayerBase
	* Descripción: 	Constructor de la instancia
	*
	* return (void)
	*/
		function PlayerBase() {

			// Variables del módulo
				this.instance = {
					
					// Principales
						id: 						null, 		// (int) 			ID del módulo
						type: 						null, 		// (string) 		Tipo del módulo
						name: 						null, 		// (string) 		Nombre del módulo

						settings: { 							// (object) 		Configuraciones del módulos
							fullscreen: 			false,
							showTimer: 				true,
							touchContent: 			false,
							requireOnline: 			false,
							instanceDuration: 		10
						},
						usa_cron: 					false, 		// (boolean) 		Si usa o no CRON el origen

						local_data: 				null, 		// (object) 		Data local del módulo
						external_data: 				null, 		// (object) 		Variable para guardar la Data del módulo después del AJAX
						
						template: 					null,		// (function) 		Función para renderizar el template con Handlebars
						container: 					null, 		// (DOM Element)	Elemento contenedor del módulo
						// scripts: 					[], 		// (array) 			Lista de los scripts que requiere el módulo

					// Timer
						timer: {
							timer:					null, 		// (object) 		Variable
							duration: 				30, 		// (int) 			Duración
							counter: 				0, 			// (int) 			Contador
							isPaused: 				false, 		// (boolean) 		Está pauseado
							updateInterval: 		1 			// (int) 			Intervalo de actualización
						},

				};
		}








	/**
	*
	* GENERALES
	*
	*/

		/**
		* Función: 		init
		* Descripción: 	Setea el módulo inicialmente
		*
		* Parámetros:
		* 	(int) 		id
		* 	(string) 	type
		* 	(object) 	metadata
		*
		* return (void)
		*/
			PlayerBase.prototype.init = function(id, type, name, settings, origin) {
				
				// Guardo los datos de la instancia
					this.instance.id 				= id;
					this.instance.type 				= type;
					this.instance.name 				= name;

					this.instance.usa_cron 			= origin.usa_cron;
					this.instance.originSettings 	= origin.settings;
					this.instance.settings 			= this.parseSettings( settings );

					this.instance.container 		= $(window.document.getElementById('content-container-' + id));


				// Carga las configuraciones
					this.loadSettings();


				// Carga los styles y scripts
					this._loadStylesAndScripts();

				// Carga los helpers para el handlebars
					this._createHandlebarsHelpers();

				// Llamo al evento del afterInit
					this._afterInit();

			}

		/**
		* Función: 		parseSettings
		* Descripción: 	Prepara las configuracones del módulo
		*
		* Parámetros:
		* 	(object) 	localSettings
		*
		* return (object)
		*/
			PlayerBase.prototype.parseSettings = function( localSettings ) {
						
				// Casos
				// DEFAULT SIEMPRE TIENE
				// 1- Puede tener global pero no local
				// 2- Puede tener local pero no global
				// Primero intento cargar las globales
				// Y cargue o no, cargo las locales
					var settings 		= this.instance.settings,
						originSettings 	= this.instance.originSettings,
						parsedSettings 	= {};


				// Si existe
					if( originSettings )
					{
						// Convierto el json en un objeto
							originSettings = JSON.parse(originSettings);

						// Parseo las configuraciones
							for(var item in originSettings) {
								if( isObject(originSettings[item]) && 'value' in originSettings[item] ) {
									originSettings[item] = originSettings[item].value;
								}
								else {
									originSettings[item] = originSettings[item];	
								}
							}

						// Si es un objeto, los mergeo
							if( isObject(originSettings) ) {
								$.extend( true, settings, originSettings );
								// Object.assign( settings, originSettings );
							}
					}

				// Si existe
					if( localSettings )
					{
						// Convierto el json en un objeto
							localSettings = JSON.parse(localSettings);

						// Parseo las configuraciones
							for(var item in localSettings) {
								if( isObject(localSettings[item]) && 'value' in localSettings[item] ) {
									localSettings[item] = localSettings[item].value;
								}
								else {
									localSettings[item] = localSettings[item];	
								}
							}

						// Si es un objeto, los mergeo (SOLO LOS REPETIDOS)
							if( isObject(localSettings) ) {

								for (var attrname in localSettings) {
									if( attrname in settings ) {
										settings[attrname] = localSettings[attrname];
									}
								}
								// $.extend( true, settings, localSettings );
								// Object.assign( settings, localSettings );
							}
					}


				// Devuelvo las configuraciones
					return settings;

			}

		/**
		* Función: 		loadSettings
		* Descripción: 	Setea las configuracones del módulo
		* 
		* return (void)
		*/
			PlayerBase.prototype.loadSettings = function() {
						
				// Las seteo
					this.setFooter( !this.instance.settings.fullscreen );
					this.setTimer( this.instance.settings.showTimer );
					this.setTouchContent( this.instance.settings.touchContent );
					this.setRequireOnline( this.instance.settings.requireOnline );
					this.setInstanceDuration( this.instance.settings.instanceDuration );

			}

		/** 
		* Función: 		_loadStylesAndScripts
		* Descripción: 	Cargar los styles y scripts del módulo
		* 
		* return (void)
		*/
			PlayerBase.prototype._loadStylesAndScripts = function() {

		 	}

		/**
		* Función: 		_createHandlebarsHelpers 
		* Descripción: 	Crea los helpers para el Handlebars
		* 
		* return (void)
		*/
			PlayerBase.prototype._createHandlebarsHelpers = function() {

		 	}








	/**
	*
	* PROCESAMIENTO
	*
	*/

		/**
		* Función: 		process 
		* Descripción: 	Función encargada de procesar el módulo
		* 
		* return (void)
		*/
			PlayerBase.prototype.process = function() {

				// Guardo la funcion para compilar el template
					this.setTemplate( Handlebars.compile( $('#template_' + this.instance.type).html() ) );
				
				// Voy a buscar la data del contenido
					this.retrieveLocalData();

			}

		/**
		* Función: 		retrieveLocalData 
		* Descripción: 	Obtengo la data local del módulo
		* 
		* return (void)
		*/
			PlayerBase.prototype.retrieveLocalData = function () {
					
				// Variablex auxiliares
					var that = this;

				// Si existe el Origen (Alertas y Mensajes no tienen origen)
					if(this.instance.usa_cron)
					{
						// Voy a buscar la local data del contenido
							$.getJSON('/contenidos/json/' + this.instance.id)
							// Success
								.done(function(data) {

									// Valido la data que viene en el callback
										if(data === "" || data === null) {
											data = [];
										}
										else if(typeof(data) !== "object") {
											data = JSON.parse(data);
										}
										// else{
										// 	//ya es un obj no lo convierto, ocurre en las alertas
										// }

									// Guardo la data
										that.setLocalData(data);
								})
							// Error
								.fail(function(data) {

									// Muestro un mensaje de error
										console.error("Ocurrió un problema al intentar cargar la local data del módulo '" + that.instance.name + "'");

									// Seteo que la instancia tiene un error
										that.setError( true );

								})
							// Siempre, falle o no, termina el procesamiento
								.always(function() {

									// Termino el renderizado
										that._finishProcess();

								});
					}
				// O sino
					else
					{
						// Termino el renderizado
							this._finishProcess();
					}

			}

		/**
		* Función: 		retrieveExternalData 
		* Descripción: 	Obtengo la data externa del módulo
		* 
		* return (void)
		*/
			PlayerBase.prototype.retrieveExternalData = function( url = '', parameters = {} ) {
					
				// Variablex auxiliares
					var that = this;

				// Chequeo que el parámetro sea un objeto
					if( url.trim() != '' && isObject(parameters) )
					{
						// Voy a buscar la external data del contenido
							$.getJSON( url, parameters )
						// Success
							.done(function(data) {

								// Llamo al callback
									that.retrieveExternalDataCallback(data, that);

							})
						// Error
							.fail(function(data){

								// Muestro un mensaje de error
									console.error("Ocurrió un problema al intentar cargar la external data del módulo '" + that.instance.name + "'");

								// Seteo que la instancia tiene un error
									that.setError( true );

							});
					}
			}

		/**
		* Función: 		render 
		* Descripción: 	Renderiza el template con los datos correspondientes en el container
		* 
		* return (void)
		*/
			PlayerBase.prototype.render = function () {

				// Guardo el container en la variable
					var moduleContainer = this.getContainer();

				// Si existe el container
					if( moduleContainer )
					{

						// Guardo el template en la variable
							var moduleTemplate 	= this.getTemplate(),
								moduleData 		= {
									local_data: 	this.instance.local_data,
									external_data: 	this.instance.external_data/*,
									settings: 		this.instance.settings*/
								};						

						// Si existe el template
							if( moduleTemplate )
							{
								// Renderizo el template con la función del handlebars
									moduleContainer.html( moduleTemplate(moduleData) );
							}
						// Sino, digo que hay un error en el módulo
							else {
								console.error("No se pudo encontrar el template del módulo '" + this.getName() + "'");
								this.setError( true );
							}

					}
				// Sino, digo que hay un error en el módulo
					else {
						console.error("No se pudo encontrar el contenedor del módulo '" + this.getName() + "'");
						this.setError( true );
					}

			}

		/**
		* Función: 		ready 
		* Descripción: 	Disparo el evento 'instance-ready' sobre el módulo
		* Ejecución: 	Se llama cuando la instancia está lista
		* 
		* return (void)
		*/
			PlayerBase.prototype.ready = function() {

				// Disparo el trigger con la instancia por parámetro
					$(this).trigger('instance-ready', [this]);

			}








	/* REPRODUCCIÓN
	 *
	 */

		/* begin
		 * 
		 * Inicia la instancia
		 */
			PlayerBase.prototype.begin = function () {

				// Inicio el timer
					this.startTimer();

				// Llamo a la función _beforeShow antes de mostrar el módulo
					this._beforeShow();

			}


		/* end
		 * 
		 * Disparo el evento 'instance-ended' sobre la instancia
		 * Se llama cuando se termina de reproducir la instancia
		 */
			PlayerBase.prototype.end = function() {

				// Disparo el trigger
					$(this).trigger('instance-ended');

			}


		/* stop
		 * 
		 * Fuerza el frenado de la instancia
		 */
			PlayerBase.prototype.stop = function () {

				// Freno el timer
					this.stopTimer();

				// Llamo a la función _beforeHide antes de ocultar el módulo
					this._beforeHide();

			}


		/* show
		 * 
		 * Se ejecuta inmediatamente después de this._beforeShow
		 */
			PlayerBase.prototype.show = function () {

				var that = this;

				// Muestro el contenedor de la instancia
					this.getContainer().fadeIn(1000, function(){
						that._afterShow();
					});

			}


		/* hide
		 * 
		 * Se ejecuta inmediatamente después de this._beforeHide
		 */
			PlayerBase.prototype.hide = function () {

				var that = this;

				// Oculto el contenedor de la instancia
					this.getContainer().fadeOut(1000, function(){
						that._afterHide();
					});

			}








	/* TIMER
	 *
	 */

		/* startTimer
		 * 
		 * Inicia el timer
		 */
			PlayerBase.prototype.startTimer = function () {

				// Variables auxiliares
					var that 		= this,
						handlEvents = 'click scroll touchstart touchmove';


				// Como no se si la instancia anterior me agregó un evento al DOM
				// Remuevo todos los eventos 'click' del DOCUMENT
					$(document).off(handlEvents);
					

				// Si TIENE contenido touch
					if( this.hasTouchContent() )
					{
						// Agrego el evento click al DOCUMENT que restartee el timer
							$(document).on(handlEvents,function(event) {
								that.restartTimer();
							});
					}
			

				// Si TIENE timer
					// if( this.hasTimer() )
					// {
						// Si NO existe el timer
							if( !this.instance.timer.timer )
							{
								// Freno la animación del timer de la vista, le seteo el nuevo width y lo muestro 
									PlayerMain.getTimer()
													.stop()
													.width('100%');


								// Seteo un nuevo timer y lo actualizo cada cierto tiempo según la variable this.instance.timer.updateInterval
									this.instance.timer.timer = setInterval(function(){
										that.updateTimer();
									}, this.instance.timer.updateInterval * 1000);
							}
					// }

			}


		/* pauseTimer
		 * 
		 * Setea la variable de pausa del timer
		 */
			PlayerBase.prototype.pauseTimer = function () {
			
				// Si TIENE timer
					// if( this.hasTimer() )
					// {
						// Invierto el valor de la variable
							this.instance.timer.isPaused = !this.instance.timer.isPaused;
					// }

			}


		/* stopTimer
		 * 
		 * Frena el timer
		 */
			PlayerBase.prototype.stopTimer = function () {
			
				// Si TIENE timer
					// if( this.hasTimer() )
					// {
						// Si es la existe el Timer
							if( this.instance.timer.timer )
							{
								// Lo freno
									clearTimeout(this.instance.timer.timer);


								// Freno el timer, lo mando al 0% y lo oculto
									PlayerMain.getTimer()
													.stop()
													.width('0%');


								// Reseteo variables
									this.instance.timer.timer 	= null;
									this.instance.timer.counter = 0;
							}
					// }

			}


		/* restartTimer
		 * 
		 * Resetea el tiempo del timer
		 */
			PlayerBase.prototype.restartTimer = function () {
			
				// Lo frena y lo vuelve a iniciar
					this.stopTimer();
					this.startTimer();

			}


		/* updateTimer
		 * 
		 * Actualiza el timer
		 */
			PlayerBase.prototype.updateTimer = function () {
			
				// Si TIENE timer
					if( this.hasTimer() )
					{
						// Si el timer no está pauseado
							if( !this.instance.timer.isPaused )
							{
								// Incremento el contador del timer
									this.instance.timer.counter++;


								// Actualizo el width del timer
									var width = (this.instance.timer.counter * 100) / this.instance.timer.duration;
									PlayerMain.getTimer().animate(
										{ width: (100 - width) + '%' },
										{ duration: 1000, easing: 'linear' }
									);

								// Si el contador es igual a la duración de la instancia
									if( this.instance.timer.counter == this.instance.timer.duration + 1 )
									{
										// Freno el timer
											this.stopTimer();

										// Termino la instancia
											this._end();
									}
							}
					}

			}








	/**
	*
	* GETTERS
	*
	*/

		/**
		* Función: 		getContainer
		* Descripción: 	Devuelve el contenedor del módulo
		*
		* return (DOM element)
		*/
			PlayerBase.prototype.getContainer = function () {

				// Si no existe el contenedor devuelvo null				
					if(this.instance.container.length == 0) {
						return null;
					}

				return this.instance.container;
			}

		/**
		* Función: 		getTemplate
		* Descripción: 	Devuelve el template del módulo
		*
		* return (function)
		*/
			PlayerBase.prototype.getTemplate = function () {
				return this.instance.template;
			}

		/**
		* Función: 		getLocalData
		* Descripción: 	Devuelve la local data del módulo
		*
		* return (object)
		*/
			PlayerBase.prototype.getLocalData = function () {
				return this.instance.local_data;
			}

		/**
		* Función: 		getExternalData
		* Descripción: 	Devuelve la external data del módulo
		*
		* return (object)
		*/
			PlayerBase.prototype.getExternalData = function () {
				return this.instance.external_data;
			}











		/* getId
		 * 
		 * Devuelve el ID del módulo
		 */
			PlayerBase.prototype.getId = function () {
				return parseInt(this.instance.id);
			}

		/* getName
		 * 
		 * Devuelve el nombre del módulo
		 */
			PlayerBase.prototype.getName = function () {
				return this.instance.name;
			}

		/* getScripts
		 * 
		 * Devuelve la lsita de scripts
		 */
			PlayerBase.prototype.getScripts = function () {
				return this.instance.scripts;
			}

		/* hasError
		 * 
		 * Devuelve si el módulo tiene o no error
		 */
			PlayerBase.prototype.hasError = function () {
				return this.instance.hasError;
			}

		/* hasFooter
		 * 
		 * Devuelve si el módulo tiene o no error
		 */
			PlayerBase.prototype.hasFooter = function () {
				return this.instance.hasFooter;
			}

		/* hasTimer
		 * 
		 * Devuelve si el módulo tiene o no error
		 */
			PlayerBase.prototype.hasTimer = function () {
				return this.instance.hasTimer;
			}

		/* hasTouchContent
		 * 
		 * Devuelve si el módulo tiene o no error
		 */
			PlayerBase.prototype.hasTouchContent = function () {
				return this.instance.hasTouchContent;
			}

		/* requireOnline
		 * 
		 * Devuelve si el módulo tiene o no error
		 */
			PlayerBase.prototype.requireOnline = function () {
				return this.instance.requireOnline;
			}








	/**
	*
	* SETTERS
	*
	*/

		/**
		* Función: 		setLocalData
		* Descripción: 	Setea la data local del módulo
		*
		* Parámetros:
		* 	(object) data
		*
		* return (void)
		*/
			PlayerBase.prototype.setLocalData = function ( data = {} ) {

				// Si el value es de tipo BOOLEAN
					if( isObject(data) )
					{
						// Seteo la VARIABLE
							this.instance.local_data = data;
					}

			}

		/**
		* Función: 		setExternalData
		* Descripción: 	Setea la data externa del módulo
		*
		* Parámetros:
		* 	(object) data
		*
		* return (void)
		*/
			PlayerBase.prototype.setExternalData = function ( data = {} ) {

				// Si el value es de tipo BOOLEAN
					if( isObject(data) )
					{
						// Seteo la VARIABLE
							this.instance.external_data = data;
					}

			}

		/**
		* Función: 		setTemplate
		* Descripción: 	Setea el template del módulo
		*
		* Parámetros:
		* 	(function) template
		*
		* return (void)
		*/
			PlayerBase.prototype.setTemplate = function ( template = null ) {

				// Si el value es de tipo FUNCTION
					if( isFunction(template) )
					{
						// Seteo la VARIABLE
							this.instance.template = template;
					}

			}











		/* setData
		 * 
		 * Setea la data del módulo
		 * (object) data
		 */
			PlayerBase.prototype.setData = function ( data ) {

				// Si el value es de tipo BOOLEAN
					if( isObject(data) )
					{
						// Seteo la VARIABLE
							this.instance.data = data;
					}

			}

		/* setMetadata
		 * 
		 * Setea la metadata del módulo
		 * (object) metadata
		 */
			PlayerBase.prototype.setMetadata = function ( metadata ) {

				// Si el value es de tipo BOOLEAN
					if( isObject(metadata) )
					{
						// Seteo la VARIABLE
							this.instance.metadata = metadata;
					}

			}

		/* addStyles
		 * 
		 * Agrega un style a la lista de styles
		 * (string) style
		 */
			PlayerBase.prototype.addStyle = function ( style = "" ) {

				// Sumo a la lista el nuevo style
					PlayerMain.getStyles().push(style);

			}

		/* setStyles
		 * 
		 * Setea la lista de styles
		 * (array) styles
		 */
			PlayerBase.prototype.setStyles = function ( styles ) {

				// Seteo los nuevo styles
					PlayerMain.setStyles(styles);

			}

		/* addScript
		 * 
		 * Agrega un script a la lista de scripts
		 * (string) script
		 */
			PlayerBase.prototype.addScript = function ( script = "" ) {

				// Sumo a la lista el nuevo script
					PlayerMain.getScripts().push(script);

			}

		/* setScripts
		 * 
		 * Setea la lista de scripts
		 * (array) scripts
		 */
			PlayerBase.prototype.setScripts = function ( scripts ) {

				// Seteo los nuevo scripts
					PlayerMain.setScripts(scripts);

			}

		/* setError
		 * 
		 * Setea si tiene o no Error el módulo
		 * (boolean) value
		 */
			PlayerBase.prototype.setError = function ( value ) {


				// Si el value es de tipo BOOLEAN
					if( isBoolean(value) )
					{
						// Seteo la VARIABLE
							this.instance.hasError = value;

						// Lo agrego a la lista de instancias con error
							PlayerMain.addInstanceError( this.getId() );
					}
					else
					{
						// Lo remuevo de la lista de instancias con error
							PlayerMain.removeInstanceError( this.getId() );
					}

			}

		/* setFooter
		 * 
		 * Setea si tiene o no Footer
		 * (boolean) value
		 */
			PlayerBase.prototype.setFooter = function ( value ) {

				// Si el value es de tipo BOOLEAN
					if( isBoolean(value) )
					{
						// Seteo la VARIABLE
							this.instance.hasFooter = value;
					}

			}

		/* setTimer
		 * 
		 * Setea si tiene o no Timer
		 * (boolean) value
		 */
			PlayerBase.prototype.setTimer = function ( value ) {

				// Si el value es de tipo BOOLEAN
					if( isBoolean(value) )
					{
						// Seteo la VARIABLE
							this.instance.hasTimer = value;

						// Según el valor de la variable lo muestro o lo oculto
							if( this.hasTimer() ) {
								PlayerMain.showTimer();
							}
							else {
								PlayerMain.hideTimer();
							}
					}

			}

		/* setTouchContent
		 * 
		 * Setea si tiene o no Contenido Touch
		 * (boolean) value
		 */
			PlayerBase.prototype.setTouchContent = function ( value ) {

				// Si el value es de tipo BOOLEAN
					if( isBoolean(value) )
					{
						// Seteo la VARIABLE
							this.instance.hasTouchContent = value;
					}

			}

		/* setRequireOnline
		 * 
		 * Setea si el módulo requiere o no estar online
		 * (boolean) value
		 */
			PlayerBase.prototype.setRequireOnline = function ( value ) {

				// Si el value es de tipo BOOLEAN
					if( isBoolean(value) )
					{
						// Seteo la VARIABLE
							this.instance.requireOnline = value;
						
					}

			}

		/* setInstanceDuration
		 * 
		 * Setea el tiempo de la duración de la instancia
		 * (int) duration: en segundos
		 */
			PlayerBase.prototype.setInstanceDuration = function ( duration ) {

				// Si la duración es de tipo INT
					if( isInteger(duration) )
					{
						// Seteo la duración
							this.instance.timer.duration = duration;
					}

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
			PlayerBase.prototype._afterInit = function () {

				// Do nothing

			}

		/**
		* Función: 		_end
		* Descripción: 	Se ejecuta antes de finalizar la ejecución del módulo
		* Importante: 	DEBE ejecutar la función this.end() antes de finalizar
		*
		* return (void)
		*/
			PlayerBase.prototype._end = function () {

				// Llamo a la función end
					this.end();

			}

		/**
		* Función: 		_finishProcess
		* Descripción: 	Se llama sólo cuando se termina de obtener el json del contenido
		*
		* return (void)
		*/
			PlayerBase.prototype._finishProcess = function () {
				
				// Cuando termina de procesar, llamo al render
					this.render();

				// Y llamo al _afterProcess 
					this._afterProcess();

			}

		/**
		* Función: 		_afterProcess
		* Descripción: 	Notifica que el módulo está listo
		* Importante: 	DEBE ejecutarse después de la función this.render()
		*
		* return (void)
		*/
			PlayerBase.prototype._afterProcess = function () {

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
			PlayerBase.prototype._beforeShow = function () {

				// Llamo a la función show
					this.show();

			}

		/**
		* Función: 		_afterShow
		* Descripción: 	Se ejecuta inmediatamente después de this.show
		*
		* return (void)
		*/
			PlayerBase.prototype._afterShow = function () {

			}

		/**
		* Función: 		_beforeHide
		* Descripción: 	Oculta el módulo
		* Importante: 	DEBE ejecutar a la función this.show() antes de finalizar
		*
		* return (void)
		*/
			PlayerBase.prototype._beforeHide = function () {

				// Llamo a la función hide
					this.hide();

			}
			
		/**
		* Función: 		_afterHide
		* Descripción: 	Se ejecuta inmediatamente después de this.hide
		*
		* return (void)
		*/
			PlayerBase.prototype._afterHide = function () {

			}

		/**
		* Función: 		_goOffline
		* Descripción: 	Se ejecuta cuando se cae el internet en la pantalla
		*
		* return (void)
		*/
			PlayerBase.prototype._goOffline = function () {


			}

		/**
		* Función: 		_goOnline
		* Descripción: 	Se ejecuta cuando vuelve el internet en la pantalla
		*
		* return (void)
		*/
			PlayerBase.prototype._goOnline = function () {


			}

