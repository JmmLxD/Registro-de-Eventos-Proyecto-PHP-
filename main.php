<?php
    session_start();
    if(isset($_POST["delete-all"]))
    {
        session_unset();
    }
    $userData = null;
    if( !isset($_SESSION["user-logged"]) )
    {
        header("Location: ./index.php");
        die();
    }
    else
        $userData = $_SESSION["user-data"];

    require_once "./database_connection.php";

    $stmt = $con->query("SELECT nombre,id from eventos;");

    $eventos = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        array_push($eventos,$row);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Eventos </title>

    <style>

        *
        {
            box-sizing: border-box;
        }

        body > header
        {
            padding: 0 3rem;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: #ffcc00;
        }   

        body , html 
        {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%
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

        main > h2
        {
            color: rgb(68, 95, 6);
            font-size: 1.2rem;
            margin: 0;
        }

        main
        {
            padding: 1rem;
            margin:  0 auto;
            margin-top: 2rem;
            border: 1px solid black;
        }

        @media (max-width: 1000px) 
        { 
            main
            {
                width: 93%;
            }
        }

        @media (min-width: 1000px) 
        { 
            main
            {
                width: 70%;
            }
        }


        @media (max-width: 600px) 
        { 
            .fields
            {
                width: 100% !important;
            }

            .form-image
            {  
                display: none;
            }
        }


        .fields
        {
            display: flex;
            flex-direction: column;
        }    

        form
        {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .fields
        {
            width: 60%;
        }

        .form-image
        {
            margin: 0;
            width: 35%;
        }

        .form-image img
        {
            margin: 0;
            width: 100%;
        }
        
        form 
        {
            padding: 0 1rem;
        }

        form input , form select 
        {
            
            display: block;
            width: 80%;
            margin: 0.5rem 0rem;
        }    

        button 
        {
            margin-top: 0.8rem;
            font-size: 1.2rem;
            color : rgb(29, 29, 29);
            background-color: #FFCC00;
            border: solid 1px  #EEBB00 ;
            border-radius: 0.4rem;
            padding: 0.2rem 0.6rem;
        }


    </style>
</head>
<body>
    <header>
        <h1> Registro De Eventos </h1>
        <div id="acciones">
            <?php if( $userData["admin"] ) { ?>
                <a class="btn-header" href="admin.php"> CRUD de Registros </a>
                <a class="btn-header" href="agregar_evento.php"> Agregar Evento </a>
            <?php } ?>
            <a class="btn-header" href="cerrar_sesion.php"> Cerrar Sesión </a>
        </div>
    </header>

    <main>
        <h2> Datos de Evento </h2>
        <p> Bienvenido al registro de eventos <span class="username-span" > <?php echo $userData["username"] ?> </span> 
            ,  Ingrese los datos del boleto que compro  </p>
        <form action="registro_evento.php" method="POST">
            <div class="fields">
                <div>
                    <label for="evento-input"> Nombre </label>
                    <select name="evento" id="evento-input">

                        <?php 
                            foreach($eventos as $evento )
                            {
                                echo '<option value="' . $evento['id'] . '" >' .  $evento['nombre'] . '</option>';
                            }
                        
                        
                        ?>
                    </select>
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
            </div>
            <div class="form-image">
                <img src="tiketo.jpg" alt="imagen_tiket">
            </div>
            <button type="submit"> Enviar datos </button>
        </form>
    </main>
</body>
</html>