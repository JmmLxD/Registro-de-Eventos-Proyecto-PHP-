<?php
    session_start();
    require_once "./database_connection.php";
    if( !registerDataIsSet() )
    {
        $_SESSION["errores-registro"] = [];
        if( $_POST["nombre"] == "" )
            array_push($_SESSION["errores-registro"],"el campo de nombre esta vacio");
        if( $_POST["username"] == "" )
            array_push($_SESSION["errores-registro"],"el campo de username esta vacio");
        else
            {
                $query = "SELECT COUNT(*) AS c FROM usuarios WHERE username = :username";
                $stmt = $con->prepare($query);
                $stmt->execute(  [ "username" => $_POST["username"]  ] );
                $count = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]["c"];
                if($count > 0)
                    array_push($_SESSION["errores-registro"],"nombre de usuario ya existe");
            }
        if( $_POST["cedula"] == "" )
            array_push($_SESSION["errores-registro"],"el campo de cedula esta vacio");
        if( $_POST["apellido"] == "" )
            array_push($_SESSION["errores-registro"],"el campo de apellido esta vacio");
        if( $_POST["password"] == "" )
            array_push($_SESSION["errores-registro"],"el campo de password esta vacio");
        if( $_POST["email"] == "" )
            array_push($_SESSION["errores-registro"],"el campo de email esta vacio");
        if( $_POST["telefono"] == "" )
            array_push($_SESSION["errores-registro"],"el campo de telefono esta vacio");
        if( $_POST["direccion"] == "" )
            array_push($_SESSION["errores-registro"],"el campo de direccion esta vacio");

        if( count($_SESSION["errores-registro"]) == 0 )
        {
            $query = "insert into usuarios 
            (username,password,nombre,apellido,cedula,telefono,email,sexo,direccion)
            values (:username,:password,:nombre,:apellido,:cedula,:telefono,:email,:sexo,:direccion)";
            $stmt = $con->prepare( $query );
            $_POST = [ "username" => $_POST["username"],  "nombre" => $_POST["nombre"],  "apellido" => $_POST["apellido"], 
                    "cedula" => $_POST["cedula"], "password" => $_POST["password"],  "telefono" => $_POST["telefono"], 
                    "email" => $_POST["email"],  "sexo" => $_POST["sexo"] , "direccion" => $_POST["direccion"] ];
            if(!$stmt->execute($_POST))
            {
                array_push($_SESSION["errores-registro"],"ups error interno de server , vuelva a intentarlo mas tarde");
                header("Location: ./index.php");
                die();
            }
        }
        else
        {
            header("Location: ./index.php");
            die();
        }

    }
    else
    {
        header("Location: ./index.php");
        die();
    }
        function registerDataIsSet()
        {
            return  ( !isset($_POST["username"]) && !isset($_POST["nombre"]) && !isset($_POST["apellido"]) && !isset($_POST["cedula"]) &&
                      !isset($_POST["password"]) && !isset($_POST["telefono"]) && !isset($_POST["email"])  && !isset($_POST["sexo"])) 
                     && !isset($_POST["direccion"]);
        }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <h1>Registro Exitoso!</h1>
        <ul>
            <li>
                <p> Nombre : <?php echo $_POST["nombre"] ?> </p>
            </li>
            <li>
                <p> Apellido : <?php echo $_POST["apellido"] ?> </p>
            </li>
            <li>
                <p> Cedula : <?php echo $_POST["cedula"] ?> </p>
            </li>
            <li>
                <p> Telefono : <?php echo $_POST["telefono"] ?> </p>
            </li>
            <li>
                <p> Email : <?php echo $_POST["email"] ?> </p>
            </li>
            <li>
                <p> Sexo : <?php echo $_POST["sexo"] ?> </p>
            </li>
            <li>
                <p> Direccion : <?php echo $_POST["direccion"] ?> </p>
            </li>
        </ul>
</body>
</html>