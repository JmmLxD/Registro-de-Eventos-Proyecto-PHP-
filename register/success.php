<?php
    session_start();
    $registerWasMade = isset($_SESSION["register-made"]);
    $registerData = null;
    if($registerWasMade)
        $registerData = $_SESSION["register-data"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php if($registerWasMade) { ?>
        <h1>everything went kind of ok</h1>
        <ul>
            <li>
                <p> Nombre : <?php echo $registerData["nombre"] ?> </p>
            </li>
            <li>
                <p> Apellido : <?php echo $registerData["apellido"] ?> </p>
            </li>
            <li>
                <p> Cedula : <?php echo $registerData["cedula"] ?> </p>
            </li>
            <li>
                <p> Telefono : <?php echo $registerData["telefono"] ?> </p>
            </li>
            <li>
                <p> Email : <?php echo $registerData["email"] ?> </p>
            </li>
            <li>
                <p> Sexo : <?php echo $registerData["sexo"] ?> </p>
            </li>
        </ul>
    <?php } else { ?>
        <h1>everything went kind of awaful</h1>
    <?php } ?>
</body>
</html>