/*
Archivo:  ctrlLogin.js
Objetivo: código de jQuery para realizar login mediante llamada parcial a PHP
Autor:    BAOZ
*/

//Si pasa por aquí es que se encuentra en index.php y no hay sesión todavía
sessionStorage.clear();

//Configurar botón
$().ready(()=>{
	//Aspecto gráfico
	$('#btnEnviar').button();
	//Reacción al click
	$('#btnEnviar').click(function(event){
		event.preventDefault();
		if ($("#txtCuentaUsu")===null || $("#txtPwd")===null ||
			$("#txtCuentaUsu").val().trim()==="" || $("#txtPwd").val().trim()==="")
			{
			alert("Faltan datos para el ingreso");
		}else{
			$.post({ 
				url: "control/ctrlLogin.php",
				data: { //Al ser post, se genera el equivalente a formulario
					txtCuentaUsu: $("#txtCuentaUsu").val(),
					txtPwd: $("#txtPwd").val()
				}
			})
			.done( (oDatos) => {
				procesa(oDatos);
			})
			.fail(function(objResp, status, sError){
				alert('El servidor indica error '+status);
				console.log(sError);
			})
			.always(function(objResp, status){
				console.log("Llamada externa completada con situación = "+status);
			});
		}
	});
});

function procesa(oDatos){
let sError = "";
	try{
		if ($("#frmLogin") === null || $("#divBienvenido") === null ||
			$("#paraNombre") === null || $("#paraTipo") === null){
			sError = "Error en HTML";	
		}else{
			if (oDatos.success){
				//Colocar nombre y tipo
				$("#paraNombre").text(oDatos.data.sNombreCompleto);
				$("#paraTipo").text(oDatos.data.sDescTipo);
				
				//Modificar menús
				$("#mnuInicio").attr("href", "inicio.php");
				$("#mnuSalir").attr("class","menu");
				
				if (oDatos.data.sDescTipo === "Cajero"){
					$("#mnuCltes").attr("class","menu");
				}else if (oDatos.data.sDescTipo === "Almacenista"){
					$("#mnuEnvios").attr("class","menu");
				}else if (oDatos.data.sDescTipo === "Administrador"){
					$("#menuEmp").attr("class","menu");
					$("#mnuPlan").attr("class","menu");
					$("#mnuReg").attr("class","menu");
					$("#mnuUsos").attr("class","menu");
				}
				
				//Ocultar formulario y mostrar bienvenida*/
				$("#frmLogin").css("display","none");
				$("#divBienvenido").css("display","block");
				
				//Iniciar sesión
				sessionStorage.setItem("sDescTipo", oDatos.data.sDescTipo);
			}else{
				sError = oDatos.status;
			}
		}
	}catch(error){
		console.log(error.message);
		sError = "Error al procesar respuesta del servidor";
	}
	if (sError != "")
		alert(sError);
}