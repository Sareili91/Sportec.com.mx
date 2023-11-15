/*
Archivo:  ctrlBuscaEmpleados.js
Objetivo: código de jQuery para realizar llamada parcial a PHP para consultar 
		  empleados (admon, cajero y almacenista)
Autor:    KIMO
*/
$().ready(()=>{
	//Aspecto gráfico
	$('#btnBuscar').button();
	$("#cmbTipo").selectmenu();
	//Reacción al click
	$('#btnBuscar').click(function(event){
	let sErr="";
		event.preventDefault();
		if ($("#cmbTipo")===null ||$("#cmbTipo").val()==="")
			sErr = "Faltan datos para buscar";
		else{
			$.getJSON({ 
				url: "control/ctrlBuscaEmpleados.php",
				data: { 
					cmbTipo: $("#cmbTipo").val()
				}
			})
			.done( (oDatos) => {
				procesaEmpleadosEncontrados(oDatos);
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
});

//Procesa la respuesta parcial del servidor y llena la tabla de productos
function procesaEmpleadosEncontrados(oDatos){
let oNodoFrm = $("#frmBuscarEmpl");
let oNodoDiv = $("#resBuscarEmpl");
let oTblBody = $("#tblBodyEmpls");
let oCeldaCorreo, oCeldaNombre, oCeldaTipo, oCeldaTurno;
let sError = "";
	
	try{
		if (oNodoFrm === null || oNodoDiv === null || oTblBody === null)
			sError = "Error de referencias";
		else{
			if (oDatos.success){//todo ok				
				//Limpiar contenido de cuerpo de la tabla
				oTblBody.empty();
				
				//Llena líneas
				oDatos.data.arrEmpl.forEach(function(elem){
					oLinea = $("<tr>");
					oCeldaCorreo = $("<td>");
					oCeldaNombre = $("<td>");
					oCeldaTipo = $("<td>");
					oCeldaTurno = $("<td>");

					oCeldaCorreo.text(elem.correo);
					oCeldaNombre.text(elem.nombre);
					oCeldaTipo.text((elem.tipo === "g" ?"Administrador":elem.tipo === "a"?'Almacenista': elem.tipo === "c"?'Cajero':"Usuario"));
					oCeldaTurno.text(elem.turno);

					oLinea.append(oCeldaCorreo, oCeldaNombre, oCeldaTipo, oCeldaTurno);

					oTblBody.append(oLinea);
				});
				
				//Ocultar formularios y mostrar tabla*/
				oNodoFrm.css("display","none");
				oNodoDiv.css("display","block");
				
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
