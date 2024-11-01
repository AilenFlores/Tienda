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
            if (isset($datos) && isset($datos['msg']) && $datos['msg'] != null) {
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
                    <h5 class="mb-0 text-primary">Lista de Menus:</h5>
                    <a class="btn btn-success" role="button" href="editar.php?accion=nuevo">Agregar Menu Nueva</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm"> 
                        <thead class="table-secondary"> 
                            <tr>
                                <th scope="col">ID Menu</th>
                                <th scope="col">Nombre Menu</th>
                                <th scope="col">URL</th>
                                <th scope="col">ID Menu Padre</th>
                                <th scope="col">Permisos</th> <!-- Columna para el rol -->
                                <th scope="col" class="text-center">Estado</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($lista) && count($lista) > 0) {
                                foreach ($lista as $objMenu) {
                                    // Depuración de los valores de personaObj
                                    $estado = $objMenu["medeshabilitado"] === NULL ? "Activo" : "Deshabilitado";
                                    $estadoClass = $estado === "Activo" ? "text-success" : "text-danger"; 
                                    $objRol = new AbmRol();
                                    $rolesExits = convert_array($objRol->buscar(null)); // Obtener todos los roles 
                                    $roles = $objMenu["usRol"]; // Roles actuales del usuario
                                    if (count($roles) > 0) { 
                                        $rolesUsu = [];
                                        foreach ($roles as $rol) {
                                            foreach ($rolesExits as $roleData) {
                                                if ($roleData['idRol'] == $rol) { // Si el rol actual del usuario coincide con el rol actual
                                                    $rolesUsu[] = $roleData['roDescripcion']; 
                                                }
                                            }
                                        }
                                    }
                                    
                                    // Ahora $rolesUsu contiene las descripciones de los roles del usuario

                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($objMenu['idmenu']); ?></td>
                                        <td><?php echo htmlspecialchars($objMenu['menombre']); ?></td>
                                        <td><?php echo htmlspecialchars($objMenu['medescripcion']); ?></td>
                                        <td><?php echo htmlspecialchars($objMenu["objmenu"]);?></td>
                                        <td><?php echo htmlspecialchars(implode(', ', $rolesUsu)); ?></td> 
                                        <td class="text-center <?php echo $estadoClass; ?>"><?php echo $estado; ?></td>
                                        <td class="text-center">
                                            <?php if($estado == "Activo") { ?>
                                                <a class="btn btn-info btn-sm" role="button" href="editar.php?accion=editar&idmenu=<?php echo htmlspecialchars($objMenu['idmenu']); ?>">Editar</a>
                                                <a class="btn btn-danger btn-sm" role="button" href="accion.php?accion=borrar&idmenu=<?php echo htmlspecialchars($objMenu['idmenu']); ?>" onclick="return confirm('¿Está seguro de que desea borrar esta persona?');">Borrar</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                            <?php 
                                }
                            } else {
                                echo '<tr><td colspan="6" class="alert alert-info text-center">No se encontraron registros.</td></tr>';
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
