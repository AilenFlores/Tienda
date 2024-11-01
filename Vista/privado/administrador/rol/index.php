<?php 
include_once("../../../Estructura/CabeceraSegura.php"); 
$datos = data_submitted();
$datos['accion'] = "listar";
include_once("accion.php");
?>
<main class="flex-fill bg-light">
    <!-- Mensajes -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php 
            if (isset($datos['msg']) && $datos['msg'] != null) {
                $alertType = 'info';
                echo "<div class='alert alert-$alertType text-center' role='alert'>";
                echo htmlspecialchars($datos['msg']);
                echo "</div>";
            }
            ?>
        </div>
    </div>
    
    <!-- Lista de Personas -->
    <div class="container my-4">
        <div class="card shadow-sm" style="border: 1px solid #ced4da;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-primary">Lista de Roles:</h5>
                    <a class="btn btn-success" role="button" href="editar.php?accion=nuevo">Agregar Rol Nuevo</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm"> 
                        <thead class="table-secondary"> 
                            <tr>
                                <th scope="col">ID Rol</th>
                                <th scope="col">Nombre Rol</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($lista) && count($lista) > 0) {
                                foreach ($lista as $menuObj) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($menuObj['idRol']); ?></td>
                                        <td><?php echo htmlspecialchars($menuObj['roDescripcion']); ?></td>                   
                                        <td class="text-center">
                                                <a class="btn btn-info btn-sm" role="button" href="editar.php?accion=editar&idrol=<?php echo htmlspecialchars($menuObj['idRol']); ?>">Editar</a>
                                                <a class="btn btn-danger btn-sm" role="button" href="accion.php?accion=borrar&idRol=<?php echo htmlspecialchars($menuObj['idRol']); ?>" onclick="return confirm('¿Está seguro de que desea borrar este menú?');">Borrar</a>
                                        </td>
                                    </tr>
                            <?php 
                                }
                            } else {
                                echo '<tr><td colspan="7" class="alert alert-info text-center">No se encontraron registros.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include(STRUCTURE_PATH . "pie.php"); ?>
