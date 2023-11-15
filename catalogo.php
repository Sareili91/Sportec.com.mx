<?php
/*
Archivo:  catalogo.php
Objetivo: página para consultar el catálogo (en construcción) 
Autor:    BAOZ
*/
include_once("modelo/Empleado.php");
include_once("modelo/Cliente.php");
session_start();
include_once("cabecera.html");
include_once("menu.php");
?>		
			<main id="main-content">
				<script src="js/ctrlBuscaProductos.js" async="true"></script>
				<section>
					<header>
						<h3>Cat&aacute;logo de Productos</h3>
					</header>
					<form id="frmBuscarProd">
						<label for="cmbTipo">Tipo de Producto</label>
						<select id="cmbTipo" required>
							<option value="">Seleccione</option>
							<option value="1">Playera</option>
							<option value="2">Short</option>
							<option value="3">Bal&oacute;n</option>
							<option value="4">Tenis</option>
							<option value="5">Accesorios</option>
						</select>
						<label for="cmbFiltro">Filtro (Disciplina)</label>
						<select id="cmbFiltro">
							<option value="">Todos</option>
						</select>
						<br/>
						<button type="submit" id="btnBuscar">Buscar</button>
					</form>
					<div id="resBuscarProd" style="display:none">
						<h4>Productos encontrados</h4>
						<table border="1" id="tblProds">
							<thead>
								<tr>
									<th>Clave</th>
									<th>Nombre </th>
									<th>Descripci&oacute;n</th>
									<th>Talla</th>
									<th>Material</th>
									<th>Imagen</th>
									<th id="tdPrecio">Precio</th>
								</tr>
							</thead>
							<tbody id="tblBodyProds">
							</tbody>
						</table>
						<input type="button" value="Crear" id="btnCrearProducto"/>
					</div>
					<div id="dlgEdProducto">
						<form id="frmEdProducto" method="post" action="" enctype="multipart/form-data">
							<input type="hidden" id="txtCve"/>
							<input type="hidden" id="txtTipo"/>
							<input type="hidden" id="txtOpe"/>
							<label for="txtNom">Nombre</label>
							<input type="text" id="txtNom" required/>
							<br>
							<label for="txtDes">Descripci&oacute;n</label>
							<input type="text" id="txtDes" required/>
							<br>
							<label for="txtTalla">Talla</label>
							<input type="text" id="txtTalla" required/>
							<br>
							<label for="txtMater">Material</label>
							<input type="text" id="txtMater" required/>
							<br>
							<label for="txtImg">Imagen</label>
							<input type="file" id="txtImg" required accept="image/jpg, image/png, image/jpeg"/>
							<br>
							<label for="cmbOtros" id="lbOtros"></label>
							<select id="cmbOtros" required>
								<option value="">Todos</option>
							</select>
							&nbsp;&nbsp;
							<label for="txtPrecio">Precio</label>
							<input type="number" id="txtPrecio" required/>
							<br>
							<input type="submit" id="btnGestionar"/>
						</form>
					</div>
				</section>
			</main>
<?php
include_once("lateral1.html");
include_once("lateral2.html");
include_once("pie.html");
?>		