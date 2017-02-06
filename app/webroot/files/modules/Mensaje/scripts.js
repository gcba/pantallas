PlayerMensaje.prototype = new PlayerBase();


	/*
	 * __construct
	 */
		function PlayerMensaje() {

			// Le mando los argumentos al PlayerBase
				PlayerBase.apply(this, arguments);

		}


PlayerMain.addAvailableModule(PlayerMensaje.name, PlayerMensaje);