<?php include_once "VistaAdmin/main.php";
	  
?>

		
 <?php for($i=0 ; $i<10 ; $i++){ ?>
	<div class="accordion-main">

        <div class="list-accordion">
    
            <div class="item">
    
                <p class = "btn-item" onl>Detalle 1#</p>
                <div class="accordion-content">
    
                    <div class="container">
                        <br>
                        <h4>Detalle Pedido></h4>
                        <br>
                    </div>
    
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <h5>Informacion del Cliente</h5>
                                </div>
                                <div class="col">
                                    <h5>Datos del Pedido</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group col">
                                        <label for="Nombre">Nombre y Apellido</label>
                                        <input type="text" id="Nombre" name="Nombre" readonly class="form-control">
                                        <label for="codCliente">Cod-Cliente</label>
                                        <input type="text" id="codCliente" name="codCliente" readonly class="form-control">
                                        <label for="telefono">Teléfono</label>
                                        <input type="text" id="telefono" name="telefono" readonly class="form-control">
                                        <label for="direccion">Dirección</label>
                                        <input type="text" id="direccion" name="direccion" readonly class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group col">
                                        <label for="Nombre">Fecha</label>
                                        <input type="text" id="Nombre" name="Nombre" readonly class="form-control">
                                        <label for="codCliente">Estado</label>
                                        <input type="text" id="codCliente" name="codCliente" readonly class="form-control">
                                        <label for="telefono">Metodo de Pago</label>
                                        <input type="text" id="telefono" name="telefono" readonly class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <h5>Articulo o Producto</h5>
                                </div>
                                <div class="col" align="end">
                                    <a class="btn btn-outline-warning btn-sm" target="_Blank" href="/">PDF <i
                                            class="fa fa-file"></i></a>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col table-responsive table-hover">
                                    <table class="table">
                                        <thead>
                                            <tr style="background-color: #eff2f7;color: #219D9F">
                                                <th>Nombre</th>
                                                <th>Codigo</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Costo</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Blue Hoodie</th>
                                                <th>P-B</th>
                                                <th>Polo</th>
                                                <th>1</th>
                                                <th>S./ 150</th>
                                                <th>S./ 150</th>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                            <br><br>
                            <div class="alert alert-dismissible alert" style="background-color: #219D9F">
                                <h5 style="color: #fff">Total a Pagar S/.</h5>
                            </div>
                        </div>
    
                    </div>    
            </div>
        </div>                    
    </div>
            
<?php } ?>





    
 <?php include_once "VistaAdmin/pie.php"; ?>
