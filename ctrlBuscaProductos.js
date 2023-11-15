/*
Archivo:  ctrlBuscaProductos.js
Objetivo: código de jQuery para realizar llamada parcial a PHP para consultar 
		  productos (plantas de ornato), además soporta gestión de productos
Autor:    BAOZ
*/
$().ready(()=>{
	//Aspecto gráfico (incluso elementos dentro del diálogo)
	$('#btnBuscar').button();
	$("#cmbFiltro").selectmenu();
	$("#btnCrearProducto").button();
	$("input[type='checkbox']" ).checkboxradio();
	//No se incluye el caso del select del diálogo por un bug de jQuery
	$("#btnGestionar").button();
	$("#dlgEdProducto").dialog({
		autoOpen: false,
		show: {
			effect: "fold", 
			duration: 650
		},
		hide: {
			effect: "scale", 
			duration: 650
		},
		width:"60%",
		modal: true
	});
	//Reacción al cambio de tipo (y aspecto gráfico)
	$("#cmbTipo").selectmenu({
		change:function(event, ui){
			switch ($(this).val()){
				case "1":
						$("#cmbFiltro").html(getDisciplina());
						break;
				case "2":
						$("#cmbFiltro").html(getDisciplina());
						break;
				case "3":
							$("#cmbFiltro").html(getDisciplina());
							break;
				case "4":
						$("#cmbFiltro").html(getDisciplina());
						break;
				case "5":
						$("#cmbFiltro").html(getDisciplina());
							break;
				default: $("#cmbFiltro").html('<option value="">Todos</option>');
			}
			$("#cmbFiltro").selectmenu("refresh");
		}
	});
	//Reacción al click
	$('#btnBuscar').click(function(event){
	let sErr="";
		event.preventDefault();
		if ($("#cmbTipo")===null ||$("#cmbTipo").val()==="" || $("#cmbFiltro")===null)
			sErr = "Faltan datos para buscar";
		else{
			$.getJSON({ 
				url: "control/ctrlBuscaProducto.php",
				data: { 
					cmbTipo: $("#cmbTipo").val(),
					cmbFiltro: $("#cmbFiltro").val()
				}
			})
			.done( (oDatos) => {
				procesaProductosEncontrados(oDatos);
			})
			.fail(function(objResp, status, sError){
				sErr = sError;
				console.log(sError);
			})
			.always(function(objResp, status){
				console.log("Llamada externa completada con situación = "+status);
			});
		}
		if (sErr !== "")
			alert(sErr);
	});
	//Reacción al click del botón crear
	$('#btnCrearProducto').click(function(event){
		muestraDlgEdPlantas("a", -1, $("#cmbTipo").val());
	});
	//Reacción al click del botón gestionar (dentro del diálogo)
	$("#frmEdProducto").submit(function(event){
	let sErr="";
	let oFrmDatos = new FormData();
		event.preventDefault();
		if ($("#txtOpe").val() === "b" ||
			$("#frmEdProducto")[0].checkValidity()){
			//Ya no verifica elementos porque, de no existir, no habría llegado a este punto
			oFrmDatos.append("cmbTipo", $("#txtTipo").val());
			oFrmDatos.append("txtCve", $("#txtCve").val());
			oFrmDatos.append("txtOpe", $("#txtOpe").val());
			oFrmDatos.append("txtNom", $("#txtNom").val());
			oFrmDatos.append("cbSombra", $("#cbFlores").prop("checked"));
			oFrmDatos.append("cbFlores", $("#cbSombra").prop("checked"));
			oFrmDatos.append("txtCuida", $("#txtCuidados").val());
			oFrmDatos.append("txtPrecio", $("#txtPrecio").val());
			oFrmDatos.append("txtImg", $("#txtImg")[0].files[0]);
			oFrmDatos.append("cmbOtros", $("#cmbOtros").val());
			$.ajax({ 
				url: "control/ctrlGestionarPlantaOrnato.php",
				type: "post",
				data: oFrmDatos,
				processData: false,
				contentType: false
			})
			.done( (oDatos) => {
				if (oDatos.success){
					alert("Datos almacenados");
					$("#dlgEdProducto").dialog("close");
					$("#frmBuscarProd").css("display","block");
					$("#resBuscarProd").css("display","none");
				}else{
					alert("Error al almacenar: "+oDatos.status);
				}
			})
			.fail(function(objResp, status, sError){
				alert('El servidor indica error al procesar');
				console.log(sError);
			})
		} //Los errores de validación los indicó HTML5
	});
});

