<?php 
include_once("../../Estructura/CabeceraSegura.php"); 
?>
<main class="flex-fill bg-light">
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center"> 
                <h1 class="display-5 pb-3 fw-bold">Mis compras</h1>
                <a href="../index.php" class="btn btn-outline-secondary btn-sm">Volver</a> 
            </div>

            <p class="lead">Pulse los botones para realizar las acciones que desee.</p>

            <div class="d-flex justify-content-center">
                <table id="dgSeg" class="easyui-datagrid" style="width:900px"
                        url="accion/listarCompraEstadoCliente.php"
                        toolbar="#toolbarSeg"
                        rownumbers="true" fitColumns="true" singleSelect="true">
                    <thead>
                        <tr>
                            <th field="idcompraestado" width="85">Id Compra Estado</th>
                            <th field="idcompra" width="50">Id Compra</th>
                            <th field="idcompraestadotipo" width="107">Id Compra Estado Tipo</th>
                            <th field="cetdescripcion" width="90">Estado</th>
                            <th field="cefechaini" width="100">Fecha de Inicio</th>
                            <th field="cefechafin" width="100">Fecha de Fin</th>
                            <th field="usnombre" width="70">Comprador</th>
                        </tr>
                    </thead>
                </table>
                <div id="toolbarSeg">
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="cancelarCompraCliente()">Cancelar Compra</a>
                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="verDetalleCliente()">Detalles de la Compra</a></div>
                <div id="dlgSeg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlgSeg-buttons'">
                    <form id="fmSeg" method="post" novalidate style="margin:0;padding:20px 50px">
                        <h3>Informacion de la Compra</h3>
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
    </div>
</main>

<?php include(STRUCTURE_PATH . "pie.php"); ?>