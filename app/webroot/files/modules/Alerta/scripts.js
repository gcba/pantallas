PlayerAlerta.prototype = new PlayerBase();


	/*
	 * __construct
	 */
		function PlayerAlerta() {

			// Le mando los argumentos al PlayerBase
				PlayerBase.apply(this, arguments);

		}


PlayerMain.addAvailableModule(PlayerAlerta.name, PlayerAlerta);