//Procesa la respuesta parcial del servidor y llena la tabla de productos
function procesaProductosEncontrados(oDatos){
let oNodoFrm = $("#frmBuscarProd");
let oNodoDiv = $("#resBuscarProd");
let oTblBody = $("#tblBodyProds"); 
let oCelCabPrecio = $("#tdPrecio");
let oCelCabOpe = $("#tdOpe");
let oCeldaCve, oCeldaNombre, oCeldaDes,oCeldaTalla, oCeldaMater, oCeldaImagen,
	oCeldaPrecio, oImg, oCeldaOpe, oBtnModif, oBtnElim;
let sError = "";
let oFmt = new Intl.NumberFormat('es-MX', {
		style: 'currency',
		currency: 'MXN',
		minimumFractionDigits: 2
	});
	
	try{
		if (oNodoFrm === null || oNodoDiv === null || oTblBody === null)
			sError = "Error de referencias";
		else{
			if (oDatos.success){//todo ok				
				//Limpiar contenido de cuerpo de la tabla
				oTblBody.empty();
				
				//Llena líneas
				oDatos.data.arrProds.forEach(function(elem){
					oLinea = $("<tr>");
					oCeldaCve = $("<td>");
					oCeldaNombre = $("<td>");
					oCeldaDes = $("<td>");
					oCeldaTalla = $("<td>");
					oCeldaMater = $("<td>");
					oCeldaImagen = $("<td>");
					oImg = $("<img>");
					oCeldaCve.text(elem.clave);
					oCeldaNombre.text(elem.nombre) ;
					oCeldaDes.text(elem.descripcion) ;
					oCeldaTalla.text(elem.talla) ;
					oCeldaMater.text(elem.material) ;
					oImg.prop({
						src: "imgs/"+elem.imagen,
						alt: "imagen "+elem.nombre
					});
					oCeldaImagen.append(oImg);
					oLinea.append(oCeldaCve, oCeldaNombre, oCeldaDes, oCeldaTalla, oCeldaMater,oCeldaImagen);
					if (sessionStorage.getItem("sDescTipo")!==null &&
					    sessionStorage.getItem("sDescTipo")!==""){
						oCeldaPrecio = $("<td>");
						oCeldaPrecio.text(oFmt.format(elem.precio));
						oLinea.append(oCeldaPrecio);
						if (sessionStorage.getItem("sDescTipo")==="Administrador"){
							oCeldaOpe = $("<td>");
							if (elem.activo){
								oBtnModif=$("<input>");
								oBtnModif.prop({
									type: "button",
									value: "Modificar",
									id: "Mod"+elem.clave
								});
								oBtnModif.button();
								oBtnModif.click(function(){
									muestraDlgEdPlantas("m", 
										$(this).prop("id").substr(3),
										$("#cmbTipo").val());
								});
								oCeldaOpe.append(oBtnModif);
								oBtnElim=$("<input>");
								oBtnElim.prop({
									type: "button",
									value: "Eliminar",
									id: "Elim"+elem.clave
								});
								oBtnElim.button();
								oBtnElim.click(function(){
									muestraDlgEdPlantas("b", 
									$(this).prop("id").substr(4),
									$("#cmbTipo").val());
								});
								oCeldaOpe.append(oBtnElim);
							}else{
								oCeldaOpe.text(" ");
							}
							oLinea.append(oCeldaOpe);
						}
					}
					oTblBody.append(oLinea);
				});
				
				//Ocultar formularios y mostrar tabla*/
				oNodoFrm.css("display","none");
				oNodoDiv.css("display","block");
				if (sessionStorage.getItem("sDescTipo") === null ||
					sessionStorage.getItem("sDescTipo") === ""){
					oCelCabPrecio.css("display","none");
					oCelCabOpe.css("display","none");
					$('#btnCrearProducto').css("display","none");
				}else{
					oCelCabPrecio.css("display","table-cell");
					if (sessionStorage.getItem("sDescTipo")==="Administrador"){
						oCelCabOpe.css("display","table-cell");
						$('#btnCrearProducto').css("display","block");
					}
					else{
						oCelCabOpe.css("display","none");
						$('#btnCrearProducto').css("display","none");
					}
				}
			}else{
				sError = oDatos.status;
			}
		}
	}catch(error){
		console.log(error.message);
		sError = "Error al procesar respuesta del servidor";
	}
	if (sError !== "")
		alert(sError);
}

