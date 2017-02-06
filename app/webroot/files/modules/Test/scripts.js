PlayerTest.prototype = new PlayerBase();


	/**
	* Función: 		PlayerTest
	* Descripción: 	Constructor del módulo
	*
	* return (void)
	*/
		function PlayerTest() {

			// Le mando los argumentos al PlayerBase
				PlayerBase.apply(this, arguments);


			// Variable del módulo
			// Lo ideal es trabajar todas las variables del módulo acá adentro 
			// para evitar sobre escribir variables de otros módulos
				this.Test = {
					
				};

		}


PlayerMain.addAvailableModule(PlayerTest.name, PlayerTest);