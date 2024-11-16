<?php 
include_once("../../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <!-- Encabezado: Título y botón -->
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h1 class="display-5 pb-3 fw-bold">Mis compras</h1>
                
                <a href="../index.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            <!-- Descripción -->
            <div class="px-4">
                <p class="lead">Pulse los botones para realizar las acciones que desee.</p>
            </div>

            <!-- Contenedor para centrar la tabla -->
            <div class="d-flex justify-content-center mt-4">
                <table id="dgSeg" class="easyui-datagrid" style="width:1000px; max-width: 100%;"
                        url="accion/listarCompraEstadoCliente.php"
                        toolbar="#toolbarSeg"
                        rownumbers="true" fitColumns="true" singleSelect="true">
                    <thead>
                        <tr>
                            <th field="idcompraestado" width="100">Id Compra Estado</th>
                            <th field="idcompra" width="70">Id Compra</th>
                            <th field="idcompraestadotipo" width="107">Id Compra Estado Tipo</th>
                            <th field="cetdescripcion" width="90">Estado</th>
                            <th field="cefechaini" width="100">Fecha de Inicio</th>
                            <th field="cefechafin" width="100">Fecha de Fin</th>
                            <th field="usnombre" width="70">Comprador</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Botones debajo de la tabla -->
            <div id="toolbarSeg" class="d-flex justify-content-start mt-3">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="cancelarCompraCliente()">Cancelar Compra</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="verDetalleCliente()">Detalles de la Compra</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="descargarPdf()">PDF</a>
            </div>

            <!--<div class="d-flex justify-content-between align-items-center mb-3">
                    <a class="btn btn-primary" role="button" href="../usuario/accion/generarPdfCliente.php">PDF</a>
                </div>-->

            <!-- Diálogo de información -->
            <div id="dlgSeg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlgSeg-buttons'">
                <form id="fmSeg" method="post" novalidate style="margin:0;padding:20px 50px">
                    <h3>Información de la Compra</h3>
                    <div>
                        <input type="hidden" name="idcompraestado" value="idcompraestado">
                    </div>
                    <div>
                        <input type="hidden" name="idcompra" value="idcompra">
                    </div>
                    <div>
                        <input type="hidden" name="idcompraestadotipo" value="idcompraestadotipo">
                    </div>
                    <div>
                        <input type="hidden" name="cefechaini" value="cefechaini">
                    </div>
                    <div>
                        <input type="hidden" name="cefechafin" value="cefechafin">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>




<?php include(STRUCTURE_PATH . "pie.php"); ?>