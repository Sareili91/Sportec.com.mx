<?php
/*
Archivo:  index.php
Objetivo: ejemplo llamadas parciales externas con JS 
Autor:    BAOZ
*/
include_once("modelo/Empleado.php");
include_once("modelo/Cliente.php");
session_start();
include_once("cabecera.html");
include_once("menu.php");
?>		
			<main id="main-content">
				<script src="js/ctrlLogin.js" async="true"></script>
				<section>
					<header>
						<h3>Ingresar al Sistema</h3>
					</header>
					<form id="frmLogin">
						<label for="txtCuentaUsu">Cuenta</label> 
						<input type="text" id="txtCuentaUsu" required/>
						<br/>
						<label for="txtPwd">Contrase&ntilde;a</label> 
						<input type="password" id="txtPwd" required/>
						<input type="submit" value="Entrar" id="btnEnviar"/>
					</form>
					<div id="divBienvenido" style="display:none">
						<h4>Hola <span id="paraNombre"></span></h4>
						<h5>Est&aacute;s firmado como <span id="paraTipo"></span></h5>
					</div>
				</section>
				<script src="js/animacion.js"></script>
				<h3 align = "center">Detén al jugador</h3>
                <br>
                <marquee id="movi" direction="left" scrollamount="50">
                <img src="imgs/jugador.gif" id="jugar" value="Mostrar" class="ui-button ui-corner-all" onclick="movi.stop()">
                <div id="dlg">
                    <h1 align="center"> GANASTE</h1>
                </div>
            </marquee>
			<h6 align="center">presione F5 para volver a jugar</h6>
</main>
<?php
include_once("lateral1.html");
include_once("lateral2.html");
include_once("pie.html");
?>		