/*Función para asignar contenido del diálogo y abrirlo;
	de ser necesario, hace llamada parcial para obtener datos de la planta
*/
function muestraDlgEdPlantas(sOpe, nClave, nTipo){
let sTitulo = "";
let sErr = "";
let bDisabled = false;
	//Decidir título de diálogo y botón
	switch(sOpe){
		case "a": sTitulo="Crear Nueva";
			break;
		case "b": sTitulo="Eliminar";
			break;
		case "m": sTitulo="Modificar";
			break;
		default: sTitulo="Error";
	}
	$("#dlgEdProducto").dialog("option", "title", sTitulo+" planta/semilla");
	$("#btnGestionar").val(sTitulo);
	//Limpiar campos de captura y colocar valores por omisión
	$("#frmEdProducto")[0].reset();
	$("#txtCve").val(nClave);
	$("#txtTipo").val(nTipo);
	$("#txtOpe").val(sOpe);
	if (nTipo==="1"){
		$("#cmbOtros").html(getTamanios());
		$("#lbOtros").html("Tama&ntilde;o");
	}
	else{
		$("#cmbOtros").html(getPresentaciones());
		$("#lbOtros").html("Presentaci&oacute;n");
	}
	if (sOpe==="b"){
		bDisabled = true;
		$("#frmEdPlantas").attr("novalidate","novalidate");
	}else{
		bDisabled = false;
		$("#frmEdPlantas").attr("novalidate","");
	}
	//Cargar datos externos si ya existe la planta
	if (sOpe === "b" || sOpe === "m"){
		$.getJSON({ 
			url: "control/ctrlBuscarUnaPlantaOrnato.php",
			data: { 
				cmbTipo: nTipo,
				txtCve: nClave
			}
		})
		.done( (oDatos) => {
			$("#txtNom").val(oDatos.data.nombre);
			$("#cmbOtros").val(oDatos.data.otros);
			$("#cmbOtros").selectmenu("refresh");
			$("#txtPrecio").val(oDatos.data.precio);
			$("#txtCuidados").val(oDatos.data.cuidadosGenerales);
			$("#cbSombra").prop('checked', oDatos.data.esDeSombra).checkboxradio('refresh');
			$("#cbFlores").prop('checked', oDatos.data.tieneFlores).checkboxradio('refresh');
		})
		.fail(function(objResp, status, sError){
			sErr = sError;
			console.log(sError);
		});
	}
	if (sErr=== ""){
		$("#txtNom").prop({disabled: bDisabled});
		$("#cmbOtros").prop({disabled: bDisabled});
		$("#txtPrecio").prop({disabled: bDisabled});
		$("#txtImg").prop({disabled: bDisabled});
		$("#txtCuidados").prop({disabled: bDisabled});
		$("#cbSombra").prop({disabled: bDisabled});
		$("#cbFlores").prop({disabled: bDisabled});
		$("#dlgEdPlantas").dialog( "open" );  //Debe ir antes del selectmenu por un bug de jQuery
		$("#cmbOtros").selectmenu();
		$("#cmbOtros").selectmenu("refresh");
	}else{
		alert("Error al editar planta");
		$("#dlgEdPlantas").dialog( "close" );
	}
	
}

function getDisciplina(){
	return '<option value="">Todos</option>'+
			'<option value="1">Basquetbol</option>'+
			'<option value="2">Futbol</option>'+
			'<option value="2">Voleibol</option>'
}

