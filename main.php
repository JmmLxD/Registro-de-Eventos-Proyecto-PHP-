<?php
    session_start();
    $userIsLogged = isset($_SESSION["user-logged"]);
    $userData = null;
    if($userIsLogged)
        $userData = $_SESSION["user-data"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php if($userIsLogged) { ?>
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
    <?php } else { ?>
        <h1>everything went kind of awaful</h1>
    <?php } ?>
</body>
</html>