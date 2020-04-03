<?php
    session_start();

    if(!isset($_SESSION["user-logged"]))
    {
        header("Location: ./index.php");
        die();
    }
    $userData = $_SESSION["user-data"];
    if( !$userData["admin"] )
    {
        header("Location: ./main.php");
        die();
    }

    require_once "./database_connection.php";

    $stmt = $con->query("SELECT nombre,id from eventos;");

    $eventos = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        array_push($eventos,$row);
    }

    function printTable()
    {
        require_once "./database_connection.php";
        $query = "SELECT * FROM  eventos_comprados AS e
                    INNER JOIN usuarios AS u ON e.username_comprador = u.username";
        $stmt = $con->query( $query );
        ?>  
            <table id="tabla-de-eventos">
            <thead>
                <tr>
                    <th> Nombre </th>
                    <th> Apellido </th>
                    <th> Cedula </th>
                    <th> Nombre de Evento </th>
                    <th> Ubicacion </th>
                    <th> Acciones </th>
                </tr>
            </thead>

        <?php
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
        {
            ?>
                <tr>
                    <td> <?php echo $row["nombre"] ?> </td>
                    <td> <?php echo $row["apellido"] ?>  </td>
                    <td> <?php echo $row["cedula"] ?>  </td>
                    <td> <?php echo $row["nombre_evento"] ?>  </td>
                    <td> <?php echo $row["ubicacion"] ?>  </td>
                    <td>  
                        <a href=""> <img class="btn-img" src="ver.svg" alt="ver-img"> </a> 
                        <a href=""> <img class="btn-img" src="editar.svg" alt="editar-img"> </a> 
                        <a href=""> <img class="btn-img" src="borrar.svg" alt="borrar-img"> </a> 
                    </td>
                </tr>
            <?php
        }
        echo "</table>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> admin </title>
    <link rel="stylesheet" href="admin_style.css">
    <script src="./admin.js"></script>
</head>
<body>
    <header>
        <h1> Panel Admin </h1>
        <div id="acciones">
            <a class="btn-header" href="main.php"> Registrar Boleto </a>
            <a class="btn-header" href="agregar_evento.php"> Agregar Evento </a>
            <a class="btn-header" href="cerrar_sesion.php"> Cerrar Sesión </a>
            
        </div>
        
    </header>
    <div id="main">
        <h1>Listado de eventos</h1>


    </div>


    <template id="evento-row-template">
        <tr>
            <td class="td-field-nombre_comprador"> </td>
            <td class="td-field-apellido"> </td>
            <td class="td-field-cedula"> </td>
            <td class="td-field-nombre_evento"> </td>
            <td class="td-field-ubicacion"> </td>
            <td>  
                <button title="ver detalles del registro" class=" table-btn-show"> 
                    <img class="btn-img" src="ver.svg" alt="ver-img"> 
                </button> 
                <button title="editar registro" class="table-btn-edit"> 
                    <img class="btn-img" src="editar.svg" alt="editar-img"> 
                </button> 
                <button title="eliminar registro" class="table-btn-delete"> 
                    <img class="btn-img" src="borrar.svg" alt="borrar-img"> 
                </button>  
            </td>
        </tr>
    </template>


    <template id="show-datos-template">
        <tr class="registro-data-tr">
            <td colspan="6">
                <header>
                    <h3> Datos de Compra </h3>
                    <button class="close-btn"> Cerrar Ventana </button>
                </header>

                <main class="information-container">
                    <div>
                        <h4>Datos de Evento</h4>
                        <ul class="lista-dato" >
                            <li><span> serial : </span><span class="info-serial info-span"></span> </li>
                            <li><span> nombre de evento : </span><span class="info-nombre_evento info-span"></span> </li>
                            <li><span> fecha : </span><span class="info-fecha info-span"> </span></li>
                            <li><span> ubicacion : </span><span class="info-ubicacion info-span"></span> </li>
                        </ul>
                    </div>

                    <div>
                        <h4>Datos de Usuario <span class="info-username info-span"></span> </h4>
                        <ul class="lista-datos" >
                            <li><span> nombre : </span><span class="info-nombre_comprador info-span"></span> </li>
                            <li><span> apellido : </span><span class="info-apellido info-span"></span> </li>
                            <li><span> cedula : </span><span class="info-cedula info-span"></span> </li>
                            <li><span> direccion : </span><span class="info-direccion info-span"></span> </li>
                            <li><span> sexo : </span><span class="info-sexo info-span"> </span>  </li>
                            <li><span> telefono : </span><span class="info-telefono info-span"></span> </li>
                            <li><span> email : </span><span class="info-email info-span"></span>  </li>   
                        </ul>
                    </div>
                </main>
            </td>
        </tr>
    </template>

    <template id="edit-data-template">
        <tr class="edit-data-tr">
            <td colspan="6">
                <div>
                    <header>
                        <h3> Editar Data </h3>
                    </header>
                        <main>
                            <form>
                                <div>
                                    <div class="form-group"> 
                                        <label for="comprador-username-input"> Comprador (username) </label>
                                        <select name="username" id="comprador-username-input">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="evento-input"> Evento </label>
                                        <select name="evento" id="evento-input">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="serial-input"> Numero de Serial del boleto </label>
                                        <input type="number" name="serial"   id="serial-input">
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label for="fecha-input"> Fecha del evento </label>
                                        <input type="date" name="fecha"   id="fecha-input">
                                    </div>
                                    <div class="form-group">
                                        <label for="ubicacion-input"> Ubicacion </label>

                                        <select name="ubicacion" id="ubicacion-input">
                                            <option value="altos" selected> Altos </option>
                                            <option value="medios"> Medios </option>
                                            <option value="vip"> VIP </option>
                                            <option value="platino"> Platino </option>
                                        </select>
                                    </div>
                                    <button type="submit"> Aplicar Cambios </button>
                                </div>
                            </form>
                    </main>
                </div>
            </td>
        </tr>
    </template>

</body>
</html>