var PlayerMain;

;(function(window, document, $){

	"use strict";

	PlayerMain = window.playermain = window.playermain || {};

	// Variables globales

		// Display
			PlayerMain.display  = null;

		// Módulos, instancias y scripts
			PlayerMain.modules = {
				availables: 		[],
				list: 				{}
			};
			PlayerMain.instances = {
				list: 				[],
				styles: 			[],
				scripts: 			[],
				current: 			-1,
				error: 				[],
				temp: 				[]
			};

		// Timer, interval
			PlayerMain.timer = {
				transition: 		null,
				offline: 			null
			};
			PlayerMain.interval = {
				transition: 		1, 			// 1 segundo
				offline: 			30, 		// 30 segundos
				clock: 				1, 			// 1 segundo
				refresh: 			30 * 60, 	// 30 minutos
				forceRefresh: 		1 * 60 		// 1 minuto
			};

		// Generales, AJAX, DOM
			PlayerMain.vars = {
				youtubeAPIReady: 	false,
				date: 				{}
			};
			PlayerMain.ajax = {
				refresh: 			'refresh',
				forceRefresh: 		'forceRefreshDetection',
				EstadoSubte: 		'estadoSubte',
				NoEncontrado: 		'noEncontrado',
				RSS: 				'RSS'
			};
			PlayerMain.DOM = {
				preloader: 			null,
				footer: 			null,
				timer: 				null,
				offline: 			null,
				touchOverlay: 		null
			};

		// Constantes
			PlayerMain.constants = {
				days: [
					'Domingo',
					'Lunes',
					'Martes',
					'Miércoles',
					'Jueves',
					'Viernes',
					'Sábado'
				],
				months: [
					'Enero',
					'Febrero',
					'Marzo',
					'Abril',
					'Mayo',
					'Junio',
					'Julio',
					'Agosto',
					'Septiembre',
					'Octubre',
					'Noviembre',
					'Diciembre'
				]
			};



	/**
	* Función: 		init
	* Descripción: 	Inicia el plugin
	*
	* return (void)
	*/
		PlayerMain.init = function () {

			// Seteo los eventos de conexión
				this.setConnectionEvents();

			// Arranco el reloj
				this.setClock();

			// Creo los Helpers para el handlebars
				this.setHandlebarsHelpers();

			// Seteo los DOM elements
				this.setDOMElements();

			// Muestro el preloader
				this.showPreloader();

		};








	/**
	* Función: 		ready
	* Descripción: 	Prepara las instancias e inicia la reproducción de la pantalla
	*
	* return (void)
	*/
		PlayerMain.ready = function () {

			// Preparo las instancias
				this.setupInstances();

			// Seteo el intervalo de refresh
				this.setRefresh();

			// Seteo el intervalo de refresh
				this.setForceRefreshDetection();

		};

	/**
	* Función: 		start
	* Descripción: 	Inicia la reproducción de los módulos
	*
	* return (void)
	*/
		PlayerMain.start = function () {

			// Variables auxiliares
				var instanceList = this.getInstanceList();

			// Si hay al menos una instancia
				if( instanceList.length > 0 )
				{
					// Mezclo las instancias
						this.setInstanceList( shuffleArray( instanceList ) );

					// Oculto el preloader
						this.hidePreloader();

					// Empiezo a reproducirlas
						this.nextInstance();
				}
				else {
					console.error('Pantalla sin contenido.');
				}

		};

	/**
	* Función: 		reset
	* Descripción: 	Sin uso por el momento
	*
	* return (void)
	*/
		PlayerMain.reset = function () {

		};

	/**
	* Función: 		stop
	* Descripción: 	Sin uso por el momento
	*
	* return (void)
	*/
		PlayerMain.stop = function () {

		};








	/**
	* Función: 		setupInstances
	* Descripción: 	Inicializa todo lo referido a las instancias
	*
	* return (void)
	*/
		PlayerMain.setupInstances = function () {

			// Crea la instancia de cada origen
				this.createInstances();

			// Cargo los style y scripts de las instancias
				this.loadInstanceStylesAndScripts();

			// Renderizo las instancias
				this.processInstances();

		};

	/**
	* Función: 		createInstances
	* Descripción: 	Crea las instancias temporales en base a la lista de módulos cargados y los módulos disponibles
	*
	* return (void)
	*/
		PlayerMain.createInstances = function () {

			// Variables auxiliares
				var that 				= this,
					availableModules 	= this.getAvailableModulesList(), 	// Módulos disponibles
					modulesList 		= this.getModulesList(); 			// Lista de módulos cargados

			// Por cada contenido de la lista
				for(var index in modulesList)
				{
					var id 				= modulesList[index].contenido_id,
						name 			= modulesList[index].name,
						type 			= modulesList[index].type,
						settings 		= modulesList[index].settings,
						origin 			= {
							settings: modulesList[index].origin.settings,
							usa_cron: modulesList[index].origin.usa_cron
						};

					// Si existe la función constructora del contenido
						if( availableModules['Player' + type] )
						{
							// Construyo la instancia y la inicio
								var instance = new availableModules['Player' + type]();
									instance.init(id, type, name, settings, origin);

							// Guardo las instancia temporalmente
								this.addInstanceTemp(instance);
						}
				}

			// Si no cargó ninguna instancia temporalmente, muestro la pantalla offline
				var instanceTempList = this.getInstanceTempList();

				if( instanceTempList.length == 0 ) {
					this.showOffline();
				}

		};

	/**
	* Función: 		loadInstanceStylesAndScripts
	* Descripción: 	Carga las hojas de estilos y los scripts de las instancias
	*
	* return (void)
	*/
		PlayerMain.loadInstanceStylesAndScripts = function () {

			// Variables auxiliares
				var styles 	= this.getStyles(),
					scripts = this.getScripts();

			// Recorro los styles
				for(var index in styles)
				{
					// Los cargo
						$('<link/>', {
							rel: 'stylesheet',
							type: 'text/css',
							href: styles[index]
						}).appendTo('head');
				}

			// Recorro los scripts
				for(var index in scripts)
				{
					// Los cargo
						// getScript
							$.getScript(scripts[index])
						// Success
							// .done(function( script, textStatus ) {
							// 	console.log( textStatus );
							// })
						// Error
							.fail(function( jqxhr, settings, exception ) {
								console.err("Error al cargar el siguiente script: '" + scripts[index] + "'");
							});
				}

		};

	/**
	* Función: 		processInstances
	* Descripción: 	Procesa las instancias
	*
	* return (void)
	*/
		PlayerMain.processInstances = function () {

			// Variables auxiliares
				var that 				= this,
					tempInstanceList 	= this.getInstanceTempList();

			// Por cada instancia temporal
				for(var index in tempInstanceList)
				{
					// Guardo la instancia en una variable
						var instance = tempInstanceList[index];

					// Le digo que cuando se ejecute el evento se llame a la función instanceReady
						$(instance).on('instance-ready', function( event, instance ){
							that.instanceReady( event, instance );
						});

					// Proceso la instancia
						instance.process();

				}

			// Si no procesó ninguna instancia temporalmente, muestro la pantalla offline
				if( tempInstanceList.length == 0 ) {
					this.showOffline();
				}

		};

	/**
	* Función: 		instanceReady
	* Descripción: 	Le carga a cada instancia un evento de finalización y cuando están todas las instancias listas, inicia la reproducción
	*
	* Parámetros:
	* 	(event) 	event
	* 	(object) 	instance
	*
	* return (void)
	*/
		PlayerMain.instanceReady = function ( event, instance ) {

			// Variables auxiliares
				var that = this;


			// Le digo que cuando se ejecute el evento 'finish-player-animation' se llame a la función nextInstance
				$(instance).on('instance-ended', function(){
					that.nextInstance();
				});

			// Agrego la instancia a la lista
				that.addInstance(instance);


			// Seteo las variables auxiliares
				var instanceList 		= that.getInstanceList(),
					tempInstanceList 	= that.getInstanceTempList();

			// Si la cantidad de instancias temporales listas es igual a la cantidad de instancias temporales
				if( instanceList.length == tempInstanceList.length )
				{
					// Nulleo las variables de instancias temporales
						that.instances.temp = null;

					// Inicio la pantalla
						that.start();
				}

		};








	/**
	* Función: 		nextInstance
	* Descripción: 	Obtiene la siguiente instancia y la carga
	*
	* return (void)
	*/
		PlayerMain.nextInstance = function () {

			// Variables auxiliares
				var nextInstance 			= 0,
					currentInstanceIndex 	= this.getCurrentInstanceIndex(),
					instanceListLength 		= this.getInstanceList().length;

			// Obtengo el ID de la instancia actual
				if( currentInstanceIndex < (instanceListLength - 1)) {
					nextInstance = currentInstanceIndex + 1;
				}

			// Cargo la instancia
				this.loadInstance( nextInstance );

		}

	/**
	* Función: 		goToInstance
	* Descripción: 	Recibe el id de la instancia por párametro y la carga 
	*
	* return (void)
	*/
		PlayerMain.goToInstance = function ( instance_id = null ) {

			// Chequeo que el ID sea un número
				if( isInteger(instance_id) )
				{
					// Variables auxiliares
						var instanceList 	= this.getInstanceList(),
							nextInstance 	= -1;

					// Por cada instancia temporal
						for(var index in instanceList)
						{
							// Si el nombre enviado por parametro es igual al ID de la instancia
								if( instance_id == instanceList[index].getId() )
								{
									// Agarro el index del objeto
										nextInstance = parseInt(index);
										break;

								}
						}

					// Si existe la instancia 
						if( nextInstance != -1 )
						{
							// Cargo la próxima instancia
								this.loadInstance( nextInstance );
						}
				}
			// O sino
				else {
					console.error('El ID debe ser un número');
				}

		}

	/**
	* Función: 		loadInstance
	* Descripción: 	Carga la instancia enviada por parámetro
	*
	* return (void)
	*/
		PlayerMain.loadInstance = function ( id = null ) {

			// Variables auxiliares
				var that 			= this,
					currentInstance = this.getCurrentInstance();

			// _Si el ID es un número
				if( isInteger(id) )
				{
					// Variables auxiliares
						var transitionTimer 	= this.getTransitionTimer(),
							transitionInterval 	= this.getTransitionInterval(),
							instanceErrorList 	= this.getInstanceErrorList(),
							instanceList 		= this.getInstanceList();

					// Instancia anterior

						// Primero freno el timer actual para que no se pisen entre los mismos
							if( transitionTimer ) {
								clearTimeout(transitionTimer);
							}

						// Freno la instancia anterior
							if( currentInstance ) {
								currentInstance.stop();
							}


					// Instancia actual

						// Obtengo la nueva instancia
							currentInstance = this.setCurrentInstance(id);

						// Si la instancia NO tiene error
							if( !currentInstance.hasError() )
							{
								// Seteo un timeout de espera entre instancias
									transitionTimer = setTimeout(function(){

										// Chequeo si la instancia tiene footer y touch overlay
											that.setupFooter();
											that.setupTimer();
											that.setupTouchOverlay();

										// Inicio la instancia
											currentInstance.begin();

									}, transitionInterval * 1000);
							}
						// O sino
							else
							{
								// Si la cantidad de instancias que tienen error, es igual a la cantidad total de instancias
									if( instanceErrorList.length == instanceList.length ) {
										this.showOffline();
									}
								// Sino muestro la próxima instancia
									else {
										this.nextInstance();
									}
							}
				}
				else {
					console.error('El ID debe ser un número');
				}

		}








	/**
	* Función: 		addInstanceError
	* Descripción: 	Agrega el ID de la instancia a la lista de instancias con errores
	*
	* return (void)
	*/
		PlayerMain.addInstanceError = function ( instance_id = null ) {

			if( isInteger(instance_id) )
			{
				// Variables auxiliares
					var instanceErrorList = this.getInstanceErrorList();

				// Si el array ya tiene alguna instancia
					if( instanceErrorList.length > 0)
					{
						// Y NO está en la lista, lo agrego
							if( !inArray(instanceErrorList, instance_id) ) {
								instanceErrorList.push( instance_id );
							}
					}
				// Si no tiene ninguna instancia, lo agrego
					else {
						instanceErrorList.push( instance_id );
					}
			}

		}

	/**
	* Función: 		removeInstanceError
	* Descripción: 	Remueve el ID de la instancia de la lista de instancias con errores
	*
	* return (void)
	*/
		PlayerMain.removeInstanceError = function ( instance_id = null ) {

			if( isInteger(instance_id) )
			{
				// Variables auxiliares
					var instanceErrorList = this.getInstanceErrorList();
				
				// Si el array ya tiene alguna instancia
					if( instanceErrorList.length > 0 )
					{
						// Y SI está en la lista, lo remuevo
							if( inArray(instanceErrorList, instance_id) ) {
								instanceErrorList.splice( instanceErrorList.indexOf(instance_id), 1 );
							}
					}

			}

		}








	/**
	* Función: 		showOffline
	* Descripción: 	Muestra la pantalla offline e inicializa el interval para chequear cada cierto tiempo si debe o no seguir offline
	*
	* return (void)
	*/
		PlayerMain.showOffline = function () {

			// Variables auxiliares
				var that 			= this,
					offline 		= this.getOffline(),
					offlineTimer 	= this.getOfflineTimer(),
					offlineInterval = this.getOfflineInterval();

			// Si NO está visible
				if( !offline.is(':visible') )
				{
					// Lo muestro
						offline.fadeIn(1000);

					// Chequeo cada cierto tiempo si hay algún modulo funcional
						offlineTimer = setInterval(function() {
							that.checkOffline();
						}, offlineInterval * 1000);
				}

		};

	/**
	* Función: 		hideOffline
	* Descripción: 	Oculta la pantalla offline
	*
	* return (void)
	*/
		PlayerMain.hideOffline = function () {

			// Variables auxiliares
				var offline = this.getOffline();

			// Si está visible, la oculto
				if( offline.is(':visible') ) {
					offline.fadeOut(1000);
				}

		};

	/**
	* Función: 		checkOffline
	* Descripción: 	Chequea si alguna instancia dejó de tener error
	*
	* return (void)
	*/
		PlayerMain.checkOffline = function () {

			// Variables auxiliares
				var	instanceList = this.getInstanceList(),
					offlineTimer = this.getOfflineTimer();

			// Por cada instancia
				for(var index in instanceList)
				{
					// Si hay al menos 1 módulo que no tiene error
						if( !instanceList[index].hasError() )
						{
							// Freno el intervalo
								clearInterval( offlineTimer );

							// Oculto la pantalla offline
								this.hideOffline();

							// Y voy al siguiente módulo disponible
								this.goToInstance( instanceList[index].getId() );

							// Salgo del foreach
								break;

						}
				}

		};








	/**
	* Función: 		setupTimer
	* Descripción: 	Chequea si se muestra o no el timer en la instancia actual
	*
	* return (void)
	*/
		PlayerMain.setupTimer = function () {

			// Variables auxiliares
				var currentInstance = this.getCurrentInstance();

			// Si la instancia TIENE timer
				if( currentInstance.hasTimer() ) {
					this.showTimer();
				}
				else {
					this.hideTimer();
				}

		};

	/**
	* Función: 		showTimer
	* Descripción: 	Muestra el timer
	*
	* return (void)
	*/
		PlayerMain.showTimer = function () {

			// Variables auxiliares
				var timer = this.getTimer();

			// Si NO está visible, lo muestro
				if( !timer.is(':visible') ){	
					timer.show();
				}

		};

	/**
	* Función: 		hideTimer
	* Descripción: 	Oculta el timer
	*
	* return (void)
	*/
		PlayerMain.hideTimer = function () {

			// Variables auxiliares
				var timer = this.getTimer();

			// Si está visible, lo oculto
				if( timer.is(':visible') ) {
					timer.hide();
				}

		};








	/**
	* Función: 		setupFooter
	* Descripción: 	Chequea si se muestra o no el footer en la instancia actual
	*
	* return (void)
	*/
		PlayerMain.setupFooter = function () {

			// Variables auxiliares
				var currentInstance = this.getCurrentInstance();

			// Si la instancia TIENE footer
				if( currentInstance.hasFooter() ) {
					this.showFooter();
				}
				else {
					this.hideFooter();
				}

		};

	/**
	* Función: 		showFooter
	* Descripción: 	Muestra el footer
	*
	* return (void)
	*/
		PlayerMain.showFooter = function () {

			// Variables auxiliares
				var footer = this.getFooter();

			// Si NO está visible, lo muestro
				if( !footer.is(':visible') ) {	
					footer.slideDown();
				}
		};

	/**
	* Función: 		hideFooter
	* Descripción: 	Oculta el footer
	*
	* return (void)
	*/
		PlayerMain.hideFooter = function () {

			// Variables auxiliares
				var footer = this.getFooter();

			// Si está visible, lo oculto
				if( footer.is(':visible') ) {	
					footer.slideUp();
				}

		};








	/**
	* Función: 		setupTouchOverlay
	* Descripción: 	Chequea si se muestra o no el touch overlay en la instancia actual
	*
	* return (void)
	*/
		PlayerMain.setupTouchOverlay = function () {

			// Variables auxiliares
				var currentInstance = this.getCurrentInstance();

			// Si la instancia TIENE contenido touch
				if( currentInstance.hasTouchContent() ) {
					this.hideTouchOverlay();
				}
				else {
					this.showTouchOverlay();
				}

		};

	/**
	* Función: 		showTouchOverlay
	* Descripción: 	Muestra el touch overlay
	*
	* return (void)
	*/
		PlayerMain.showTouchOverlay = function () {

			// Variables auxiliares
				var touchOverlay = this.getTouchOverlay();

			// Si NO está visible, lo muestro
				if( !touchOverlay.is(':visible') ) {	
					touchOverlay.show();
				}
		};

	/**
	* Función: 		hideTouchOverlay
	* Descripción: 	Oculta el touch overlay
	*
	* return (void)
	*/
		PlayerMain.hideTouchOverlay = function () {

			// Variables auxiliares
				var touchOverlay = this.getTouchOverlay();

			// Si está visible, lo oculto
				if( touchOverlay.is(':visible') ) {	
					touchOverlay.hide();
				}

		};








	/**
	* Función: 		showPreloader
	* Descripción: 	Muestra el preloader
	*
	* return (void)
	*/
		PlayerMain.showPreloader = function () {

			// Variables auxiliares
				var preloader = this.getPreloader();

			// Si NO está visible, lo muestro
				if( !preloader.is(':visible') ) {
					preloader.fadeIn(1000);
				}

		};

	/**
	* Función: 		hidePreloader
	* Descripción: 	Oculta el preloader
	*
	* return (void)
	*/
		PlayerMain.hidePreloader = function () {

			// Variables auxiliares
				var preloader = this.getPreloader();

			// Si está visible, lo oculto
				if( preloader.is(':visible') ) {
					preloader.fadeOut(1000);
				}

		};








	/**
	* Función: 		setHandlebarsHelpers
	* Descripción: 	Setea los helpers para el Handlebars
	*
	* return (void)
	*/
		PlayerMain.setHandlebarsHelpers = function () {

			// Variables auxiliares
				var that = this;

			// Helper para setear el item activo
				Handlebars.registerHelper('active', function( index = -1 ) {
					return ((index == 0) ? 'active' : '');
				});

			// Helper para obtener un string sin espacios de más
				Handlebars.registerHelper('trimString', function( str = '' ) {
				    return new Handlebars.SafeString( str.replace(/(?:\r\n|\r|\n)/g, '') );
				});

			// Helper para setear el protocolo automaticamente sin HTTP o HTTPS hardcodeado
				Handlebars.registerHelper('set_url_protocol', function( str = '' ) {
					return new Handlebars.SafeString( str.replace(/.*?:\/\//g, '//') );
				});

			// Helper para obtener la fecha en string
				Handlebars.registerHelper('get_date_string', function( dt ) {

					var date 	= that.getDate(dt),
						dateStr = date.name + ' ' + date.number + ' de ' + date.month + ' de ' + date.year;

					return new Handlebars.SafeString( dateStr );
				});

			// Helper para obtener la hora en string
				Handlebars.registerHelper('get_time_string', function( dt ) {

					var date 	= that.getDate(dt),
						hourStr = date.hours + ':' + date.minutes;

					return new Handlebars.SafeString( hourStr );
				});

		};

	/**
	* Función: 		setDOMElements
	* Descripción: 	Setea los DOM Elements de la pantalla
	*
	* return (void)
	*/
		PlayerMain.setDOMElements = function () {

			this.DOM.preloader 		= $(window.document.getElementById('preloader'));
			this.DOM.footer 		= $(window.document.getElementById('footer'));
			this.DOM.timer 			= $(window.document.getElementById('timer'));
			this.DOM.offline 		= $(window.document.getElementById('offline'));
			this.DOM.touchOverlay 	= $(window.document.getElementById('touch-overlay'));

		};

	/**
	* Función: 		setRefresh
	* Descripción: 	Setea el tiempo de refresco de la pantalla
	*
	* return (void)
	*/
		PlayerMain.setRefresh = function () {

			// Variables auxiliares
				var that = this;

			// Inicio el intervalo
				setInterval(function() {

					// Si el navegador está online
						if(navigator.onLine)
						{
							$.getJSON( that.getRefreshAjax() )
							.success(function(data) {
								
								if( data.requireRefresh ) {
									window.location.reload();
								}

							})
							.error(function() {
								// Error en el servidor
							});
						}

				}, this.getRefreshInterval() * 1000);

		};

	/**
	* Función: 		setForceRefreshDetection
	* Descripción: 	Chequea cada tanto si hay que refrescar la pantalla debido a modificaciones en la misma
	*
	* return (void)
	*/
		PlayerMain.setForceRefreshDetection = function () {

			// Variables auxiliares
				var that 		= this,
					parameters 	= {};

			// Primero necesito saber si voy a refreshear una pantalla o un módulo
				if( that.getDisplay() != null )
				{
					parameters['id'] 	= that.getDisplay().pantalla_id;
					parameters['type'] 	= 'display';
				}
				else
				{
					parameters['id'] 	= that.getModulesList()[0].contenido_id;
					parameters['type'] 	= 'content';
				}

			// Inicio el intervalo
				setInterval(function() {

					// Si el navegador está online
						if(navigator.onLine)
						{
							$.getJSON( that.getForceRefreshAjax(), parameters )
							.success(function(data) {

								if( data.requireRefresh ) {
									window.location.reload();
								}

							}).error(function(){
								// Error en el servidor
							});
						}

				}, this.getForceRefreshInterval() * 1000);

		};

	/**
	* Función: 		setConnectionEvents
	* Descripción: 	Setea los eventos cuando se desconecta/ conecta el internet
	*
	* return (void)
	*/
		PlayerMain.setConnectionEvents = function () {

			// Variables auxiliares
				var that = this;


			/**
			* Función: 		isOnline
			* Descripción: 	Ejecuta una acción si se conecta a internet
			*
			* return (void)
			*/
				function isOnline() {

					// Variables auxiliares
						var currentInstance = that.getCurrentInstance();

					// Si la instancia actual requiere estar online
						if( currentInstance.requireOnline() )
						{
							// Llama a la función '_goOnline' de la instancia actual
								currentInstance._goOnline();

							// Le remuevo a la instancia el error
								currentInstance.setError( false );
						}

				};


			/**
			* Función: 		isOffline
			* Descripción: 	Ejecuta una acción si se cae el internet
			*
			* return (void)
			*/
				function isOffline() {

					// Variables auxiliares
						var currentInstance = that.getCurrentInstance();

					// Si la instancia actual requiere estar online
						if( currentInstance.requireOnline() )
						{
							// Llama a la función '_goOffline' de la instancia actual
								currentInstance._goOffline();

							// Le seteo a la instancia un error
								currentInstance.setError( true );

							// Pasa a la siguiente instancia
								that.nextInstance();
						}

				};


			// Agrego los event listeners al online y offline del navegador
				window.addEventListener('online',  isOnline,  false);
				window.addEventListener('offline', isOffline, false);
		};
	
	/**
	* Función: 		setClock
	* Descripción: 	Inicia el reloj
	*
	* return (void)
	*/
		PlayerMain.setClock = function () {

			// Variables auxiliares
				var that = this;

			// Llama a la función para actualizar el reloj
				this.updateClock();

			// Y lo actualizo cada cierto tiempo
			 	setInterval(function() {
			 		that.updateClock();
			 	}, this.getClockInterval() * 1000);

		};

	/**
	* Función: 		updateClock
	* Descripción: 	Actualiza el reloj
	*
	* return (void)
	*/
		PlayerMain.updateClock = function () {

			// Obtengo la fecha y hora actual
			 	var date = this.getDate();

			// Obtengo los contenedores necesarios
				var _date_name 		= $('.date-time .date-name'),
					_date_number 	= $('.date-time .date-number'),
					_date_month 	= $('.date-time .date-month'),
					_date_year 		= $('.date-time .date-year'),
					_date_hours 	= $('.date-time .date-hours'),
					_date_minutes 	= $('.date-time .date-minutes');

			// Los muestro en la vista
				_date_name.html( date.name );
				_date_number.html( date.number );
				_date_month.html( date.month );
				_date_year.html( date.year );
				_date_hours.html( date.hours );
				_date_minutes.html( date.minutes );
				
		};








	/**
	* Función: 		onYouTubeIframeAPIReady
	* Descripción: 	Se llama cuando termina de cargar la API de youtube
	*
	* return (void)
	*/
		window.onYouTubeIframeAPIReady = function() {
			PlayerMain.setYoutubeAPIReady( true );
		};








	/**
	*
	* GETTERS
	*
	*/

		// Display
			PlayerMain.getDisplay = function() {
				return this.display;
			};

		// Módulos
			PlayerMain.getAvailableModulesList = function() {
				return this.modules.availables;
			};

			PlayerMain.getModulesList = function() {
				return this.modules.list;
			};

		// Instancias
			PlayerMain.getInstanceList = function() {
				return this.instances.list;
			};

			PlayerMain.getInstanceTempList = function() {
				return this.instances.temp;
			};

			PlayerMain.getInstanceErrorList = function() {
				return this.instances.error;
			};

			PlayerMain.getCurrentInstance = function() {

				var currentInstanceIndex = this.getCurrentInstanceIndex();

				// Si la instancia actual no es -1, devuelvo la instancia actual
					if( currentInstanceIndex != -1 ) {
						return this.getInstanceList()[ currentInstanceIndex ];
					}
				
				return null;
			};

			PlayerMain.getCurrentInstanceIndex = function() {
				return this.instances.current;
			};

		// Styles & scripts
			PlayerMain.getStyles = function() {
				return this.instances.styles;
			};

			PlayerMain.getScripts = function() {
				return this.instances.scripts;
			};

		// Timer
			PlayerMain.getTransitionTimer = function() {
				return this.timer.transition;
			};

			PlayerMain.getOfflineTimer = function() {
				return this.timer.offline;
			};
			
		// Interval
			PlayerMain.getTransitionInterval = function() {
				return this.interval.transition;
			};

			PlayerMain.getOfflineInterval = function() {
				return this.interval.offline;
			};

			PlayerMain.getClockInterval = function() {
				return this.interval.clock;
			};

			PlayerMain.getRefreshInterval = function() {
				return this.interval.refresh;
			};

			PlayerMain.getForceRefreshInterval = function() {
				return this.interval.forceRefresh;
			};

		// Generales
			PlayerMain.isYoutubeAPIReady = function() {
				return this.vars.youtubeAPIReady;
			};

			PlayerMain.getDate = function( dt = new Date() ) {

				// Obtengo la fecha y hora actual
					var now = new Date(dt);

				// Seteo el objeto con la fecha y hora parseados
					var date = {
						name: 		this.getDays()[ now.getDay() ],
						number: 	now.getDate(),
						month: 		this.getMonths()[ now.getMonth() ],
						year: 		now.getFullYear(),
						hours: 		(now.getHours() < 10) ? '0' + now.getHours() : now.getHours(),
						minutes: 	(now.getMinutes() < 10) ? '0' + now.getMinutes() : now.getMinutes(),
						seconds: 	(now.getSeconds() < 10) ? '0' + now.getSeconds() : now.getSeconds(),
				 	};

				return date;
			};

		// AJAX
			PlayerMain.getAjax = function( name = '' ) {

				if( name.trim() != '' )
				{
					return '/ajax/' + this.ajax[name];
				}

				return '';

			};

			PlayerMain.getRefreshAjax = function() {
				return this.getAjax('refresh');
			};

			PlayerMain.getForceRefreshAjax = function() {
				return this.getAjax('forceRefresh');
			};

		// DOM
			PlayerMain.getPreloader = function() {
				return this.DOM.preloader;
			};

			PlayerMain.getFooter = function() {
				return this.DOM.footer;
			};

			PlayerMain.getTimer = function() {
				return this.DOM.timer;
			};

			PlayerMain.getOffline = function() {
				return this.DOM.offline;
			};

			PlayerMain.getTouchOverlay = function() {
				return this.DOM.touchOverlay;
			};

		// Constantes
			PlayerMain.getDays = function() {
				return this.constants.days;
			};

			PlayerMain.getMonths = function() {
				return this.constants.months;
			};








	/**
	*
	* SETTERS
	*
	*/

		// Display
			PlayerMain.setDisplay = function( display = {} ) {
				if( isObject(display) ) {
					this.display = display;
				}

			};

		// Módulos
			PlayerMain.addAvailableModule = function( name = '', content = {} ) {

				if( name != '' && isFunction(content) ) {
					this.modules.availables[name] = content;
				}

			};

			PlayerMain.setAvailableModulesList = function( modules = [] ) {

				if( isArray(modules) ) {
					this.modules.availables = modules;
				}

			};

			PlayerMain.setModulesList = function( modules = {} ) {

				if( isObject(modules) ) {
					this.modules.list = modules;
				}

			};

		// Instancias
			PlayerMain.addInstance = function( instance = {} ) {

				if( isObject(instance) ) {
					this.getInstanceList().push(instance);
				}

			};

			PlayerMain.setInstanceList = function( instances = [] ) {

				if( isArray(instances) ) {
					this.instances.list = instances;
				}

			};

			PlayerMain.addInstanceTemp = function( instance = {} ) {

				if( isObject(instance) ) {
					this.getInstanceTempList().push(instance);
				}

			};

			PlayerMain.setInstanceTempList = function( instances = [] ) {

				if( isArray(instances) ) {
					this.instances.temp = instances;
				}

				
			};

			PlayerMain.setInstanceErrorList = function( instances = [] ) {

				if( isArray(instances) ) {
					this.instances.error = instances;
				}

			};

			PlayerMain.setCurrentInstance = function( id = null ) {

				if( isInteger(id) ) {
					this.instances.current = id;
				}
				
				return this.getCurrentInstance(id);
			};

		// Styles & scripts
			PlayerMain.setStyles = function( styles = [] ) {
				this.instances.styles = isArray(styles) ? styles : null;
			};

			PlayerMain.setScripts = function( scripts = [] ) {
				this.instances.scripts = isArray(scripts) ? scripts : null;
			};
			
		// Interval
			PlayerMain.setTransitionInterval = function( interval = null ) {

				if( isInteger(interval) ) {
					this.interval.transition = interval;
				}

			};

			PlayerMain.setOfflineInterval = function( interval = null ) {

				if( isInteger(interval) ) {
					this.interval.offline = interval;
				}

			};

			PlayerMain.setClockInterval = function( interval = null ) {

				if( isInteger(interval) ) {
					this.interval.clock = interval;
				}

			};

			PlayerMain.setRefreshInterval = function( interval = null ) {

				if( isInteger(interval) ) {
					this.interval.refresh = interval;
				}

			};

			PlayerMain.setForceRefreshInterval = function( interval = null ) {

				if( isInteger(interval) ) {
					this.interval.forceRefresh = interval;
				}

			};

		// Generales
			PlayerMain.setYoutubeAPIReady = function( value = false ) {

				if( isBoolean(value) ) {
					this.vars.youtubeAPIReady = value;
				}

			};

			// PlayerMain.setDate = function( date = {} ) {
				
			// 	if( isObject(date) ) {
			// 		this.vars.date = date;
			// 	}

			// };

		// DOM
			PlayerMain.setPreloader = function( element ) {
				
				if( element ) {
					this.DOM.preloader = element;
				}

			};

			PlayerMain.setFooter = function( element ) {
				
				if( element ) {
					this.DOM.footer = element;
				}

			};

			PlayerMain.setTimer = function( element ) {
				
				if( element ) {
					this.DOM.timer = element;
				}

			};

			PlayerMain.setOffline = function( element ) {
				
				if( element ) {
					this.DOM.offline = element;
				}

			};

			PlayerMain.setTouchOverlay = function( element ) {
				
				if( element ) {
					this.DOM.touchOverlay = element;
				}

			};








})(window, document, jQuery);