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
        #tabla-de-eventos
        {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        #tabla-de-eventos , #tabla-de-eventos tr ,#tabla-de-eventos td ,#tabla-de-eventos th
        {
            border: grey 1px solid; 
        }

        #tabla-de-eventos td , #tabla-de-eventos th
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

    </style>
</head>
<body>
    <header>
        <h1> Registro para Eventos </h1>
        <div id="acciones">
            <a class="btn-header" href=""> Registro de Eventos </a>
            <a class="btn-header" href=""> Cerrar Sesión </a>
        </div>
        
    </header>
    <div id="main">
        <h1>Listado de eventos</h1>

        <?php  printTable() ?>

    </div>
</body>
</html>