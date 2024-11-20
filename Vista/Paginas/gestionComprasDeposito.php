Jazz Loureiro
jazz.loureiro
En línea

Agustina Flores — hoy a las 13:00
ahora me voy a fijar y te aviso si lo puedo resolver
Jazz Loureiro — hoy a las 13:01
oka, igual ahi veo si queres que logica se podria poner
habria que agregar en el abm una funcion
que elimine de a uno, o modificar la que elimina el tiem del carrito para que tambien elimine de a uno
Agustina Flores — hoy a las 19:49
Ya volví a mi casa y pude probar todo y funciona bien todo
Lo de los mails más q nada no lo había podido probar
Lo único q me quedo como medio q no me convence es que no tenemos nada para pagar
Voy a ver si implementó eso ahora medio simple
Jazz Loureiro — hoy a las 19:55
Sabes que pensé lo mismo la otra vez
Pero como que sería raro que pagues y que después te la puedan cancelar
Igual se puede implementar porque creí que hay una librería que simula
O algo así vi en las opciones que librerías que puso la profe en pedco
Jazz Loureiro — hoy a las 19:57
Por el tema de los estados digo, que puede ir cambiando luego de comprar
Agustina Flores — hoy a las 19:57
en todo caso se puede hacer q cuando cancele el mail diga que alguien se va a comunicar con el usuario para la devolucion del dinero
se me ocurre
Jazz Loureiro — hoy a las 19:58
Ah sí, podría ser
Bueno si querés hoy venís de implementarla
Pero si se complica no, porque miedo de mandarnisla
Agustina Flores — hoy a las 19:58
tampoco gran cosa porque no lo piden en el tp ni hay nada q lo relacione
Jazz Loureiro — hoy a las 19:58
Cuando ya está listo casi
Agustina Flores — hoy a las 19:58
voy a ver q se me ocurre
Jazz Loureiro — hoy a las 20:00
Claro por eso, pero bueno sonos manijas jajaja con que quede todo perfecto
Yo ahora en un rato llego a casa si querés vemos
Jazz Loureiro — hoy a las 20:46
Eyyy
Subieron para anotar is el horario
Anotarnos*
Nos anotamos ya? I vemos cuando nos juntemos o mañana bien si llegamos a armar todo
Agustina Flores — hoy a las 21:13
si queres nos anotamos de una
x las dudas
Jazz Loureiro — hoy a las 21:14
Dale dale
Elegimos el jueves?
Hay solo un grupo anotado a las cinco
Ese día hay clases hasta las seis y media
Agustina Flores — hoy a las 21:15
el jueves 17:30?
tipo vemos de paso como es
y capaz a esa hora ya se divide x discord
Jazz Loureiro — hoy a las 21:17
Dale dale
Que ansiedad lpm
Nos anotó?
Agustina Flores — hoy a las 21:21
dale porfi
Jazz Loureiro — hoy a las 21:22
Listo ahí después desde la compu cambio el tamaño de la letra jajaja quedo enorme
Agustina Flores — hoy a las 21:38
dale, entonces nos juntamos hoy?
como para organizarme x la hora
Jazz Loureiro — hoy a las 21:40
Sisi
Yo ya estoy, recién terminé de cenar, asi que avísame cuando puedasss
Agustina Flores — hoy a las 21:46
dale ya estoy
https://meet.google.com/brk-guyb-jtu
Jazz Loureiro — hoy a las 21:47
Dale ahí prendo la compu
Ahí entro
Agustina Flores — hoy a las 21:47
okis
Jazz Loureiro — hoy a las 23:09
Fabricado en polietileno, se distingue por su moderno diseño y excelente terminación.
Agustina Flores — hoy a las 23:18
<?php 
include_once("../Estructura/CabeceraSegura.php");
?>
<title>Basic CRUD  - Menu y Menu Rol </title>

<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">
Expandir
message.txt
5 KB
<?php 
include_once("../Estructura/CabeceraSegura.php");
?>
<title>Basic CRUD  - Menu y Menu Rol </title>

<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">
Expandir
message.txt
5 KB
﻿
<?php 
include_once("../Estructura/CabeceraSegura.php");
?>
<title>Basic CRUD  - Menu y Menu Rol </title>

<h2 style="text-align: center; font-size: 24px; color: #333; margin-bottom: 20px; font-weight: bold;">
    Gestión - Compra
</h2>

<!-- Tabla para gestionar CompraEstado -->
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
   <!-- Contenedor centrado para la tabla -->
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <table id="dg" title="Administrador de Compra-Estado" class="easyui-datagrid" style="width:1200px;height:350px;"
           url="../accion/listarCompraEstado.php"
           toolbar="#toolbar" pagination="true"
           rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="idcompraestado" width="50">Id Compra Estado</th>
                <th field="idcompra" width="40">Id Compra</th>
                <th field="idcompraestadotipo" width="65">Id CompraEstadoTipo</th>
                <th field="cetdescripcion" width="40">Estado</th>
                <th field="cefechaini" width="55">Fecha de inicio</th>
                <th field="cefechafin" width="50">Fecha de fin</th>
                <th field="usnombre" width="50">Comprador</th>
            </tr>
        </thead>
    </table>
</div>


    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="siguienteEstadoDeposito()">Siguiente Estado</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="cancelarCompraEstadoDeposito()">Cancelar Compra</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="muestraDetalleCompra()">Detalles de la Compra</a>
    </div>

    <div id="dlgCompraEstado" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlgCompraEstado-buttons'">
        <form id="fmCompraEstado" method="post" novalidate style="margin:0;padding:20px 50px">
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
            <div>
                <input type="hidden" name="usnombre" value="">
            </div>
        </form>
    </div>
    <div id="dlgCompraEstado-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCompraEstado()" style="width:90px">Guardar</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCompraEstado').dialog('close')" style="width:90px">Cancelar</a>
    </div>
</div>
<br>

<!-- Tabla para mostrar el detalle de la compra -->

<div id="dlgDetalleCompra" class="easyui-dialog" style="width:600px;" data-options="closed:true,modal:true,border:'thin',buttons:'#dlgDetalleCompra-buttons'">
    <table id="detalleCompraTable" style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px;">Producto</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Cantidad</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Precio Unitario</th>
                <th style="border: 1px solid #ddd; padding: 8px;">Precio Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- Se llenará dinámicamente con JavaScript -->
        </tbody>
    </table>
    <div id="totalCompra" style="text-align: right; font-weight: bold; margin-top: 10px;">Total de la Compra: 0</div>
</div>

<?php include(STRUCTURE_PATH . "pie.php"); ?>