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
    <style>
        .tabla-de-eventos
        {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .tabla-de-eventos , .tabla-de-eventos tr ,.tabla-de-eventos td ,.tabla-de-eventos th
        {
            border: grey 1px solid; 
        }

        .tabla-de-eventos td , .tabla-de-eventos th
        {
            padding: 0.3rem;
            text-align: center;
        } 

        .btn-img 
        {
            width:2rem;
        }

        body , html 
        {
            
            font-family: Arial, Helvetica, sans-serif;
            margin : 0;
            padding: 0;
        }
        #main
        {
            width: 70%;
            margin:  0 auto;
        }
        #tabla-de-eventos thead th:nth-child(1) { width: 15%; }
        #tabla-de-eventos thead th:nth-child(2) { width: 15%; }
        #tabla-de-eventos thead th:nth-child(3) { width: 8%; }
        #tabla-de-eventos thead th:nth-child(4) { width: 30%; }
        #tabla-de-eventos thead th:nth-child(5) { width: 15%; }
        #tabla-de-eventos thead th:nth-child(5) { width: 7%; }
        #tabla-de-eventos thead th:nth-child(6) { width: 12%; }

        body header
        {
            padding: 0 3rem;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: #ffcc00;
        }   

        header h1
        {
            color: #222;
        }

        .btn-header
        {
            border-bottom: #222 solid 2px;
            display: inline-block;
            margin: 0 1rem;
            font-size: 1.2rem;

            color: #222;
            text-decoration: none;
        }
        .btn-header:visited
        {
            color: #222;
        }
        .btn-header:hover
        {
            color: #666;
        }

        .data-tr 
        {
            column-span: all;
        }

        .evento-data-tr ul
        {
            padding:0;
            text-align: left;
            margin: 0;
            list-style: none;
        }

        .evento-data-tr h3 ,  .evento-data-tr p
        {
            text-align: left;
        }

    </style>

    <script src="./admin.js"></script>
</head>
<body>
    <header>
        <h1> Registro para Eventos </h1>
        <div id="acciones">
            <a class="btn-header" href=""> Registro de Eventos </a>
            <a class="btn-header" href="cerrar_sesion.php"> Cerrar Sesión </a>
        </div>
        
    </header>
    <div id="main">
        <h1>Listado de eventos</h1>


    </div>


    <template id="evento-row-template">
        <tr class="evento-data-tr">
            <td class="td-field-nombre"> </td>
            <td class="td-field-apellido"> </td>
            <td class="td-field-cedula"> </td>
            <td class="td-field-nombre_evento"> </td>
            <td class="td-field-ubicacion"> </td>
            <td>  
                <button class="table-btn-show"> <img class="btn-img" src="ver.svg" alt="ver-img"> </button> 
                <button class="table-btn-edit"> <img class="btn-img" src="editar.svg" alt="editar-img"> </button> 
                <button class="table-btn-delete"> <img class="btn-img" src="borrar.svg" alt="borrar-img"> </button>  
            </td>
        </tr>
    </template>


    <template id="show-datos-template">
        <tr class="evento-data-tr">
            <td colspan="6">
                <div>
                    <h3> Datos de Compra </h3>
                    <p>Datos de Evento</p>
                    <ul class="lista-datos" >
                        <li> serial : <span class="info-serial info-span"></span> </li>
                        <li> nombre de evento : <span class="info-nombre_evento info-span"></span> </li>
                        <li> fecha : <span class="info-fecha info-span"> </span></li>
                        <li> ubicacion : <span class="info-ubicacion info-span"></span> </li>
                    </ul>
                    <p>Datos de Usuario <span class="info-username info-span"></span> </p>
                    <ul class="lista-datos" >
                        <li> nombre : <span class="info-nombre info-span"></span> </li>
                        <li> apellido : <span class="info-apellido info-span"></span> </li>
                        <li> cedula : <span class="info-cedula info-span"></span> </li>
                        <li> direccion : <span class="info-ubicacion info-span"></span> </li>
                        <li> sexo : <span class="info-sexo info-span"> </span>  </li>
                        <li> telefono : <span class="info-telefono info-span"></span> </li>
                        <li> email : <span class="info-email info-span"></span>  </li>   
                    </ul>
                    <button class="close-btn"> Cerrar Data </button>
                </div>
            </td>
        </tr>
    </template>

    <template id="edit-data-template">
        <tr class="edit-data-tr">
            <td colspan="6">
                <div>
                    <h3> Editar Data </h3>
                    <form>
                        <div>
                            <label for="comprador-username-input"> Comprador (username) </label>
                            <input type="text" name="username-comprador" id="comprador-username-input"> 
                        </div>
                        <div>
                            <label for="nombre-input"> Nombre </label>
                            <input type="text" name="nombre" id="nombre-input"> 
                        </div>
                        <div>
                            <label for="serial-input"> Numero de Serial del boleto </label>
                            <input type="number" name="serial"   id="serial-input">
                        </div>
                        <div>
                            <label for="fecha-input"> Fecha del evento </label>
                            <input type="date" name="fecha"   id="fecha-input">
                        </div>
                        <div>
                            <label for="ubicacion-input"> Ubicacion </label>

                            <select name="ubicacion" id="ubicacion-input">
                                <option value="altos" selected> Altos </option>
                                <option value="medios"> Medios </option>
                                <option value="vip"> VIP </option>
                                <option value="platino"> Platino </option>
                            </select>
                        </div>
                        <button type="submit"> Aplicar Cambios </button>
                    </form>
                </div>
            </td>
        </tr>
    </template>

</body>
</html>