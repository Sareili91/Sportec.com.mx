			<!-- menu.php -->
			<?php
				$sClsMnPacientes="menu_inhab";
				$sClsMnCajero="menu_inhab";
				$sClsMnAlmacenista="menu_inhab";
				$sClsMnAdmor="menu_inhab";
				$sClsMnSalir="menu_inhab";
				$bFirmado = false;
				$oFirmado = null;
				
				$bFirmado = isset($_SESSION["sTipoFirmado"]);
				if ($bFirmado){
					$sClsMnSalir="menu";
					switch ($_SESSION["sTipoFirmado"]){
						case Empleado::CAJERO: $sClsMnCajero="menu";
											   break;
						case Empleado::ALMACENISTA: $sClsMnAlmacenista="menu";
											   break;
						case Empleado::ADMINISTRADOR: $sClsMnAdmor="menu";
											   break;
					}
				}
			?>
			<nav id="main-nav">
				<a href="<?php echo ($bFirmado?"inicio.php":"index.php");?>" class="menu" id="mnuInicio">Inicio</a>			
				<a href="catalogo.php" class="menu" id="mnuCatalogo">Cat&aacute;logo de Productos</a>
				<a href="clientes.php" class="<?php echo $sClsMnCajero;?>" id="mnuCltes">Registrar Cliente</a>
				<a href="envios.php" class="<?php echo $sClsMnAlmacenista;?>" id="mnuEnvios">Enviar Pedido</a>
				<a href="empleados.php" class="<?php echo $sClsMnAdmor;?>" id="menuEmp">Gestionar empleados</a>
				<a href="plantas.php" class="<?php echo $sClsMnAdmor;?>" id="mnuPlan">Gestionar plantas</a>
				<a href="regimenes.php" class="<?php echo $sClsMnAdmor;?>" id="mnuReg">Gestionar reg&iacute;menes</a>
				<a href="usos.php" class="<?php echo $sClsMnAdmor;?>" id="mnuUsos">Gestionar usos</a>
				<a href="control/ctrlLogout.php" class="<?php echo $sClsMnSalir;?>" id="mnuSalir">Salir</a>		
			</nav>	