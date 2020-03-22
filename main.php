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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        form
        {
            border: solid 1px grey;
            padding: 1rem;
        }    
    </style>
</head>
<body>

    <form action="main.php" method="POST">
        <input type="hidden" name="delete-all" value="true">
        <button type="submit"> cerrar seccion </button>
    </form>
    <h1>everything went kind of ok</h1>
    <ul>
        <li>
            <p> Nombre : <?php echo $userData["nombre"] ?> </p>
        </li>
        <li>
            <p> Apellido : <?php echo $userData["apellido"] ?> </p>
        </li>
        <li>
            <p> username : <?php echo $userData["username"] ?> </p>
        </li>
        <li>
            <p> Telefono : <?php echo $userData["telefono"] ?> </p>
        </li>
    </ul>


    <form action="validate-compra-evento.php" method="POST">
        <h2> Compra de Evento </h2>
        <div>
            <label for="nombre-input"> Nombre </label>
            <input type="text" name="nombre"   id="nombre-input">
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

        <button type="submit"> Enviar datos </button>
    </form>

    <?php 
    
    if( $userData["admin"] )
    {
        echo "<a href='./admin.php'> Opciones de Admin  </a>";
    }
    
    ?>


</body>
</html>