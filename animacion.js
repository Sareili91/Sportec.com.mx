/*
* Archivo: dialogo.js
* Objetivo: configurar comportamiento de diálogo simple de jQuery
* Autor: BAOZ
*/
	$().ready(()=>{
		//Configurar diálogo
		$( "#dlg" ).dialog({
			autoOpen: false,
			show: {
				effect: "puff", // probar fold, puff, scale, shake, slide
				duration: 650
			},
			hide: {
				effect: "puff", //probar scale, bounce, clip, drop, explode
				duration: 650
			}
			, modal: true
		});
		//Configurar botón para mostrar diálogo
		$( "#jugar" ).click(function() {
			$( "#dlg" ).dialog( "open" );
		});
	});